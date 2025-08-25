<?php

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Models\Sources\WebsiteButtonModel;
use AmoCRM\Models\Sources\WebsiteButtonCreateRequestModel;
use AmoCRM\Models\Sources\WebsiteButtonUpdateRequestModel;
use AmoCRM\OAuth2\Client\Provider\AmoCRM;
use AmoCRM\OAuth2\Client\Provider\AmoCRMException;
use League\OAuth2\Client\Grant\AuthorizationCode;
use League\OAuth2\Client\Token\AccessToken;
use GuzzleHttp\Exception\GuzzleException;
use League\OAuth2\Client\Token\AccessTokenInterface;
use WebsiteChatButtonKommoIntegration\PluginRESTController;

if (!defined('ABSPATH')) {
	exit();
};

class KommoFlashFunctions
{
    public static array $ERROR_PLUGIN_DEFAULT = ['title' => '', 'text' => ''];
    public static array $ERROR_KOMMOFLASH_DEFAULT = ['title' => '', 'text' => ''];

    public AmoCRMApiClient $apiClient;
    public AccessToken $apiAccessToken;

    private int $pipelineIdFirst = 0;

    public static function setErrors()
    {
        $errors = [
            'default' => [
                'plugin' => [
                    'title' => __('Plugin error', 'website-chat-button-kommo-integration'),
                    'text' => __('Try again or contact ', 'website-chat-button-kommo-integration') . ' ' . KOMMOFLASH_TEXT_SUPPORT_NAME,
                ],
                'server' => [
                    'title' => __('Kommo server is not responding', 'website-chat-button-kommo-integration'),
                    'text' => __('We already know about the problem and are solving it', 'website-chat-button-kommo-integration'),
                ],
            ],
        ];

        self::$ERROR_PLUGIN_DEFAULT = $errors['default']['plugin'];
        self::$ERROR_KOMMOFLASH_DEFAULT = $errors['default']['server'];
    }

    public static function showError($text)
    {
        $_SESSION['kommoflash']['notifications']['show_modal_error_log'] = [
            'title' => $text['title'],
            'text' => $text['text'],
        ];
    }

    public static function includeLibs($path)
    {
        if (file_exists($path . '/vendor/autoload.php')) {
            require_once $path . '/vendor/autoload.php';
        } else {
            self::showError([
                'title' => esc_attr__('PHP Error', 'website-chat-button-kommo-integration'),
                'text' => esc_attr__('Plugin not ready to work. Autoload not exist', 'website-chat-button-kommo-integration'),
            ]);
            exit(esc_attr__('Plugin not ready to work. Autoload not exist', 'website-chat-button-kommo-integration'));
        }
        require_once $path . '/../install.php';
    }

    public static function includeConfig($path)
    {
        if (file_exists($path . '/credentials.php')) {
            require_once $path . '/credentials.php';
        }
        if (file_exists($path . '/config.php')) {
            require_once $path . '/config.php';
        } else {
            self::showError([
                'title' => esc_attr__('PHP Error', 'website-chat-button-kommo-integration'),
                'text' => esc_attr__('Plugin not ready to work. Configuration not found', 'website-chat-button-kommo-integration'),
            ]);
            exit(esc_attr__('Plugin not ready to work. Configuration not found', 'website-chat-button-kommo-integration'));
        }

        KommoFlashFunctions::setErrors();
    }

    public static function redirect($parameters)
    {
        wp_redirect($parameters['location']);
    }

    private static function dbGetJsonOptionValue($option)
    {
        $json = KommoFlashFunctions::getOptionValue($option);

        try {
            $data = json_decode($json, true) ?? [];
        } catch (Exception|Error $e) {
            $data = [];
        }

        return $data;
    }

    private static function dbUpdateTokens($data)
    {
        $updateAccessToken = KommoFlashFunctionsDb::update(['option_value' => $data['access_token']], ['option_name' => 'access_token']);
        $updateTokenRefresh = KommoFlashFunctionsDb::update(['option_value' => $data['refresh_token']], ['option_name' => 'refresh_token']);

        $updateAccessTokenDateExpired = KommoFlashFunctionsDb::update(['option_value' => $data['access_token_date_expired']], ['option_name' => 'access_token_date_expired']);

        if ($updateAccessToken === false || $updateTokenRefresh === false || $updateAccessTokenDateExpired === false) {
            return false;
        }

        return true;
    }

