<?php
/**
 * eLearning Education: Customizer
 *
 * @package eLearning Education
 * @subpackage elearning_education
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function elearning_education_customize_register( $wp_customize ) {

	require get_parent_theme_file_path('/inc/controls/icon-changer.php');

	require get_parent_theme_file_path('/inc/controls/range-slider-control.php');

	// Register the custom control type.
	$wp_customize->register_control_type( 'Elearning_Education_Toggle_Control' );

	//Register the sortable control type.
	$wp_customize->register_control_type( 'Elearning_Education_Control_Sortable' );

	//add home page setting pannel
	$wp_customize->add_panel( 'elearning_education_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Custom Home page', 'elearning-education' ),
	    'description' => __( 'Description of what this panel does.', 'elearning-education' ),
	) );

	//TP Color Option
	$wp_customize->add_section('elearning_education_color_option',array(
     'title'         => __('TP Color Option', 'elearning-education'),
     'priority' => 6,
     'panel' => 'elearning_education_panel_id'
    ) );

	$wp_customize->add_setting( 'elearning_education_tp_color_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'elearning_education_tp_color_option', array(
			'label'     => __('Theme First Color', 'elearning-education'),
	    'description' => __('It will change the complete theme color in one click.', 'elearning-education'),
	    'section' => 'elearning_education_color_option',
	    'settings' => 'elearning_education_tp_color_option',
  	)));

 
  	$wp_customize->add_setting( 'elearning_education_tp_secoundary_color_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'elearning_education_tp_secoundary_color_option', array(
			'label'     => __('Theme Second Color', 'elearning-education'),
	    'description' => __('It will change the complete theme color in one click.', 'elearning-education'),
	    'section' => 'elearning_education_color_option',
	    'settings' => 'elearning_education_tp_secoundary_color_option',
  	)));

	//Sidebar Position
	$wp_customize->add_section('elearning_education_tp_general_settings',array(
		'title' => __('TP General Option', 'elearning-education'),
		'priority' => 1,
		'panel' => 'elearning_education_panel_id'
	) );

   $wp_customize->add_setting('elearning_education_tp_body_layout_settings',array(
		'default' => 'Full',
		'sanitize_callback' => 'elearning_education_sanitize_choices'
	));
   $wp_customize->add_control('elearning_education_tp_body_layout_settings',array(
        'type' => 'radio',
        'label'     => __('Body Layout Setting', 'elearning-education'),
        'description'   => __('This option work for complete body, if you want to set the complete website in container.', 'elearning-education'),
        'section' => 'elearning_education_tp_general_settings',
        'choices' => array(
            'Full' => __('Full','elearning-education'),
            'Container' => __('Container','elearning-education'),
            'Container Fluid' => __('Container Fluid','elearning-education')
        ),
	) );

   // Add Settings and Controls for Post Layout
	$wp_customize->add_setting('elearning_education_sidebar_post_layout',array(
      'default' => 'right',
      'sanitize_callback' => 'elearning_education_sanitize_choices'
	));
	$wp_customize->add_control('elearning_education_sidebar_post_layout',array(
        'type' => 'radio',
        'label'     => __('Post Sidebar Position', 'elearning-education'),
        'description'   => __('This option work for blog page, blog single page, archive page and search page.', 'elearning-education'),
        'section' => 'elearning_education_tp_general_settings',
        'choices' => array(
            'full' => __('Full','elearning-education'),
            'left' => __('Left','elearning-education'),
            'right' => __('Right','elearning-education'),
            'three-column' => __('Three Columns','elearning-education'),
            'four-column' => __('Four Columns','elearning-education'),
            'grid' => __('Grid Layout','elearning-education')
        ),
	) );
	// Add Settings and Controls for Post sidebar Layout
	$wp_customize->add_setting('elearning_education_sidebar_single_post_layout',array(
        'default' => 'right',
        'sanitize_callback' => 'elearning_education_sanitize_choices'
	));
	$wp_customize->add_control('elearning_education_sidebar_single_post_layout',array(
        'type' => 'radio',
        'label'     => __('Single Post Sidebar Position', 'elearning-education'),
        'description'   => __('This option work for single blog page', 'elearning-education'),
        'section' => 'elearning_education_tp_general_settings',
        'choices' => array(
            'full' => __('Full','elearning-education'),
            'left' => __('Left','elearning-education'),
            'right' => __('Right','elearning-education'),
        ),
	) );
	// Add Settings and Controls for Page Layout
	$wp_customize->add_setting('elearning_education_sidebar_page_layout',array(
        'default' => 'right',
        'sanitize_callback' => 'elearning_education_sanitize_choices'
	));
	$wp_customize->add_control('elearning_education_sidebar_page_layout',array(
        'type' => 'radio',
        'label'     => __('Page Sidebar Position', 'elearning-education'),
        'description'   => __('This option work for pages.', 'elearning-education'),
        'section' => 'elearning_education_tp_general_settings',
        'choices' => array(
            'full' => __('Full','elearning-education'),
            'left' => __('Left','elearning-education'),
            'right' => __('Right','elearning-education')
        ),
	) );

	$wp_customize->add_setting( 'elearning_education_sticky', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_sticky', array(
		'label'       => esc_html__( 'Show / Hide Sticky Header', 'elearning-education' ),
		'section'     => 'elearning_education_tp_general_settings',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_sticky',
	) ) );

	//tp typography option
	$elearning_education_font_array = array(
		''                       => 'No Fonts',
		'Abril Fatface'          => 'Abril Fatface',
		'Acme'                   => 'Acme',
		'Anton'                  => 'Anton',
		'Architects Daughter'    => 'Architects Daughter',
		'Arimo'                  => 'Arimo',
		'Arsenal'                => 'Arsenal',
		'Arvo'                   => 'Arvo',
		'Alegreya'               => 'Alegreya',
		'Alfa Slab One'          => 'Alfa Slab One',
		'Averia Serif Libre'     => 'Averia Serif Libre',
		'Bangers'                => 'Bangers',
		'Boogaloo'               => 'Boogaloo',
		'Bad Script'             => 'Bad Script',
		'Bitter'                 => 'Bitter',
		'Bree Serif'             => 'Bree Serif',
		'BenchNine'              => 'BenchNine',
		'Cabin'                  => 'Cabin',
		'Cardo'                  => 'Cardo',
		'Courgette'              => 'Courgette',
		'Cherry Swash'           => 'Cherry Swash',
		'Cormorant Garamond'     => 'Cormorant Garamond',
		'Crimson Text'           => 'Crimson Text',
		'Cuprum'                 => 'Cuprum',
		'Cookie'                 => 'Cookie',
		'Chewy'                  => 'Chewy',
		'Days One'               => 'Days One',
		'Dosis'                  => 'Dosis',
		'Droid Sans'             => 'Droid Sans',
		'Economica'              => 'Economica',
		'Fredoka One'            => 'Fredoka One',
		'Fjalla One'             => 'Fjalla One',
		'Francois One'           => 'Francois One',
		'Frank Ruhl Libre'       => 'Frank Ruhl Libre',
		'Gloria Hallelujah'      => 'Gloria Hallelujah',
		'Great Vibes'            => 'Great Vibes',
		'Handlee'                => 'Handlee',
		'Hammersmith One'        => 'Hammersmith One',
		'Inconsolata'            => 'Inconsolata',
		'Indie Flower'           => 'Indie Flower',
		'IM Fell English SC'     => 'IM Fell English SC',
		'Julius Sans One'        => 'Julius Sans One',
		'Josefin Slab'           => 'Josefin Slab',
		'Josefin Sans'           => 'Josefin Sans',
		'Kanit'                  => 'Kanit',
		'Lobster'                => 'Lobster',
		'Lato'                   => 'Lato',
		'Lora'                   => 'Lora',
		'Libre Baskerville'      => 'Libre Baskerville',
		'Lobster Two'            => 'Lobster Two',
		'Merriweather'           => 'Merriweather',
		'Monda'                  => 'Monda',
		'Montserrat'             => 'Montserrat',
		'Muli'                   => 'Muli',
		'Marck Script'           => 'Marck Script',
		'Noto Serif'             => 'Noto Serif',
		'Open Sans'              => 'Open Sans',
		'Overpass'               => 'Overpass',
		'Overpass Mono'          => 'Overpass Mono',
		'Oxygen'                 => 'Oxygen',
		'Orbitron'               => 'Orbitron',
		'Patua One'              => 'Patua One',
		'Pacifico'               => 'Pacifico',
		'Padauk'                 => 'Padauk',
		'Playball'               => 'Playball',
		'Playfair Display'       => 'Playfair Display',
		'PT Sans'                => 'PT Sans',
		'Philosopher'            => 'Philosopher',
		'Permanent Marker'       => 'Permanent Marker',
		'Poiret One'             => 'Poiret One',
		'Quicksand'              => 'Quicksand',
		'Quattrocento Sans'      => 'Quattrocento Sans',
		'Raleway'                => 'Raleway',
		'Rubik'                  => 'Rubik',
		'Rokkitt'                => 'Rokkitt',
		'Russo One'              => 'Russo One',
		'Righteous'              => 'Righteous',
		'Slabo'                  => 'Slabo',
		'Source Sans Pro'        => 'Source Sans Pro',
		'Shadows Into Light Two' => 'Shadows Into Light Two',
		'Shadows Into Light'     => 'Shadows Into Light',
		'Sacramento'             => 'Sacramento',
		'Shrikhand'              => 'Shrikhand',
		'Tangerine'              => 'Tangerine',
		'Ubuntu'                 => 'Ubuntu',
		'VT323'                  => 'VT323',
		'Varela Round'           => 'Varela Round',
		'Vampiro One'            => 'Vampiro One',
		'Vollkorn'               => 'Vollkorn',
		'Volkhov'                => 'Volkhov',
		'Yanone Kaffeesatz'      => 'Yanone Kaffeesatz'
	);
	$wp_customize->add_section('elearning_education_typography_option',array(
		'title'         => __('TP Typography Option', 'elearning-education'),
		'priority' => 1,
		'panel' => 'elearning_education_panel_id'
   	));

   	$wp_customize->add_setting('elearning_education_heading_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'elearning_education_sanitize_choices',
	));
	$wp_customize->add_control(	'elearning_education_heading_font_family', array(
		'section' => 'elearning_education_typography_option',
		'label'   => __('heading Fonts', 'elearning-education'),
		'type'    => 'select',
		'choices' => $elearning_education_font_array,
	));

	$wp_customize->add_setting('elearning_education_body_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'elearning_education_sanitize_choices',
	));
	$wp_customize->add_control(	'elearning_education_body_font_family', array(
		'section' => 'elearning_education_typography_option',
		'label'   => __('Body Fonts', 'elearning-education'),
		'type'    => 'select',
		'choices' => $elearning_education_font_array,
	));

	//TP Blog Option
	$wp_customize->add_section('elearning_education_blog_option',array(
     	'title' => __('TP Blog Option', 'elearning-education'),
     	'priority' => 8,
     	'panel' => 'elearning_education_panel_id'
    ) );
	/** Meta Order */
    $wp_customize->add_setting('blog_meta_order', array(
        'default' => array('date', 'author', 'comment', 'category'),
        'sanitize_callback' => 'elearning_education_sanitize_sortable',
    ));
    $wp_customize->add_control(new Elearning_Education_Control_Sortable($wp_customize, 'blog_meta_order', array(
    	'label' => esc_html__('Meta Order', 'elearning-education'),
        'description' => __('Drag & Drop post items to re-arrange the order and also hide and show items as per the need by clicking on the eye icon.', 'elearning-education') ,
        'section' => 'elearning_education_blog_option',
        'choices' => array(
            'date' => __('date', 'elearning-education') ,
            'author' => __('author', 'elearning-education') ,
            'comment' => __('comment', 'elearning-education') ,
            'category' => __('category', 'elearning-education') ,
        ) ,
    )));
    $wp_customize->add_setting( 'elearning_education_excerpt_count', array(
		'default'              => 35,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'elearning_education_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'elearning_education_excerpt_count', array(
		'label'       => esc_html__( 'Edit Excerpt Limit','elearning-education' ),
		'section'     => 'elearning_education_blog_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );
	$wp_customize->add_setting('elearning_education_read_more_text',array(
		'default'=> __('Read More','elearning-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('elearning_education_read_more_text',array(
		'label'	=> __('Edit Button Text','elearning-education'),
		'section'=> 'elearning_education_blog_option',
		'type'=> 'text'
	));
	$wp_customize->add_setting( 'elearning_education_remove_read_button', array(
	   'default'           => true,
	   'transport'         => 'refresh',
	   'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_remove_read_button', array(
		 'label'       => esc_html__( 'Show / Hide Read More Button', 'elearning-education' ),
		 'section'     => 'elearning_education_blog_option',
		 'type'        => 'toggle',
		 'settings'    => 'elearning_education_remove_read_button',
	) ) );
   	$wp_customize->selective_refresh->add_partial( 'elearning_education_remove_read_button', array(
		'selector' => '.readmore-btn',
		'render_callback' => 'elearning_education_customize_partial_elearning_education_remove_read_button',
	) );
	$wp_customize->add_setting( 'elearning_education_remove_tags', array(
	 'default'           => true,
	 'transport'         => 'refresh',
	 'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	 ) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_remove_tags', array(
		 'label'       => esc_html__( 'Show / Hide Tags Option', 'elearning-education' ),
		 'section'     => 'elearning_education_blog_option',
		 'type'        => 'toggle',
		 'settings'    => 'elearning_education_remove_tags',
	) ) );
    $wp_customize->selective_refresh->add_partial( 'elearning_education_remove_tags', array(
		'selector' => '.box-content a[rel="tag"]',
		'render_callback' => 'elearning_education_customize_partial_elearning_education_remove_tags',
	) );
	$wp_customize->add_setting( 'elearning_education_remove_category', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new eLearning_Education_Toggle_Control( $wp_customize, 'elearning_education_remove_category', array(
		'label'       => esc_html__( 'Show / Hide Category Option', 'elearning-education' ),
		'section'     => 'elearning_education_blog_option',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_remove_category',
	) ) );
    $wp_customize->selective_refresh->add_partial( 'elearning_education_remove_category', array(
		'selector' => '.box-content a[rel="category"]',
		'render_callback' => 'elearning_education_customize_partial_elearning_education_remove_category',
	));
	$wp_customize->add_setting( 'elearning_education_remove_comment', array(
	 'default'           => true,
	 'transport'         => 'refresh',
	 'sanitize_callback' => 'elearning_education_sanitize_checkbox',
 	) );

	$wp_customize->add_control( new eLearning_Education_Toggle_Control( $wp_customize, 'elearning_education_remove_comment', array(
	 'label'       => esc_html__( 'Show / Hide Comment Form', 'elearning-education' ),
	 'section'     => 'elearning_education_blog_option',
	 'type'        => 'toggle',
	 'settings'    => 'elearning_education_remove_comment',
	) ) );

	$wp_customize->add_setting( 'elearning_education_remove_related_post', array(
	 'default'           => true,
	 'transport'         => 'refresh',
	 'sanitize_callback' => 'elearning_education_sanitize_checkbox',
 	) );

	$wp_customize->add_control( new eLearning_Education_Toggle_Control( $wp_customize, 'elearning_education_remove_related_post', array(
	 'label'       => esc_html__( 'Show / Hide Related Post', 'elearning-education' ),
	 'section'     => 'elearning_education_blog_option',
	 'type'        => 'toggle',
	 'settings'    => 'elearning_education_remove_related_post',
	) ) );

	$wp_customize->add_setting('elearning_education_related_post_heading',array(
		'default'=> __('Related Posts','elearning-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('elearning_education_related_post_heading',array(
		'label'	=> __('Related Post Title','elearning-education'),
		'section'=> 'elearning_education_blog_option',
		'type'=> 'text'
	));
	
	$wp_customize->add_setting( 'elearning_education_related_post_per_page', array(
		'default'              => 3,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'elearning_education_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'elearning_education_related_post_per_page', array(
		'label'       => esc_html__( 'Related Post Per Page','elearning-education' ),
		'section'     => 'elearning_education_blog_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 3,
			'max'              => 9,
		),
	) );

	$wp_customize->add_setting( 'elearning_education_related_post_per_columns', array(
		'default'              => 3,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'elearning_education_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'elearning_education_related_post_per_columns', array(
		'label'       => esc_html__( 'Related Post Per Row','elearning-education' ),
		'section'     => 'elearning_education_blog_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 4,
		),
	) );
	
	$wp_customize->add_setting('elearning_education_post_layout',array(
        'default' => 'image-content',
        'sanitize_callback' => 'elearning_education_sanitize_choices'
	));
	$wp_customize->add_control('elearning_education_post_layout',array(
        'type' => 'radio',
        'label'     => __('Post Layout', 'elearning-education'),
        'description' => __( 'Control Works only for full,left and right sidebar position in archieve posts', 'elearning-education' ),
        'section' => 'elearning_education_blog_option',
        'choices' => array(
            'image-content' => __('Media-Content','elearning-education'),
            'content-image' => __('Content-Media','elearning-education'),
        ),
	) );

	//Mobile Responsive
	$wp_customize->add_section('elearning_education_mobile_media_option',array(
		'title'         => __('Mobile Responsive media', 'elearning-education'),
		'description' => __('Control will not function if the toggle in the main settings is off.', 'elearning-education'),
		'priority' => 22,
		'panel' => 'elearning_education_panel_id'
	) );

	$wp_customize->add_setting( 'elearning_education_return_to_header_mob', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_return_to_header_mob', array(
		'label'       => esc_html__( 'Show / Hide Return to header', 'elearning-education' ),
		'section'     => 'elearning_education_mobile_media_option',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_return_to_header_mob',
	) ) );

	$wp_customize->add_setting( 'elearning_education_slider_buttom_mob', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_slider_buttom_mob', array(
		'label'       => esc_html__( 'Show / Hide Slider Button', 'elearning-education' ),
		'section'     => 'elearning_education_mobile_media_option',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_slider_buttom_mob',
	) ) );

	$wp_customize->add_setting( 'elearning_education_related_post_mob', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_related_post_mob', array(
		'label'       => esc_html__( 'Show / Hide Related Post', 'elearning-education' ),
		'section'     => 'elearning_education_mobile_media_option',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_related_post_mob',
	) ) );


	//TP Preloader Option
	$wp_customize->add_section('elearning_education_prelaoder_option',array(
		'title'         => __('TP Preloader Option', 'elearning-education'),
		'priority' => 3,
		'panel' => 'elearning_education_panel_id'
	) );

	$wp_customize->add_setting( 'elearning_education_preloader_show_hide', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_preloader_show_hide', array(
		'label'       => esc_html__( 'Show / Hide Preloader Option', 'elearning-education' ),
		'section'     => 'elearning_education_prelaoder_option',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_preloader_show_hide',
	) ) );

	$wp_customize->add_setting( 'elearning_education_tp_preloader_color1_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'elearning_education_tp_preloader_color1_option', array(
			'label'     => __('Preloader First Ring Color', 'elearning-education'),
	    'description' => __('It will change the complete theme preloader ring 1 color in one click.', 'elearning-education'),
	    'section' => 'elearning_education_prelaoder_option',
	    'settings' => 'elearning_education_tp_preloader_color1_option',
  	)));

  	$wp_customize->add_setting( 'elearning_education_tp_preloader_color2_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'elearning_education_tp_preloader_color2_option', array(
			'label'     => __('Preloader Second Ring Color', 'elearning-education'),
	    'description' => __('It will change the complete theme preloader ring 2 color in one click.', 'elearning-education'),
	    'section' => 'elearning_education_prelaoder_option',
	    'settings' => 'elearning_education_tp_preloader_color2_option',
  	)));

  	$wp_customize->add_setting( 'elearning_education_tp_preloader_bg_color_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'elearning_education_tp_preloader_bg_color_option', array(
			'label'     => __('Preloader Background Color', 'elearning-education'),
	    'description' => __('It will change the complete theme preloader bg color in one click.', 'elearning-education'),
	    'section' => 'elearning_education_prelaoder_option',
	    'settings' => 'elearning_education_tp_preloader_bg_color_option',
  	)));

  	//MENU TYPOGRAPHY
	$wp_customize->add_section( 'elearning_education_menu_typography', array(
    	'title'      => __( 'Menu Typography', 'elearning-education' ),
    	'priority' => 10,
		'panel' => 'elearning_education_panel_id'
	) );

	$wp_customize->add_setting('elearning_education_menu_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'elearning_education_sanitize_choices',
	));
	$wp_customize->add_control(	'elearning_education_menu_font_family', array(
		'section' => 'elearning_education_menu_typography',
		'label'   => __('Menu Fonts', 'elearning-education'),
		'type'    => 'select',
		'choices' => $elearning_education_font_array,
	));

	$wp_customize->add_setting('elearning_education_menu_font_weight',array(
        'default' => '',
        'sanitize_callback' => 'elearning_education_sanitize_choices'
	));
	$wp_customize->add_control('elearning_education_menu_font_weight',array(
     'type' => 'radio',
     'label'     => __('Font Weight', 'elearning-education'),
     'section' => 'elearning_education_menu_typography',
     'type' => 'select',
     'choices' => array(
         '100' => __('100','elearning-education'),
         '200' => __('200','elearning-education'),
         '300' => __('300','elearning-education'),
         '400' => __('400','elearning-education'),
         '500' => __('500','elearning-education'),
         '600' => __('600','elearning-education'),
         '700' => __('700','elearning-education'),
         '800' => __('800','elearning-education'),
         '900' => __('900','elearning-education')
     ),
	) );

	$wp_customize->add_setting('elearning_education_menu_text_tranform',array(
		'default' => '',
		'sanitize_callback' => 'elearning_education_sanitize_choices'
 	));
 	$wp_customize->add_control('elearning_education_menu_text_tranform',array(
		'type' => 'select',
		'label' => __('Menu Text Transform','elearning-education'),
		'section' => 'elearning_education_menu_typography',
		'choices' => array(
		   'Uppercase' => __('Uppercase','elearning-education'),
		   'Lowercase' => __('Lowercase','elearning-education'),
		   'Capitalize' => __('Capitalize','elearning-education'),
		),
	) );


	$wp_customize->add_setting('elearning_education_menu_font_size', array(
	'default' => '',
    'sanitize_callback' => 'elearning_education_sanitize_number_range',
	));

	$wp_customize->add_control(new Elearning_Education_Range_Slider($wp_customize, 'elearning_education_menu_font_size', array(
    'section' => 'elearning_education_menu_typography',
    'label' => esc_html__('Font Size', 'elearning-education'),
    'input_attrs' => array(
        'min' => 0,
        'max' => 20,
        'step' => 1
    )
	)));


	// Top Bar
	$wp_customize->add_section( 'elearning_education_topbar', array(
    	'title'      => __( 'Contact Details', 'elearning-education' ),
    	'description' => __( 'Add your contact details', 'elearning-education' ),
    	'priority' => 12,
		'panel' => 'elearning_education_panel_id'
	) );

	$wp_customize->add_setting('elearning_education_phone_number',array(
		'default'=> '',
		'sanitize_callback'	=> 'elearning_education_sanitize_phone_number'
	));
	$wp_customize->add_control('elearning_education_phone_number',array(
		'label'	=> __('Add Phone Number','elearning-education'),
		'section'=> 'elearning_education_topbar',
		'type'=> 'text'
	));
	$wp_customize->add_setting('elearning_education_phone_icon',array(
		'default'	=> 'fas fa-phone',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Elearning_Education_Icon_Changer(
        $wp_customize,'elearning_education_phone_icon',array(
		'label'	=> __('Phone Icon','elearning-education'),
		'transport' => 'refresh',
		'section'	=> 'elearning_education_topbar',
		'type'		=> 'icon'
	)));
	$wp_customize->selective_refresh->add_partial( 'elearning_education_phone_number', array(
		'selector' => '.top-header span',
		'render_callback' => 'elearning_education_customize_partial_elearning_education_phone_number',
	) );

	$wp_customize->add_setting('elearning_education_email_address',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_email'
	));
	$wp_customize->add_control('elearning_education_email_address',array(
		'label'	=> __('Add Mail Address','elearning-education'),
		'section'=> 'elearning_education_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('elearning_education_mail_icon',array(
		'default'	=> 'far fa-envelope',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Elearning_Education_Icon_Changer(
        $wp_customize,'elearning_education_mail_icon',array(
		'label'	=> __('Mail Icon','elearning-education'),
		'transport' => 'refresh',
		'section'	=> 'elearning_education_topbar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('elearning_education_register_button',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('elearning_education_register_button',array(
		'label'	=> __('Add Button Text','elearning-education'),
		'section'=> 'elearning_education_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('elearning_education_register_button_link',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('elearning_education_register_button_link',array(
		'label'	=> __('Add Button URL','elearning-education'),
		'section'=> 'elearning_education_topbar',
		'type'=> 'url'
	));

	$wp_customize->add_setting('elearning_education_login_button',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('elearning_education_login_button',array(
		'label'	=> __('Add Button Text','elearning-education'),
		'section'=> 'elearning_education_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('elearning_education_login_button_link',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('elearning_education_login_button_link',array(
		'label'	=> __('Add Button URL','elearning-education'),
		'section'=> 'elearning_education_topbar',
		'type'=> 'url'
	));

	$wp_customize->add_setting('elearning_education_header_teacher',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('elearning_education_header_teacher',array(
		'label'	=> __('Add Become Teacher Text','elearning-education'),
		'section'=> 'elearning_education_topbar',
		'type'=> 'text'
	));

	$wp_customize->selective_refresh->add_partial( 'elearning_education_header_teacher', array(
		'selector' => 'a.teacher-btn',
		'render_callback' => 'elearning_education_customize_partial_elearning_education_header_teacher',
	) );

	$wp_customize->add_setting('elearning_education_header_wishlist_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('elearning_education_header_wishlist_url',array(
		'label'	=> __('Add Wishlist Link','elearning-education'),
		'section'=> 'elearning_education_topbar',
		'type'=> 'url'
	));


	// Social Media
	$wp_customize->add_section( 'elearning_education_social_media', array(
    	'title'      => __( 'Social Media Links', 'elearning-education' ),
    	'description' => __( 'Add your Social Links', 'elearning-education' ),
    	'priority' => 14,
		'panel' => 'elearning_education_panel_id'
	) );

	$wp_customize->add_setting( 'elearning_education_header_fb_new_tab', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_header_fb_new_tab', array(
		'label'       => esc_html__( 'Open in new tab', 'elearning-education' ),
		'section'     => 'elearning_education_social_media',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_header_fb_new_tab',
	) ) );

	$wp_customize->add_setting('elearning_education_facebook_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('elearning_education_facebook_url',array(
		'label'	=> __('Facebook Link','elearning-education'),
		'section'=> 'elearning_education_social_media',
		'type'=> 'url'
	));
	 $wp_customize->add_setting('elearning_education_facebook_icon',array(
		'default'	=> 'fab fa-facebook-f',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Elearning_Education_Icon_Changer(
        $wp_customize,'elearning_education_facebook_icon',array(
		'label'	=> __('Facebook Icon','elearning-education'),
		'transport' => 'refresh',
		'section'	=> 'elearning_education_social_media',
		'type'		=> 'icon'
	)));
	$wp_customize->selective_refresh->add_partial( 'elearning_education_facebook_url', array(
		'selector' => '.media-links a',
		'render_callback' => 'elearning_education_customize_partial_elearning_education_facebook_url',
	) );

	$wp_customize->add_setting( 'elearning_education_header_twt_new_tab', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_header_twt_new_tab', array(
		'label'       => esc_html__( 'Open in new tab', 'elearning-education' ),
		'section'     => 'elearning_education_social_media',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_header_twt_new_tab',
	) ) );

	$wp_customize->add_setting('elearning_education_twitter_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('elearning_education_twitter_url',array(
		'label'	=> __('Twitter Link','elearning-education'),
		'section'=> 'elearning_education_social_media',
		'type'=> 'url'
	));

	$wp_customize->add_setting('elearning_education_twitter_icon',array(
		'default'	=> 'fab fa-twitter',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Elearning_Education_Icon_Changer(
        $wp_customize,'elearning_education_twitter_icon',array(
		'label'	=> __('Twitter Icon','elearning-education'),
		'transport' => 'refresh',
		'section'	=> 'elearning_education_social_media',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'elearning_education_header_ins_new_tab', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_header_ins_new_tab', array(
		'label'       => esc_html__( 'Open in new tab', 'elearning-education' ),
		'section'     => 'elearning_education_social_media',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_header_ins_new_tab',
	) ) );

	$wp_customize->add_setting('elearning_education_instagram_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('elearning_education_instagram_url',array(
		'label'	=> __('Instagram Link','elearning-education'),
		'section'=> 'elearning_education_social_media',
		'type'=> 'url'
	));

	$wp_customize->add_setting('elearning_education_instagram_icon',array(
		'default'	=> 'fab fa-instagram',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Elearning_Education_Icon_Changer(
        $wp_customize,'elearning_education_instagram_icon',array(
		'label'	=> __('Instagram Icon','elearning-education'),
		'transport' => 'refresh',
		'section'	=> 'elearning_education_social_media',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'elearning_education_header_ut_new_tab', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_header_ut_new_tab', array(
		'label'       => esc_html__( 'Open in new tab', 'elearning-education' ),
		'section'     => 'elearning_education_social_media',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_header_ut_new_tab',
	) ) );

	$wp_customize->add_setting('elearning_education_youtube_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('elearning_education_youtube_url',array(
		'label'	=> __('YouTube Link','elearning-education'),
		'section'=> 'elearning_education_social_media',
		'type'=> 'url'
	));

	$wp_customize->add_setting('elearning_education_youtube_icon',array(
		'default'	=> 'fab fa-youtube',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Elearning_Education_Icon_Changer(
        $wp_customize,'elearning_education_youtube_icon',array(
		'label'	=> __('YouTube Icon','elearning-education'),
		'transport' => 'refresh',
		'section'	=> 'elearning_education_social_media',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'elearning_education_header_pint_new_tab', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_header_pint_new_tab', array(
		'label'       => esc_html__( 'Open in new tab', 'elearning-education' ),
		'section'     => 'elearning_education_social_media',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_header_pint_new_tab',
	) ) );

	$wp_customize->add_setting('elearning_education_pinterest_icon',array(
		'default'	=> 'fab fa-pinterest',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Elearning_Education_Icon_Changer(
        $wp_customize,'elearning_education_pinterest_icon',array(
		'label'	=> __('Pinterest Icon','elearning-education'),
		'transport' => 'refresh',
		'section'	=> 'elearning_education_social_media',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('elearning_education_pint_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('elearning_education_pint_url',array(
		'label'	=> __('Pinterest Link','elearning-education'),
		'section'=> 'elearning_education_social_media',
		'type'=> 'url'
	));

	$wp_customize->add_setting('elearning_education_social_icon_fontsize',array(
	'default'=> '12',
	'sanitize_callback'	=> 'elearning_education_sanitize_number_absint'
));
$wp_customize->add_control('elearning_education_social_icon_fontsize',array(
	'label'	=> __('Social Icons Font Size in PX','elearning-education'),
	'type'=> 'number',
	'section'=> 'elearning_education_social_media',
	'input_attrs' => array(
		'step' => 1,
		'min'  => 0,
		'max'  => 100,
			),
));

	//home page slider
	$wp_customize->add_section( 'elearning_education_slider_section' , array(
    	'title'      => __( 'Slider Section', 'elearning-education' ),
    	'priority' => 16,
		'panel' => 'elearning_education_panel_id'
	) );

		$wp_customize->add_setting('elearning_education_slider_arrows',array(
       'default' => false,
       'sanitize_callback'	=> 'elearning_education_sanitize_checkbox'
    ));
		$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_slider_arrows', array(
			'label'       => esc_html__( 'Show / Hide Slider', 'elearning-education' ),
			'priority' => 1,
			'section'     => 'elearning_education_slider_section',
			'type'        => 'toggle',
			'settings'    => 'elearning_education_slider_arrows',
		) ) );
    $wp_customize->selective_refresh->add_partial( 'elearning_education_slider_arrows', array(
		'selector' => '#slider .carousel-caption',
		'render_callback' => 'elearning_education_customize_partial_elearning_education_slider_arrows',
	) );

	for ( $elearning_education_count = 1; $elearning_education_count <= 4; $elearning_education_count++ ) {

		$wp_customize->add_setting( 'elearning_education_slider_page' . $elearning_education_count, array(
			'default'           => '',
			'sanitize_callback' => 'elearning_education_sanitize_dropdown_pages'
		) );

		$wp_customize->add_control( 'elearning_education_slider_page' . $elearning_education_count, array(
			'label'    => __( 'Select Slide Image Page', 'elearning-education' ),
			'priority' => 1,
			'section'  => 'elearning_education_slider_section',
			'type'     => 'dropdown-pages'
		) );
	}

	$wp_customize->add_setting('elearning_education_slider_top',array(
	    'default'=> '',
	    'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('elearning_education_slider_top',array(
	    'label' => __('Add Slider Top Text','elearning-education'),
	    'section'=> 'elearning_education_slider_section',
	    'type'=> 'text'
	));

	$wp_customize->add_setting( 'elearning_education_slider_button', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_slider_button', array(
		'label'       => esc_html__( 'Show / Hide Slider Button', 'elearning-education' ),
		'section'     => 'elearning_education_slider_section',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_slider_button',
	) ) );
	
	$wp_customize->add_setting('elearning_education_slider_content_layout',array(
        'default' => '',
        'sanitize_callback' => 'elearning_education_sanitize_choices'
	));
	$wp_customize->add_control('elearning_education_slider_content_layout',array(
        'type' => 'radio',
        'label'     => __('Slider Content Layout', 'elearning-education'),
        'section' => 'elearning_education_slider_section',
        'choices' => array(
            'CENTER-ALIGN' => __('CENTER-ALIGN','elearning-education'),
            'LEFT-ALIGN' => __('LEFT-ALIGN','elearning-education'),
            'RIGHT-ALIGN' => __('RIGHT-ALIGN','elearning-education'),
        ),
	) );

	//Online Courses Section
	$wp_customize->add_section('elearning_education_online_courses_section',array(
		'title'	=> __('Online Courses Section','elearning-education'),
		'priority' => 18,
		'panel' => 'elearning_education_panel_id',
	));

	$wp_customize->add_setting( 'elearning_education_online_courses_enable', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'elearning_education_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_online_courses_enable', array(
		'label'       => esc_html__( 'Show / Hide section', 'elearning-education' ),
		'section'     => 'elearning_education_online_courses_section',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_online_courses_enable',
	) ) );

	$wp_customize->add_setting('elearning_education_online_courses_heading',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('elearning_education_online_courses_heading',array(
		'label'	=> __('Courses Title','elearning-education'),
		'section'	=> 'elearning_education_online_courses_section',
		'type'		=> 'text'
	));
	$wp_customize->selective_refresh->add_partial( 'elearning_education_online_courses_heading', array(
		'selector' => '#online-courses h2',
		'render_callback' => 'elearning_education_customize_partial_elearning_education_online_courses_heading',
	) );

	$wp_customize->add_setting('elearning_education_online_courses_sub_heading',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('elearning_education_online_courses_sub_heading',array(
		'label'	=> __('Courses Sub Title','elearning-education'),
		'section'	=> 'elearning_education_online_courses_section',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('elearning_education_online_courses_per_page',array(
		'default' => '',
		'sanitize_callback'	=> 'elearning_education_sanitize_number_absint'
	));
	$wp_customize->add_control('elearning_education_online_courses_per_page',array(
		'label'	=> __('Number Of Courses','elearning-education'),
		'section'	=> 'elearning_education_online_courses_section',
		'type'		=> 'number'
	));

	$elearning_education_args = array(
		'type'                     => 'lp_course',
		'child_of'                 => 0,
		'parent'                   => '',
		'orderby'                  => 'term_group',
		'order'                    => 'ASC',
		'hide_empty'               => false,
		'hierarchical'             => 1,
		'number'                   => '',
		'taxonomy'                 => 'course_category',
		'pad_counts'               => false
	);
	$elearning_education_categories = get_categories($elearning_education_args);
	$cat_posts = array();
	$m = 0;
	$cat_posts[]='Select';
	foreach($elearning_education_categories as $category){
		if($m==0){
			$default = $category->slug;
			$m++;
		}
		$cat_posts[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('elearning_education_online_courses_category',array(
		'default'	=> 'select',
		'priority' => 8,
		'sanitize_callback' => 'elearning_education_sanitize_select',
	));
	$wp_customize->add_control('elearning_education_online_courses_category',array(
		'type'    => 'select',
		'choices' => $cat_posts,
		'label' => __('Select category to display courses ','elearning-education'),
		'section' => 'elearning_education_online_courses_section',
	));

	//footer
	$wp_customize->add_section('elearning_education_footer_section',array(
		'title'	=> __('Footer Text','elearning-education'),
		'priority' => 20,
		'description'	=> __('Add copyright text.','elearning-education'),
		'panel' => 'elearning_education_panel_id'
	));

	$wp_customize->add_setting('elearning_education_footer_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('elearning_education_footer_text',array(
		'label'	=> __('Copyright Text','elearning-education'),
		'section'	=> 'elearning_education_footer_section',
		'type'		=> 'text'
	));

	// footer columns
	$wp_customize->add_setting('elearning_education_footer_columns',array(
		'default'	=> 4,
		'sanitize_callback'	=> 'elearning_education_sanitize_number_absint'
	));
	$wp_customize->add_control('elearning_education_footer_columns',array(
		'label'	=> __('Footer Widget Columns','elearning-education'),
		'section'	=> 'elearning_education_footer_section',
		'setting'	=> 'elearning_education_footer_columns',
		'type'	=> 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 4,
		),
	));

	$wp_customize->add_setting( 'elearning_education_tp_footer_bg_color_option', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'elearning_education_tp_footer_bg_color_option', array(
			'label'     => __('Footer Widget Background Color', 'elearning-education'),
			'description' => __('It will change the complete footer widget backgorund color.', 'elearning-education'),
			'section' => 'elearning_education_footer_section',
			'settings' => 'elearning_education_tp_footer_bg_color_option',
	)));

	$wp_customize->selective_refresh->add_partial( 'elearning_education_footer_text', array(
		'selector' => '#footer p',
		'render_callback' => 'elearning_education_customize_partial_elearning_education_footer_text',
	) );

	$wp_customize->add_setting('elearning_education_footer_widget_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'elearning_education_footer_widget_image',array(
    'label' => __('Footer Widget Background Image','elearning-education'),
    'section' => 'elearning_education_footer_section'
	)));

	$wp_customize->add_setting('elearning_education_return_to_header',array(
		 'default' => true,
		 'sanitize_callback'	=> 'elearning_education_sanitize_checkbox'
	));
	$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_return_to_header', array(
		'label'       => esc_html__( 'Show / Hide Return To Header', 'elearning-education' ),
		'section'     => 'elearning_education_footer_section',
		'type'        => 'toggle',
		'settings'    => 'elearning_education_return_to_header',
	) ) );

	 $wp_customize->add_setting('elearning_education_scroll_top_icon',array(
		'default'	=> 'fas fa-arrow-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Elearning_Education_Icon_Changer(
        $wp_customize,'elearning_education_scroll_top_icon',array(
		'label'	=> __('Scroll to top Icon','elearning-education'),
		'transport' => 'refresh',
		'section'	=> 'elearning_education_footer_section',
		'type'		=> 'icon'
	)));

   // Add Settings and Controls for Scroll top
	$wp_customize->add_setting('elearning_education_scroll_top_position',array(
        'default' => 'Right',
        'sanitize_callback' => 'elearning_education_sanitize_choices'
	));
	$wp_customize->add_control('elearning_education_scroll_top_position',array(
        'type' => 'radio',
        'label'     => __('Scroll to top Position', 'elearning-education'),
        'description'   => __('This option work for scroll to top', 'elearning-education'),
        'section' => 'elearning_education_footer_section',
        'choices' => array(
            'Right' => __('Right','elearning-education'),
            'Left' => __('Left','elearning-education'),
            'Center' => __('Center','elearning-education')
        ),
	) );

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'elearning_education_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'elearning_education_customize_partial_blogdescription',
	) );

		$wp_customize->add_setting('elearning_education_site_title_text',array(
			 'default' => true,
			 'sanitize_callback'	=> 'elearning_education_sanitize_checkbox'
		));
		$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_site_title_text', array(
			'label'       => esc_html__( 'Show / Hide Site Title', 'elearning-education' ),
			'section'     => 'title_tagline',
			'type'        => 'toggle',
			'settings'    => 'elearning_education_site_title_text',
		) ) );

		// logo site title size
		$wp_customize->add_setting('elearning_education_site_title_font_size',array(
			'default'	=> 30,
			'sanitize_callback'	=> 'elearning_education_sanitize_number_absint'
		));
		$wp_customize->add_control('elearning_education_site_title_font_size',array(
			'label'	=> __('Site Title Font Size in PX','elearning-education'),
			'section'	=> 'title_tagline',
			'setting'	=> 'elearning_education_site_title_font_size',
			'type'	=> 'number',
			'input_attrs' => array(
				'step'             => 1,
				'min'              => 0,
				'max'              => 80,
			),
		));

		$wp_customize->add_setting('elearning_education_site_tagline_text',array(
			 'default' => false,
			 'sanitize_callback'	=> 'elearning_education_sanitize_checkbox'
		));
		$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_site_tagline_text', array(
			'label'       => esc_html__( 'Show / Hide Site Tagline', 'elearning-education' ),
			'section'     => 'title_tagline',
			'type'        => 'toggle',
			'settings'    => 'elearning_education_site_tagline_text',
		) ) );


		// logo site tagline size
	$wp_customize->add_setting('elearning_education_site_tagline_font_size',array(
		'default'	=> 15,
		'sanitize_callback'	=> 'elearning_education_sanitize_number_absint'
	));
	$wp_customize->add_control('elearning_education_site_tagline_font_size',array(
		'label'	=> __('Site Tagline Font Size in PX','elearning-education'),
		'section'	=> 'title_tagline',
		'setting'	=> 'elearning_education_site_tagline_font_size',
		'type'	=> 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	));

    $wp_customize->add_setting('elearning_education_logo_width',array(
		'default' => 100,
		'sanitize_callback'	=> 'elearning_education_sanitize_number_absint'
	));
	 $wp_customize->add_control('elearning_education_logo_width',array(
		'label'	=> esc_html__('Here You Can Customize Your Logo Size','elearning-education'),
		'section'	=> 'title_tagline',
		'type'		=> 'number'
	));

	$wp_customize->add_setting('elearning_education_logo_settings',array(
        'default' => 'Different Line',
        'sanitize_callback' => 'elearning_education_sanitize_choices'
	));
    $wp_customize->add_control('elearning_education_logo_settings',array(
        'type' => 'radio',
        'label'     => __('Logo Layout Settings', 'elearning-education'),
        'description'   => __('Here you have two options 1. Logo and Site tite in differnt line. 2. Logo and Site title in same line.', 'elearning-education'),
        'section' => 'title_tagline',
        'choices' => array(
            'Different Line' => __('Different Line','elearning-education'),
            'Same Line' => __('Same Line','elearning-education')
        ),
	) );

	$wp_customize->add_setting('elearning_education_per_columns',array(
		'default'=> 3,
		'sanitize_callback'	=> 'elearning_education_sanitize_number_absint'
	));
	$wp_customize->add_control('elearning_education_per_columns',array(
		'label'	=> __('Product Per Row','elearning-education'),
		'section'=> 'woocommerce_product_catalog',
		'type'=> 'number'
	));

	$wp_customize->add_setting('elearning_education_product_per_page',array(
		'default'=> 9,
		'sanitize_callback'	=> 'elearning_education_sanitize_number_absint'
	));
	$wp_customize->add_control('elearning_education_product_per_page',array(
		'label'	=> __('Product Per Page','elearning-education'),
		'section'=> 'woocommerce_product_catalog',
		'type'=> 'number'
	));

		$wp_customize->add_setting('elearning_education_product_sidebar',array(
			 'default' => true,
			 'sanitize_callback'	=> 'elearning_education_sanitize_checkbox'
		));
		$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_product_sidebar', array(
			'label'       => esc_html__( 'Show / Hide Shop Page Sidebar', 'elearning-education' ),
			'section'     => 'woocommerce_product_catalog',
			'type'        => 'toggle',
			'settings'    => 'elearning_education_product_sidebar',
		) ) );

		$wp_customize->add_setting('elearning_education_sale_tag_position',array(
        'default' => 'right',
        'sanitize_callback' => 'elearning_education_sanitize_choices'
	));
	$wp_customize->add_control('elearning_education_sale_tag_position',array(
        'type' => 'radio',
        'label'     => __('Sale Badge Position', 'elearning-education'),
        'description'   => __('This option work for Archieve Products', 'elearning-education'),
        'section' => 'woocommerce_product_catalog',
        'choices' => array(
            'left' => __('Left','elearning-education'),
            'right' => __('Right','elearning-education'),
        ),
	) );

		$wp_customize->add_setting('elearning_education_single_product_sidebar',array(
			 'default' => true,
			 'sanitize_callback'	=> 'elearning_education_sanitize_checkbox'
		));
		$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_single_product_sidebar', array(
			'label'       => esc_html__( 'Show / Hide Product Page Sidebar', 'elearning-education' ),
			'section'     => 'woocommerce_product_catalog',
			'type'        => 'toggle',
			'settings'    => 'elearning_education_single_product_sidebar',
		) ) );

		$wp_customize->add_setting( 'elearning_education_related_product', array(
			'default'           => true,
			'transport'         => 'refresh',
			'sanitize_callback' => 'elearning_education_sanitize_checkbox',
		) );
		$wp_customize->add_control( new Elearning_Education_Toggle_Control( $wp_customize, 'elearning_education_related_product', array(
			'label'       => esc_html__( 'Show / Hide related product', 'elearning-education' ),
			'section'     => 'woocommerce_product_catalog',
			'type'        => 'toggle',
			'settings'    => 'elearning_education_related_product',
		) ) );
	// 404 PAGE
	$wp_customize->add_section('elearning_education_404_page_section',array(
		'title'         => __('404 Page', 'elearning-education'),
		'description'   => 'Here you can customize 404 Page content.',
	) );
	$wp_customize->add_setting('elearning_education_not_found_title',array(
		'default'=> __('Oops! That page cant be found.','elearning-education'),
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	$wp_customize->add_control('elearning_education_not_found_title',array(
		'label'	=> __('Edit Title','elearning-education'),
		'section'=> 'elearning_education_404_page_section',
		'type'=> 'text',
	));
	$wp_customize->add_setting('elearning_education_not_found_text',array(
		'default'=> __('It looks like nothing was found at this location. Maybe try a search?','elearning-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('elearning_education_not_found_text',array(
		'label'	=> __('Edit Text','elearning-education'),
		'section'=> 'elearning_education_404_page_section',
		'type'=> 'text'
	));
}
add_action( 'customize_register', 'elearning_education_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since eLearning Education 1.0
 * @see elearning_education_customize_register()
 *
 * @return void
 */
function elearning_education_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since eLearning Education 1.0
 * @see elearning_education_customize_register()
 *
 * @return void
 */
function elearning_education_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if ( ! defined( 'ELEARNING_EDUCATION_PRO_THEME_NAME' ) ) {
	define( 'ELEARNING_EDUCATION_PRO_THEME_NAME', esc_html__( 'Education Pro Theme', 'elearning-education' ));
}
if ( ! defined( 'ELEARNING_EDUCATION_PRO_THEME_URL' ) ) {
	define( 'ELEARNING_EDUCATION_PRO_THEME_URL', esc_url('https://www.themespride.com/products/elearning-education-wordpress-theme'));
}
if ( ! defined( 'ELEARNING_EDUCATION_DOCS_URL' ) ) {
	define( 'ELEARNING_EDUCATION_DOCS_URL', esc_url('https://page.themespride.com/demo/docs/elearning-education-lite/'));
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class eLearning_Education_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'eLearning_Education_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new eLearning_Education_Customize_Section_Pro(
				$manager,
				'elearning_education_section_pro',
				array(
					'priority'   => 9,
					'title'    => ELEARNING_EDUCATION_PRO_THEME_NAME,
					'pro_text' => esc_html__( 'Upgrade Pro', 'elearning-education' ),
					'pro_url'  => esc_url( ELEARNING_EDUCATION_PRO_THEME_URL, 'elearning-education' ),
				)
			)
		);

		// Register sections.
		$manager->add_section(
			new eLearning_Education_Customize_Section_Pro(
				$manager,
				'elearning_education_documentation',
				array(
					'priority'   => 500,
					'title'    => esc_html__( 'Theme Documentation', 'elearning-education' ),
					'pro_text' => esc_html__( 'Click Here', 'elearning-education' ),
					'pro_url'  => esc_url( ELEARNING_EDUCATION_DOCS_URL, 'elearning-education'),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'elearning-education-customize-controls', trailingslashit( esc_url( get_template_directory_uri() ) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'elearning-education-customize-controls', trailingslashit( esc_url( get_template_directory_uri() ) ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
eLearning_Education_Customize::get_instance();
