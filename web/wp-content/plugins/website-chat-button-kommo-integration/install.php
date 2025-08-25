<?php

if (!defined('ABSPATH')) {
	exit();
};

require_once __DIR__ . '/main/config.php';
require_once __DIR__ . '/main/KommoFlashFunctions.php';
require_once __DIR__ . '/main/KommoFlashFunctionsDb.php';

global $kommoflashDbVersion;
$kommoflashDbVersion = '1.0';

function kommoflash_uninstall()
{
    global $wpdb;

    $wpdb->query($wpdb->prepare('DROP TABLE IF EXISTS %i', $wpdb->prefix . KOMMOFLASH_DB_TABLE));
}

function kommoflash_deactivation()
{
    KommoFlashFunctions::siteLogout();
}

function kommoflash_activation()
{
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    global $kommoflashDbVersion;
    global $wpdb;

    $charsetCollate = $wpdb->get_charset_collate();

    $wpdb->query($wpdb->prepare('DROP TABLE IF EXISTS %i', $wpdb->prefix . KOMMOFLASH_DB_TABLE));

    $table_name = $wpdb->prefix . KOMMOFLASH_DB_TABLE;
    $sql = "CREATE TABLE $table_name (
		option_id    bigint unsigned auto_increment,
        option_name  varchar(191) default ''    not null,
        option_value longtext                   not null,
		PRIMARY KEY  (option_id),
        UNIQUE (option_name)
	) $charsetCollate;";
    dbDelta($sql);
    $sql = "INSERT INTO $table_name (option_name, option_value)
            VALUES ('button_state', ''),
                   ('access_token', ''),
                   ('access_token_date_expired', ''),
                   ('refresh_token', ''),
                   ('account_info', ''),
                   ('account_sign', ''),
                   ('account_sign_referer', ''),
                   ('account_sign_secrets', ''),
                   ('account_sign_init', '0'),
                   ('account_init', '0'),
                   ('account_init_source', '0'),
                   ('account_pipeline_id_first', ''),
                   ('chat_button_script', ''),
                   ('chat_button_data', ''),
                   ('chat_button_switch', '0'),
                   ('chat_inbox_init', '0'),
                   ('trial_date_start', '100');";
    dbDelta($sql);

    add_option('kommoflash_db_version', $kommoflashDbVersion);
    add_option('kommoflash_toggle_public_widget', 0, '', false);
}

function kommoflash_activated_plugin($plugin)
{
    if (KOMMOFLASH_PLUGIN_PAGE_ACTIVATION_ID !== $plugin) {
        return;
    }

    wp_safe_redirect(admin_url(KOMMOFLASH_INTEGRATION_SITE_PLUGIN_PATH_ADMIN_WP));
    exit;
}