    private static function getApiClient($data, $accountSecrets)
    {
        if (empty($data['access_token']) || empty($data['refresh_token'])) {
            return null;
        }

        $apiClient = (new AmoCRMApiClient(
            $accountSecrets['client_id'],
            $accountSecrets['client_secret'],
            rest_url(PluginRESTController::API_NAMESPACE . PluginRESTController::API_VERSION . '/redirect')
        ));
        $apiClient->setAccountBaseDomain($data['account_sign_referer']);

        return $apiClient;
    }

    public static function getAccessToken()
    {
        $data = KommoFlashFunctions::getOptionsValue([
            'access_token',
            'refresh_token',
            'account_sign_referer',
            'access_token_date_expired',
        ]);

        if (empty($data['access_token']) || empty($data['refresh_token']) ||
            empty($data['access_token_date_expired']) || empty($data['account_sign_referer'])) {
            return null;
        }

        return new AccessToken([
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'],
            'expires' => $data['access_token_date_expired'],
            'baseDomain' => $data['account_sign_referer'],
        ]);
    }

    public function apiInit()
    {
        $data = KommoFlashFunctions::getOptionsValue([
            'access_token',
            'refresh_token',
            'account_sign_referer',
            'access_token_date_expired',
        ]);

        $accountSecrets = self::dbGetJsonOptionValue('account_sign_secrets');

        $accessToken = self::getAccessToken();
        $apiClient = self::getApiClient($data, $accountSecrets);
        if (empty($apiClient) || empty($accessToken)) {
            return;
        }

        $this->apiClient = $apiClient;
        $this->apiClient->setAccessToken($accessToken);
		$this->apiClient->onAccessTokenRefresh(
			function (AccessTokenInterface $accessToken) {
				KommoFlashFunctions::dbUpdateTokens([
					'access_token' => $accessToken->getToken(),
					'refresh_token' => $accessToken->getRefreshToken(),
					'access_token_date_expired' => $accessToken->getExpires(),
				]);
			}
		);

        $this->apiAccessToken = $accessToken;

        $pipelines = $this->apiFetch(KOMMOFLASH_API_PIPELINE_URI_PATHNAME);
        $this->pipelineIdFirst = $pipelines['_embedded']['pipelines'][0]['id'] ?? 0;

        KommoFlashFunctionsDb::update(['option_value' => (int)$this->pipelineIdFirst], ['option_name' => 'account_pipeline_id_first']);
    }

    public static function getAuthState()
    {
        return sprintf(
			'%s_%s_%s',
			md5(wp_rand()),
			urlencode(get_site_url()),
			time()
		);
    }

    public static function setAccountInfo($accountInfo)
    {
        return KommoFlashFunctionsDb::update(['option_value' => wp_json_encode($accountInfo)], ['option_name' => 'account_info']);
    }

    public static function unsetAccountInfo()
    {
        return KommoFlashFunctionsDb::update(['option_value' => null], ['option_name' => 'account_info']);
    }

    public static function getAccountInfo()
    {
        return self::dbGetJsonOptionValue('account_info');
    }

    public static function getAccountSign()
    {
        return self::dbGetJsonOptionValue('account_sign');
    }

    public function setOptionValue($optionName, $optionValue)
    {
        return KommoFlashFunctionsDb::update(['option_value' => $optionValue], ['option_name' => $optionName]);
    }

    public static function getOptionsValue($optionNameList = [])
    {
        $select = KommoFlashFunctionsDb::select('option_name, option_value', $optionNameList);

        return $select;
    }

    public static function getOptionValue($optionName)
    {
        $select = KommoFlashFunctionsDb::select('option_value', $optionName);

        return $select;
    }

    public static function authTokenSave($post)
    {
        $result = [
            'error' => null,
            'data'  => null,
        ];

        if (empty($post['access_token']) || empty($post['refresh_token'])) {
            $result['error'] = 'Empty access or refresh token';
            return $result;
        }

        $accessToken = esc_sql($post['access_token']);
        $accessTokenDateExpired = esc_sql($post['access_token_date_expired']);
        $refresh_token = esc_sql($post['refresh_token']);
        $accountSignReferer = esc_sql($post['account_sign_referer']);
        $accountSign = [
            'type' => esc_sql($post['account_sign']),
            'datetime' => (new DateTime('now'))->format('Y-m-d H:i:s'),
        ];

        try {
            $dbUpdateTokens = self::dbUpdateTokens([
                'access_token' => $accessToken,
                'access_token_date_expired' => $accessTokenDateExpired,
                'refresh_token' => $refresh_token,
            ]);

            $updateButtonState = KommoFlashFunctionsDb::update(['option_value' => ''], ['option_name' => 'button_state']);
            KommoFlashFunctionsDb::update(['option_value' => wp_json_encode($accountSign)], ['option_name' => 'account_sign']);
            $updateAccountSignReferer = KommoFlashFunctionsDb::update(['option_value' => ($accountSignReferer)], ['option_name' => 'account_sign_referer']);
        } catch (Exception|Error $e) {
            $result['error'] = 'Tokens not saved, error: ' . $e->getMessage();
            return $result;
        }

        if ($updateButtonState === false || $dbUpdateTokens === false || $updateAccountSignReferer === false) {
            $result['error'] = 'Tokens not saved';
            return $result;
        }

        return $result;
    }

