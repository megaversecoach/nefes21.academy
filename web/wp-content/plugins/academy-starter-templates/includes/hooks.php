<?php

/**
 * TGM Required Plugin
 */
function academy_starter_register_required_plugins() {

	$plugins = array(

		array(
			'name'      => 'Academy LMS – eLearning and online course solution for WordPress',
			'slug'      => 'academy',
			'required'  => true,
		),

	);

	$config = array(
		'id'           => 'academy-starter',  // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',               // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,          // Show admin notices or not.
		'dismissable'  => true,          // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',            // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,          // Automatically activate plugins after installation or not.
		'message'      => '',            // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'academy_starter_register_required_plugins' );



function academy_starter_register_demo_plugins( $plugins ) {
	$theme_plugins = [
		[
			'name'     => 'Academy LMS – eLearning and online course solution for WordPress',
			'slug'     => 'academy',
			'required' => true,
		],
	];

	// Check if user is on the theme recommeneded plugins step and a demo was selected.
	if (
		isset( $_GET['step'] ) &&
		$_GET['step'] === 'import' &&
		isset( $_GET['import'] )
	) {

		if ( $_GET['import'] === '0' ) {
			$theme_plugins[] = [
				'name'     => 'Elementor Website Builder',
				'slug'     => 'elementor',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Elementor Header & Footer Builder',
				'slug'     => 'header-footer-elementor',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Academy Elementor Addons',
				'slug'     => 'academy-elementor-addons',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Essential Addons for Elementor',
				'slug'     => 'essential-addons-for-elementor-lite',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'MC4WP: Mailchimp for WordPress',
				'slug'     => 'mailchimp-for-wp',
				'required' => true,
			];
		}
		if ( $_GET['import'] === '1' ) {
			$theme_plugins[] = [
				'name'     => 'Elementor Website Builder',
				'slug'     => 'elementor',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Elementor Header & Footer Builder',
				'slug'     => 'header-footer-elementor',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Academy Elementor Addons',
				'slug'     => 'academy-elementor-addons',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Essential Addons for Elementor',
				'slug'     => 'essential-addons-for-elementor-lite',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'MC4WP: Mailchimp for WordPress',
				'slug'     => 'mailchimp-for-wp',
				'required' => true,
			];
		}
		if ( $_GET['import'] === '2' ) {
			$theme_plugins[] = [
				'name'     => 'Elementor Website Builder',
				'slug'     => 'elementor',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Elementor Header & Footer Builder',
				'slug'     => 'header-footer-elementor',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Academy Elementor Addons',
				'slug'     => 'academy-elementor-addons',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Essential Addons for Elementor',
				'slug'     => 'essential-addons-for-elementor-lite',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'required' => true,
			];

			$theme_plugins[] = [
				'name'     => 'MC4WP: Mailchimp for WordPress',
				'slug'     => 'mailchimp-for-wp',
				'required' => true,
			];
		}
	}//end if

	return array_merge( $plugins, $theme_plugins );
}
add_filter( 'academyst/register_plugins', 'academy_starter_register_demo_plugins' );

function academy_starter_import_demo_files() {
	return [
		[
			'import_file_name'           => 'Marketplace',
			'categories'                 => [ 'LMS', 'Marketplace' ],
			'import_file_url'            => ACADEMY_STARTER_PLUGIN_ROOT_URI . 'demo-data/demo-academylms-net-contents.xml',
			'import_customizer_file_url' => ACADEMY_STARTER_PLUGIN_ROOT_URI . 'demo-data/demo-academylms-net-customizer.dat',
			'import_preview_image_url'   => ACADEMY_STARTER_PLUGIN_ROOT_URI . 'demo-data/marketplace.png',
		],
		[
			'import_file_name'           => 'University',
			'categories'                 => [ 'LMS', 'University' ],
			'import_file_url'            => ACADEMY_STARTER_PLUGIN_ROOT_URI . 'demo-data/demo-academylms-net-contents.xml',
			'import_customizer_file_url' => ACADEMY_STARTER_PLUGIN_ROOT_URI . 'demo-data/demo-academylms-net-customizer.dat',
			'import_preview_image_url'   => ACADEMY_STARTER_PLUGIN_ROOT_URI . 'demo-data/university.png',
		],
		[
			'import_file_name'           => 'Instructor',
			'categories'                 => [ 'LMS', 'Instructor' ],
			'import_file_url'            => ACADEMY_STARTER_PLUGIN_ROOT_URI . 'demo-data/demo-academylms-net-contents.xml',
			'import_customizer_file_url' => ACADEMY_STARTER_PLUGIN_ROOT_URI . 'demo-data/demo-academylms-net-customizer.dat',
			'import_preview_image_url'   => ACADEMY_STARTER_PLUGIN_ROOT_URI . 'demo-data/single-instructor.png',
		],
	];
}

add_filter( 'academyst/import_files', 'academy_starter_import_demo_files' );

function academyst_after_import_setup( $selected_import ) {

	if ( 'Marketplace' === $selected_import['import_file_name'] ) {
		$front_page_id = get_page_by_title( 'Marketplace' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
    }
    elseif ( 'University' === $selected_import['import_file_name'] ) {
		$front_page_id = get_page_by_title( 'University' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
    }
    elseif ( 'Instructor' === $selected_import['import_file_name'] ) {
		$front_page_id = get_page_by_title( 'single instructor' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
    }

}
add_action( 'academyst/after_import', 'academyst_after_import_setup' );

function plugins_list_based_on_demo( $index ) {
	$required_plugins = [
		'0' => [
			[
				'name'     => 'Elementor Website Builder',
				'slug'     => 'elementor',
				'status' => AcademyStarter\Helper::check_plugin_status( 'elementor/elementor.php' ),
			],
			[
				'name'     => 'Elementor Header & Footer Builder',
				'slug'     => 'header-footer-elementor',
				'status' => AcademyStarter\Helper::check_plugin_status( 'header-footer-elementor/header-footer-elementor.php' ),
			],
			[
				'name'     => 'Essential Addons for Elementor',
				'slug'     => 'essential-addons-for-elementor-lite',
				'status' => AcademyStarter\Helper::check_plugin_status( 'essential-addons-for-elementor-lite/essential_adons_elementor.php' ),
			],
			[
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'status' => AcademyStarter\Helper::check_plugin_status( 'contact-form-7/wp-contact-form-7.php' ),
			],
			[
				'name'     => 'MC4WP: Mailchimp for WordPress',
				'slug'     => 'mailchimp-for-wp',
				'status' => AcademyStarter\Helper::check_plugin_status( 'mailchimp-for-wp/mailchimp-for-wp.php' ),
			],
			[
				'name'     => 'Wordpress Importer',
				'slug'     => 'wordpress-importer',
				'status' => AcademyStarter\Helper::check_plugin_status( 'wordpress-importer/wordpress-importer.php' ),
			],
		],
		'1' => [
			[
				'name'     => 'Elementor Website Builder',
				'slug'     => 'elementor',
				'status' => AcademyStarter\Helper::check_plugin_status( 'elementor/elementor.php' ),
			],
			[
				'name'     => 'Elementor Header & Footer Builder',
				'slug'     => 'header-footer-elementor',
				'status' => AcademyStarter\Helper::check_plugin_status( 'header-footer-elementor/header-footer-elementor.php' ),
			],
			[
				'name'     => 'Essential Addons for Elementor',
				'slug'     => 'essential-addons-for-elementor-lite',
				'status' => AcademyStarter\Helper::check_plugin_status( 'essential-addons-for-elementor-lite/essential_adons_elementor.php' ),
			],
			[
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'status' => AcademyStarter\Helper::check_plugin_status( 'contact-form-7/wp-contact-form-7.php' ),
			],
			[
				'name'     => 'MC4WP: Mailchimp for WordPress',
				'slug'     => 'mailchimp-for-wp',
				'status' => AcademyStarter\Helper::check_plugin_status( 'mailchimp-for-wp/mailchimp-for-wp.php' ),
			],
			[
				'name'     => 'Wordpress Importer',
				'slug'     => 'wordpress-importer',
				'status' => AcademyStarter\Helper::check_plugin_status( 'wordpress-importer/wordpress-importer.php' ),
			],
		],
		'2' => [
			[
				'name'     => 'Elementor Website Builder',
				'slug'     => 'elementor',
				'status' => AcademyStarter\Helper::check_plugin_status( 'elementor/elementor.php' ),
			],
			[
				'name'     => 'Elementor Header & Footer Builder',
				'slug'     => 'header-footer-elementor',
				'status' => AcademyStarter\Helper::check_plugin_status( 'header-footer-elementor/header-footer-elementor.php' ),
			],
			[
				'name'     => 'Essential Addons for Elementor',
				'slug'     => 'essential-addons-for-elementor-lite',
				'status' => AcademyStarter\Helper::check_plugin_status( 'essential-addons-for-elementor-lite/essential_adons_elementor.php' ),
			],
			[
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'status' => AcademyStarter\Helper::check_plugin_status( 'contact-form-7/wp-contact-form-7.php' ),
			],
			[
				'name'     => 'MC4WP: Mailchimp for WordPress',
				'slug'     => 'mailchimp-for-wp',
				'status' => AcademyStarter\Helper::check_plugin_status( 'mailchimp-for-wp/mailchimp-for-wp.php' ),
			],
			[
				'name'     => 'Wordpress Importer',
				'slug'     => 'wordpress-importer',
				'status' => AcademyStarter\Helper::check_plugin_status( 'wordpress-importer/wordpress-importer.php' ),
			],
		],

	];
	return $required_plugins[ $index ];
}

add_action( 'wp_ajax_add_required_plugin_popup', 'add_required_plugin_popup' );
function add_required_plugin_popup() {
	check_ajax_referer( 'academyst-ajax-verification', 'security' );
	$demo_index = ! empty( $_POST['demo'] ) ? sanitize_key( wp_unslash( $_POST['demo'] ) ) : 0;
	$plugins_list = plugins_list_based_on_demo( $demo_index );
	if ( ! empty( $plugins_list ) ) {
		wp_send_json_success( $plugins_list );
	} else {
		wp_send_json_error( esc_html__( 'No relevent plugin for this demo.', 'academy-starter-templates' ) );
	}
}
