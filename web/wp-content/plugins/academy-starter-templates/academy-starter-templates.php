<?php
/*
 * Plugin Name:		Academy Starter Templates
 * Plugin URI:		http://demo.academylms.net
 * Description:		Demo importer plugin for academy lms.
 * Version:			2.0.0
 * Author:			Academy LMS
 * Author URI:		http://academylms.net
 * License:			GPL-3.0+
 * License URI:		http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:		academy-starter-templates
 * Domain Path:		/languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class AcademyStarter {

	private function __construct() {
		$this->define_constants();
		$this->load_dependency();
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		add_action( 'academy_loaded', [ $this, 'init_plugin' ] );
	}

	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	public function define_constants() {
		/**
		 * Defines CONSTANTS for Whole plugins.
		 */
		define( 'ACADEMY_STARTER_VERSION', '2.0.0' );
		define( 'ACADEMY_STARTER_SETTINGS_NAME', 'academy_starter_settings' );
		define( 'ACADEMY_STARTER_PLUGIN_FILE', __FILE__ );
		define( 'ACADEMY_STARTER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		define( 'ACADEMY_STARTER_PLUGIN_SLUG', 'academy-starter-templates' );
		define( 'ACADEMY_STARTER_PLUGIN_ROOT_URI', plugins_url( '/', __FILE__ ) );
		define( 'ACADEMY_STARTER_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
		define( 'ACADEMY_STARTER_INCLUDES_DIR_PATH', ACADEMY_STARTER_ROOT_DIR_PATH . 'includes/' );
		define( 'ACADEMY_STARTER_ASSETS_DIR_PATH', ACADEMY_STARTER_ROOT_DIR_PATH . 'assets/' );
		define( 'ACADEMY_STARTER_ASSETS_URI', ACADEMY_STARTER_PLUGIN_ROOT_URI . 'assets/' );
		define( 'ACADEMY_STARTER_TEMPLATE_DEBUG_MODE', false );
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public function init_plugin() {

		$this->load_textdomain();
		$this->dispatch_hooks();
	}

	public function dispatch_hooks() {
		AcademyStarter\Migration::init();
		AcademyStarter\Library::init();
	}

	public function load_textdomain() {
		load_plugin_textdomain(
			'academy-starter-templates',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

	public function load_dependency() {
		/**
		 * Require Autoload File
		 */
		require_once ACADEMY_STARTER_INCLUDES_DIR_PATH . 'autoload.php';
		/**
		 * Require TGM File
		 */
		require_once ACADEMY_STARTER_INCLUDES_DIR_PATH . 'library/tgm-plugin-activation.php';

		/**
		 * Hooks
		 */
		require_once ACADEMY_STARTER_INCLUDES_DIR_PATH . 'hooks.php';
	}

	public function activate() {
		AcademyStarter\Installer::init();
	}
}

/**
 * Initializes the main plugin
 *
 * @return \academy-starter
 */
function Academy_Starter_Start() {
	return AcademyStarter::init();
}

// Plugin Start
Academy_Starter_Start();