    public static function authSecretGet()
    {
        $secretsJson = KommoFlashFunctions::getOptionValue('account_sign_secrets');

        if (empty($secretsJson)) {
            return false;
        }

        try {
            $secrets = json_decode($secretsJson, true);
        } catch (Exception|Error $e) {
            $secrets = false;
        }

        return $secrets;
    }

    public static function getAccessTokens($secrets, $get, $redirectURI = null)
    {
        $provider = new AmoCRM([
            'clientId' => $secrets['client_id'],
            'clientSecret' => $secrets['client_secret'],
            'redirectUri' => $redirectURI ?? rest_url(PluginRESTController::API_NAMESPACE . PluginRESTController::API_VERSION . '/redirect'),
        ]);
        $provider->setBaseDomain($get['referer']);

        $result = null;

        try {
            /** @var AccessToken $access_token */
            $accessToken = $provider->getAccessToken(new AuthorizationCode(), [
                'code' => $get['code'],
            ]);

            if (!$accessToken->hasExpired()) {
                $result = [
                    'access_token' => $accessToken->getToken(),
                    'refresh_token' => $accessToken->getRefreshToken(),
                    'expires' => $accessToken->getExpires(),
                    'base_domain' => $provider->getBaseDomain(),
                ];
            }
        } catch (AmoCRMException|Exception|Error $e) {
        }

        return $result;
    }

    public static function authGetTokenDateExpire($serverResponse)
    {
        $expires = '';
        if (!empty($serverResponse['expires'])) {
            $expires = $serverResponse['expires'];
        }
        if (!empty($serverResponse['expires_in'])) {
            $expires = $serverResponse['expires_in'];
        }

        try {
            $serverResponse['access_token_date_expired'] = $expires;
        } catch (Exception|Error $e) {
        }

        return $serverResponse;
    }

    public function apiGetAccountInfo()
    {
        $accessToken = KommoFlashFunctions::getOptionValue('access_token');
        if (empty($accessToken)) {
            self::unsetAccountInfo();
            return self::getAccountInfo();
        }

        $account = $this->apiFetch(KOMMOFLASH_API_ACCOUNT_URI_PATHNAME);
        if (isset($account['id'])) {
            $accountInfo = $account;
			KommoFlashFunctions::setAccountInfo($accountInfo);

			return KommoFlashFunctions::getAccountInfo();
		} else {
			self::unsetAccountInfo();

			return self::getAccountInfo();
		}
    }

    public function apiCreateSourceInfo($parameters = [])
    {
        $result = [
            'error' => null,
            'data' => [],
        ];

        if (empty($this->apiClient)) {
            self::showError([
                'title' => self::$ERROR_PLUGIN_DEFAULT['title'],
                'text' => self::$ERROR_PLUGIN_DEFAULT['text'],
            ]);
            return $result;
        }

        if (empty($this->pipelineIdFirst)) {
            self::showError([
                'title' => self::$ERROR_PLUGIN_DEFAULT['title'],
                'text' => self::$ERROR_PLUGIN_DEFAULT['text'],
            ]);
            return $result;
        }

        $siteUrl = site_url();
        $siteUrl = $parameters['site_url_dynamic'] ?? $siteUrl;

        $buttonModel = new WebsiteButtonCreateRequestModel(
            $this->pipelineIdFirst,
            [
                $siteUrl,
            ]
        );

        try {
            $source = $this->apiClient->websiteButtons()->createAsync($buttonModel);
            $this->apiClient->websiteButtons()->addOnlineChatAsync($source->getSourceId());
            $result['data'] = $source->toArray();
        } catch (AmoCRMApiException $e) {
            $result['error'] = $e->getMessage();
        }

        return $result;
    }

    public function apiBindSiteToSource($sourceId, $siteUrlDynamic = null)
    {
        $result = [
            'error' => null,
            'data' => [],
        ];

        if (empty($sourceId)) {
            $result['error'] = 'Empty source_id';
            return $result;
        }

        $siteUrl = site_url();
        $siteUrl = $siteUrlDynamic ?? $siteUrl;

        $buttonModel = new WebsiteButtonUpdateRequestModel(
            [
                $siteUrl
            ],
            (int)$sourceId
        );

        try {
            $result['data'] = $this->apiClient->websiteButtons()->updateAsync($buttonModel);
            $result['site_url'] = $siteUrl;
        } catch (AmoCRMApiException $e) {
            $result['error'] = $e->getMessage();
        }

        return $result;
    }

    public function apiAddOnlineChatToSource($sourceId)
    {
        $result = [
            'error' => null,
            'data' => [],
        ];

        if (empty($sourceId)) {
            $result['error'] = 'Empty source_id';
            return $result;
        }

        try {
            $this->apiClient->websiteButtons()->addOnlineChatAsync((int)$sourceId);
        } catch (AmoCRMApiException $e) {
            $result['error'] = $e->getMessage();
        }

        return $result;
    }

    public function apiAddChatToSourceIdFirst($sourceId)
    {
        if (empty($sourceId)) {
            return;
        }

        for ($i = 1; $i <= KOMMOFLASH_BUTTON_ADD_CHAT_ATTEMPTS;) {
            try {
                $this->apiClient->websiteButtons()->addOnlineChatAsync($sourceId);
            } catch (AmoCRMApiException $e) {
            }

            $i++;
            sleep(KOMMOFLASH_BUTTON_ADD_CHAT_ATTEMPTS_INTERVAL);
        }
    }

    public function checkSource($source)
    {
        if (!empty($source['error'])) {
            return false;
        }
        if (empty($source['data']['source_id'])) {
            return false;
        }

        return true;
    }

    public function apiGetSourceCount($source)
    {
        if (!empty($source['error']) && !is_array($source['data'])) {
            $count = null;
        } else {
            $count = count($source['data']);
        }

        return $count;
    }

    public function apiGetSourceInfoCurrent($sourceId)
    {
        $result = [
            'error' => null,
            'data' => [],
        ];

        if (empty($this->apiClient)) {
            $result['error'] = 'Api client not ready';
            return $result;
        }

        try {
            $result['data'] = $this->apiClient->websiteButtons()->getOne($sourceId, WebsiteButtonModel::getAvailableWith())->toArray();
        } catch (AmoCRMApiException $e) {
            $result['error'] = $e->getMessage();
        }

        if (!empty($result['error'])) {
            return $result;
        }

        $links = $this->getAccountLinks(['account' => [
            'account_pipeline_id_first' => $result['data']['pipeline_id'],
            'button_id' => $result['data']['button_id'],
        ]]);
        $result['data']['button_settings_link'] = $links['account']['button_settings'];

        if (empty($result['data']['script'])) {
            $result['error'] = 'Script not found. Button not allowed on public pages';
            return $result;
        }

        $this->setOptionValue('chat_button_script', htmlentities($result['data']['script']));
        $chatButtonDataJson = wp_json_encode([
            'source_id' => esc_sql($result['data']['source_id']),
            'button_id' => esc_sql($result['data']['button_id']),
        ]);
        $this->setOptionValue('chat_button_data', $chatButtonDataJson);
        $this->toggleButtonVisible(1);

        return $result;
    }

    public static function getScriptWithLocale($script)
    {
        global $wp_filesystem;
        if (!$wp_filesystem) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $scriptLocale = $wp_filesystem->get_contents(__DIR__ . '/script-locale.js');
        $scriptLocale = str_replace([PHP_EOL], [''], $scriptLocale);

        $script = html_entity_decode($script);

        $script = str_replace(['<script>', '</script>'], ['', ''], $script);
        $script = str_replace(['locale:"en"'], ['locale:window.KOMMOFLASH_BROWSER_LOCALE'], $script);

        return [
            'locale' => $scriptLocale,
            'main' => $script,
        ];
    }

    public function apiGetSourceInfo()
    {
        $result = [
            'error' => null,
            'data' => [],
        ];

        if (empty($this->apiClient)) {
            return $result;
        }

        try {
            $result['data'] = $this->apiClient->websiteButtons()->get()->toArray();
        } catch (AmoCRMApiException $e) {
            $result['error'] = $e->getMessage();
        }

        return $result;
    }

    public function apiFetch($link)
    {
        $response = [];

        if (empty($this->apiClient)) {
            return $response;
        }

        try {
			$response = $this->apiClient->getRequest()->get($link,);
        } catch (GuzzleException | AmoCRMApiException $e) {
            return $response;
        }

        return $response;
    }

    public static function siteLogout()
    {
        KommoFlashFunctionsDb::update(['option_value' => ''], ['option_name' => 'account_sign']);
        KommoFlashFunctionsDb::update(['option_value' => '0'], ['option_name' => 'account_sign_init']);
        KommoFlashFunctionsDb::update(['option_value' => ''], ['option_name' => 'account_sign_referer']);
        KommoFlashFunctionsDb::update(['option_value' => ''], ['option_name' => 'account_sign_secrets']);
        KommoFlashFunctionsDb::update(['option_value' => ''], ['option_name' => 'chat_button_script']);
        KommoFlashFunctionsDb::update(['option_value' => ''], ['option_name' => 'chat_button_data']);
        KommoFlashFunctionsDb::update(['option_value' => ''], ['option_name' => 'chat_button_switch']);
        KommoFlashFunctionsDb::update(['option_value' => ''], ['option_name' => 'account_pipeline_id_first']);

        $dbUpdateTokens = self::dbUpdateTokens([
            'access_token' => '',
            'access_token_date_expired' => '',
            'refresh_token' => '',
        ]);

        $updateAccountInfo = self::unsetAccountInfo();

        $result = [
            'error' => null,
            'data'  => null,
        ];
        if (!$dbUpdateTokens || $updateAccountInfo === false) {
            $result['error'] = 'Logout failed';
            return $result;
        }

        return $result;
    }

    public function getAccountInbox()
    {
        $result = [
            'action' => 'no-unread-messages', // try-inbox, have-unread-messages, not-have-any-buttons-yet
            'count' => 0,
            'error' => null,
        ];
        $count = 0;
        $countSource = 0;

        try {
            $dataServer = $this->apiFetch(KOMMOFLASH_API_GET_COUNT_INBOX_PATHNAME);
            $count = $dataServer['count'];
        } catch (Exception $e) {
            $result['error'] = $e->getMessage();
        }

        for ($i = 1; $i <= KOMMOFLASH_INTEGRATION_BUTTON_GET_COUNT_ATTEMPTS; $i++) {
            try {
                $dataServer = $this->apiClient->websiteButtons()->get()->toArray();
                $countSource = count($dataServer);
            } catch (AmoCRMApiException $e) {
                if ($e->getCode() !== 204) {
                    $result['error'] = !empty($result['error']) ? $result['error'] . ' ' . $e->getMessage() : $e->getMessage();
                }
            }
            if ($countSource != 0) {
                break;
            }
        }

        if ($count > 0) {
            $result['count']  = $count;
            $result['action'] = 'have-unread-messages';
            $result['text']   = $this->getMsgStringEsc('inbox-have-unread-messages', ['count' => $count]);
        }
        if ($count === 0) {
            $result['action'] = 'no-unread-messages';
            $result['count']  = 0;
        }
        if ($countSource === 0) {
            $result['action'] = 'not-have-any-buttons-yet';
            $result['count']  = 0;
        }

        if (!empty($result['error'])) {
            return [
                'error' => $result['error'],
                'data'  => ['action' => 'try-inbox']
            ];
        }

        return [
            'error' => null,
            'data'  => $result,
        ];
    }

    public function getMsgStringByLocale($id, $data): string
    {
        $locale = get_locale();
        $mofile = __DIR__ . '/lang/' . 'website-chat-button-kommo-integration' . '-' . $locale . '.mo';

        switch ($id) {
            case 'inbox-have-unread-messages':
                $textBefore       = __("You have ", 'website-chat-button-kommo-integration');
                $textAfterDefault = __(" unread message", 'website-chat-button-kommo-integration');
                $count = $data['count'];

                if ($locale === 'ru_RU') {
                    $textAfter = function () use ($mofile, $textAfterDefault, $count) {
                        if (!file_exists($mofile)) {
                            return $textAfterDefault;
                        }
                        if ($count === 1) {
                            return __(" unread message 1", 'website-chat-button-kommo-integration');
                        } elseif (in_array($count, [21, 31, 41, 51, 61, 71, 81, 91, 101])) {
							return __(" unread message 1", 'website-chat-button-kommo-integration');
						} elseif (
                            ($count > 21 && $count < 25) ||
                            ($count > 31 && $count < 35) ||
                            ($count > 41 && $count < 45) ||
                            ($count > 51 && $count < 55) ||
                            ($count > 61 && $count < 65) ||
                            ($count > 71 && $count < 75) ||
                            ($count > 81 && $count < 85) ||
                            ($count > 91 && $count < 95)
                        ) {
                            return __(" unread message 2", 'website-chat-button-kommo-integration');
                        } elseif (
                            ($count >= 25 && $count <= 30) ||
                            ($count >= 35 && $count <= 40) ||
                            ($count >= 45 && $count <= 50) ||
                            ($count >= 55 && $count <= 60) ||
                            ($count >= 65 && $count <= 70) ||
                            ($count >= 75 && $count <= 80) ||
                            ($count >= 85 && $count <= 90) ||
                            ($count >= 95 && $count <= 100)
                        ) {
                            return __(" unread message", 'website-chat-button-kommo-integration');
                        } elseif ($count >= 5) {
							return __(" unread message", 'website-chat-button-kommo-integration');
						} elseif ($count >= 2) {
							return __(" unread message 2", 'website-chat-button-kommo-integration');
						}
                    };
                } else {
                    if ($locale === 'en_US' && $count > 1) {
                        $textAfterDefault = $textAfterDefault . 's';
                    }

                    $textAfter  = function () use ($textAfterDefault) {
                        return $textAfterDefault;
                    };
                }

                $text = $textBefore . $count . $textAfter();
                return $text;
            default:
                return '';
        }
    }

    public function getMsgStringEsc($id, $data)
    {
        $text = $this->getMsgStringByLocale($id, $data);

        return wp_kses_post($text);
    }

    public function toggleButtonVisible($state)
    {
        return KommoFlashFunctionsDb::update(['option_value' => $state], ['option_name' => 'chat_button_switch']);
    }

    public function getButtonVisible()
    {
        return KommoFlashFunctions::getOptionValue('chat_button_switch');
    }

	public function getAccountButtonSwitch()
	{
		$button_switch_state = KommoFlashFunctions::getOptionValue('chat_button_switch');

		if (empty($button_switch_state)){
			// return false;
			return [
				'status' => 200,
				'message' => 'get_button_state',
				'data' => false
			];
		} else if ($button_switch_state == KOMMOFLASH_CHAT_BUTTON_SWITCH_TRUE) {
			// return true;
			return [
				'status' => 200,
				'message' => 'get_button_state',
				'data' => true,
			];
		} else {
			return [
				'status' => 500,
				'message' => 'error'
			];
		}
	}

    public function getAccountTrial()
    {
		$trialDateStart = KommoFlashFunctions::getOptionValue('trial_date_start');
		if ($trialDateStart === KOMMOFLASH_TRIAL_END) {
			return KOMMOFLASH_TRIAL_END;
		}

		$accountState = KommoFlashFunctions::getAccountSign();
		if (isset($accountState['type'], $accountState['datetime']) && $accountState['type'] === 'sign-up') {
			$signUpDate = DateTime::createFromFormat('Y-m-d H:i:s', $accountState['datetime']);
			$interval = (int)((time() - $signUpDate->getTimestamp()) / 60 / 60 / 24);
			$days = KOMMOFLASH_TRIAL_COUNT_DAYS - $interval;

			if ($days <= 0) {
				$this->setOptionValue('trial_date_start', KOMMOFLASH_TRIAL_END);
				return KOMMOFLASH_TRIAL_SHOW_MODAL_FRAME;
			}

			return $days;
		} else {
			$this->setOptionValue('trial_date_start', KOMMOFLASH_TRIAL_END);

			return KOMMOFLASH_TRIAL_END;
		}
    }

    public function getTrialExpired(): bool
    {
        $data = KommoFlashFunctions::getOptionsValue([
            'trial_date_start',
        ]);

        return (int)$data['trial_date_start'] === KOMMOFLASH_TRIAL_END;
    }

    public function checkButtonList()
    {
        $buttonData = $this->dbGetJsonOptionValue('chat_button_data');

        if (empty($buttonData['source_id']) || empty($buttonData['button_id'])) {
            return KOMMOFLASH_CHAT_BUTTON_NOT_EXIST;
        }

        try {
            $buttonsDataServer = $this->apiClient->websiteButtons()->get()->toArray();
            foreach ($buttonsDataServer as $buttonDataServer) {
                if ($buttonData['button_id'] == $buttonDataServer['button_id']) {
                    return KOMMOFLASH_CHAT_BUTTON_IN_DB;
                }
            }
            return KOMMOFLASH_CHAT_BUTTON_NEED_BUTTON;
        } catch (AmoCRMApiException $e) {
            return KOMMOFLASH_CHAT_BUTTON_NEED_BUTTON;
        }
    }

    public static function getAccountLinksSupport()
    {
        $links = include __DIR__ . '/links-customer.php';
        return $links['extra']['chat_with_support'] ?? '';
    }

    public function getAccountLinks($parameters = [])
    {
        $dbData = KommoFlashFunctions::getOptionsValue([
            'access_token',
            'account_pipeline_id_first',
            'account_sign_referer',
        ]);
        $buttonData = $this->dbGetJsonOptionValue('chat_button_data');

        $linksCustomer = include __DIR__ . '/links-customer.php';
        $linksCustomer = $linksCustomer ?? ['account' => []];

        if (!empty($parameters['account']['account_pipeline_id_first'])) {
            $dbData['account_pipeline_id_first'] = $parameters['account']['account_pipeline_id_first'];
        }
        if (!empty($parameters['account']['button_id'])) {
            $buttonData['button_id'] = $parameters['account']['button_id'];
        }

        if (!empty($dbData['account_pipeline_id_first']) && !empty($buttonData['button_id'])) {
            $replaceFrom = ['CUSTOMER_SUBDOMAIN', 'PIPELINE_ID_FIRST', 'BUTTON_ID_CURRENT'];
            $replaceTo = [$dbData['account_sign_referer'], $dbData['account_pipeline_id_first'], $buttonData['button_id']];
        } else if (!empty($dbData['account_pipeline_id_first']) && empty($buttonData['button_id'])) {
            $replaceFrom = ['CUSTOMER_SUBDOMAIN', 'PIPELINE_ID_FIRST', '?edit_source=BUTTON_ID_CURRENT'];
            $replaceTo = [$dbData['account_sign_referer'], $dbData['account_pipeline_id_first'], ''];
        } else {
            $replaceFrom = ['CUSTOMER_SUBDOMAIN', 'PIPELINE_ID_FIRST?edit_source=BUTTON_ID_CURRENT'];
            $replaceTo = [$dbData['account_sign_referer'] ?? '', ''];
        }

        foreach ($linksCustomer['account'] as $linkKey => &$linkValue) {
            $linkValue = str_replace($replaceFrom, $replaceTo, $linkValue);
        }

        try {
            $links = include __DIR__ . '/links.php';
        } catch (Exception|Error $e) {
            $links = [];
        }

        $data = $linksCustomer + $links;

        return $data;
    }

    public static function getChatButtonsData($data)
    {
        $result = [];
        $number = 0;
        $count = count($data);

        $nameDefault = KOMMOFLASH_BUTTON_NAME_DEFAULT;
        $nameDefault = defined('KOMMOFLASH_BUTTON_NAME_DEFAULT_EXTERNAL') ? KOMMOFLASH_BUTTON_NAME_DEFAULT_EXTERNAL : $nameDefault;

        foreach ($data as $item) {
            $number++;

            if (trim($item['name']) == KOMMOFLASH_BUTTON_NAME_DEFAULT) {
                $item['name'] = $nameDefault;
            }

            if (!empty($item['name'])) {
                $name = $item['name'];
            } else if ($count == 1) {
                $name = $nameDefault;
            } else {
                $name = $nameDefault . ' #' . $number;
            }

            $result[] = [
                'source_id' => $item['source_id'],
                'button_id' => $item['button_id'],
                'name' => !empty($item['name']) ? $item['name'] : $name,
            ];
        }

        return $result;
    }

    public function getButtonsData()
    {
        $data = [
            'modal_chat_button_select' => [],
        ];
        $dataDb = KommoFlashFunctions::getOptionsValue([
            'account_sign_referer',
            'account_sign_init',
            'chat_button_data',
        ]);

        $accountSign = KommoFlashFunctions::getAccountSign();
        $signType = $accountSign['type'] ?? false;

        $sourceInfo = $this->apiGetSourceInfo();
        $sourcesCount = $this->apiGetSourceCount($sourceInfo);

        $notifications = [];

        if (!is_numeric($sourcesCount)) {
            $notifications['show_modal_error_log'] = [
                'title' => KommoFlashFunctions::$ERROR_KOMMOFLASH_DEFAULT['title'],
                'text' => KommoFlashFunctions::$ERROR_KOMMOFLASH_DEFAULT['text'],
            ];
        }

        if ($sourcesCount === 0 && $dataDb['account_sign_init'] == 0) {
            $instance = ['site' => []];
            $sourceInfoCreated = $this->apiCreateSourceInfo([
                'action' => 'source_count_0',
                'site_url_dynamic' => $instance['site']['url'] ?? null,
            ]);
            $isSourceValid = $this->checkSource($sourceInfoCreated);
            $this->apiAddChatToSourceIdFirst($sourceInfoCreated['data']['source_id']);
            $this->apiGetSourceInfoCurrent($sourceInfoCreated['data']['source_id']);

            if (!$isSourceValid && empty($sourceInfoCreated['error'])) {
                $notifications['show_modal_error_log'] = [
                    'title' => KommoFlashFunctions::$ERROR_KOMMOFLASH_DEFAULT['title'],
                    'text' => KommoFlashFunctions::$ERROR_KOMMOFLASH_DEFAULT['text'],
                ];
            } elseif (!$isSourceValid || !empty($sourceInfoCreated['error'])) {
                $notifications['show_modal_error_log'] = [
                    'title' => KommoFlashFunctions::$ERROR_KOMMOFLASH_DEFAULT['title'],
                    'text' => KommoFlashFunctions::$ERROR_KOMMOFLASH_DEFAULT['text'],
                ];
            }

            $dataDb['account_sign_init'] = 0;
        }

        if ($dataDb['account_sign_init'] == 0 && is_numeric($sourcesCount)) {
            if ($signType == 'sign-up') {
                if ($isSourceValid) {
                    $notifications['show_modal_welcome'] = [];
                }
            } elseif ($signType == 'sign-in' && $sourcesCount === 0) {
                if ($isSourceValid) {
                    $notifications['show_modal_welcome'] = [];
                }
            }

            $buttonNeed = $this->checkButtonList();
            $this->setOptionValue('account_sign_init', 1);
        }

        $dataDb['account_sign_init'] = KommoFlashFunctions::getOptionValue('account_sign_init');

        if ($sourcesCount > 0 && empty($dataDb['chat_button_data'])) {
            $sourceInfoSelect = $this->apiGetSourceInfo();
            $data['modal_chat_button_select'] = KommoFlashFunctions::getChatButtonsData($sourceInfoSelect['data']);
            $notifications['show_modal_chat_button_select'] = [];
        }

        $accountLinks = $this->getAccountLinks();

		return [
			'chat_button_need_button' => $buttonNeed ?? $this->checkButtonList(),
			'sources_count' => $sourcesCount,
			'account_sign_init' => $dataDb['account_sign_init'],
			'data' => $data,
			'notifications' => $notifications,
			'button_settings_link' => $accountLinks['account']['button_settings'] ?? '',
		];
    }

    public static function tokenSaveStateDataCheck(
		$siteUrl,
		$accountSign,
		$siteTime
    ) {
        if (!$siteUrl) {
            exit('Error: Bad site URL');
        }
        if (!is_string($accountSign)) {
            KommoFlashFunctions::redirect([
                'location' => $siteUrl . KOMMOFLASH_PLUGIN_PAGE_URL . '&auth_error=bad-sign-action',
            ]);
        }
        if (!is_numeric($siteTime) || $siteTime == 0) {
            KommoFlashFunctions::redirect([
                'location' => $siteUrl . KOMMOFLASH_PLUGIN_PAGE_URL . '&auth_error=bad-time',
            ]);
        }
    }

    public static function tokenSaveSecretCheck(
        $secrets,
        $serverResponse,
        $siteUrl,
        $accountSign
    ) {
        if (!$secrets) {
            KommoFlashFunctions::redirect([
                'location' => $siteUrl . KOMMOFLASH_PLUGIN_PAGE_URL . '&auth_error=bad-secrets',
            ]);
        }

        if (empty($serverResponse) || !is_array($serverResponse)) {
            KommoFlashFunctions::redirect([
                'location' => $siteUrl . KOMMOFLASH_PLUGIN_PAGE_URL . '&auth_error=tokens-not-selected&account_sign_type=' . $accountSign,
            ]);
        }
    }
}

