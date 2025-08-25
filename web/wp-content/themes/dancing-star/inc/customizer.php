<?php    
/**
 *dancing-star Theme Customizer
 *
 * @package Dancing Star
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function dancing_star_customize_register( $wp_customize ) {	
	
	function dancing_star_sanitize_dropdown_pages( $page_id, $setting ) {
	  // Ensure $input is an absolute integer.
	  $page_id = absint( $page_id );	
	  // If $page_id is an ID of a published page, return it; otherwise, return the default.
	  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	}

	function dancing_star_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	} 
	
	function dancing_star_sanitize_phone_number( $phone ) {
		// sanitize phone
		return preg_replace( '/[^\d+]/', '', $phone );
	} 
	
	
	function dancing_star_sanitize_excerptrange( $number, $setting ) {	
		// Ensure input is an absolute integer.
		$number = absint( $number );	
		// Get the input attributes associated with the setting.
		$atts = $setting->manager->get_control( $setting->id )->input_attrs;	
		// Get minimum number in the range.
		$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );	
		// Get maximum number in the range.
		$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );	
		// Get step.
		$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );	
		// If the number is within the valid range, return it; otherwise, return the default
		return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
	}

	function dancing_star_sanitize_number_absint( $number, $setting ) {
		// Ensure $number is an absolute integer (whole number, zero or greater).
		$number = absint( $number );		
		// If the input is an absolute integer, return it; otherwise, return the default
		return ( $number ? $number : $setting->default );
	}
	
	// Ensure is an absolute integer
	function dancing_star_sanitize_choices( $input, $setting ) {
		global $wp_customize; 
		$control = $wp_customize->get_control( $setting->id ); 
		if ( array_key_exists( $input, $control->choices ) ) {
			return $input;
		} else {
			return $setting->default;
		}
	}
	
		
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.logo h1 a',
		'render_callback' => 'dancing_star_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.logo p',
		'render_callback' => 'dancing_star_customize_partial_blogdescription',
	) );
		
	 	
	//Panel for section & control
	$wp_customize->add_panel( 'dancing_star_theme_optionspanel', array(
		'priority' => 4,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Dancing Star Theme Settings', 'dancing-star' ),		
	) );

	$wp_customize->add_section('dancing_star_sitelayout',array(
		'title' => __('Layout Style','dancing-star'),			
		'priority' => 1,
		'panel' => 	'dancing_star_theme_optionspanel',          
	));		
	
	$wp_customize->add_setting('dancing_star_sitelayout',array(
		'sanitize_callback' => 'dancing_star_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'dancing_star_sitelayout', array(
    	'section'   => 'dancing_star_sitelayout',    	 
		'label' => __('Check to Show Box Layout','dancing-star'),
		'description' => __('check for box layout','dancing-star'),
    	'type'      => 'checkbox'
     )); //Box Layout Options 
	
	$wp_customize->add_setting('dancing_star_colorscheme',array(
		'default' => '#8160b2',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'dancing_star_colorscheme',array(
			'label' => __('Color Scheme','dancing-star'),			
			'section' => 'colors',
			'settings' => 'dancing_star_colorscheme'
		))
	);
	
	$wp_customize->add_setting('dancing_star_secondcolor',array(
		'default' => '#d4739e',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'dancing_star_secondcolor',array(
			'label' => __('Second Color','dancing-star'),			
			'section' => 'colors',
			'settings' => 'dancing_star_secondcolor'
		))
	);
	
	$wp_customize->add_setting('dancing_star_menufontcolor',array(
		'default' => '#333333',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'dancing_star_menufontcolor',array(
			'label' => __('Navigation font Color','dancing-star'),			
			'section' => 'colors',
			'settings' => 'dancing_star_menufontcolor'
		))
	);
	
	
	$wp_customize->add_setting('dancing_star_menufontactivecolor',array(
		'default' => '#8160b2',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'dancing_star_menufontactivecolor',array(
			'label' => __('Navigation Hover/Active Color','dancing-star'),			
			'section' => 'colors',
			'settings' => 'dancing_star_menufontactivecolor'
		))
	);
	
	
	 //Header Contact details
	$wp_customize->add_section('dancing_star_topstrip',array(
		'title' => __('Header Contact Details','dancing-star'),				
		'priority' => null,
		'panel' => 	'dancing_star_theme_optionspanel',
	));	
	
	$wp_customize->add_setting('dancing_star_hdrtelephone',array(
		'default' => null,
		'sanitize_callback' => 'dancing_star_sanitize_phone_number'	
	));
	
	$wp_customize->add_control('dancing_star_hdrtelephone',array(	
		'type' => 'text',
		'label' => __('Enter phone number here','dancing-star'),
		'section' => 'dancing_star_topstrip',
		'setting' => 'dancing_star_hdrtelephone'
	));
	
	$wp_customize->add_setting('dancing_star_emailid',array(
		'sanitize_callback' => 'sanitize_email'
	));
	
	$wp_customize->add_control('dancing_star_emailid',array(
		'type' => 'email',
		'label' => __('enter email id here.','dancing-star'),
		'section' => 'dancing_star_topstrip'
	));	
	
	 $wp_customize->add_setting('dancing_star_bookbtn',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('dancing_star_bookbtn',array(	
		'type' => 'text',
		'label' => __('Enter button name here','dancing-star'),
		'setting' => 'dancing_star_bookbtn',
		'section' => 'dancing_star_topstrip'
	));	
	
	$wp_customize->add_setting('dancing_star_bookbtnlink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('dancing_star_bookbtnlink',array(
		'label' => __('Add button link here','dancing-star'),		
		'setting' => 'dancing_star_bookbtnlink',
		'section' => 'dancing_star_topstrip'
	));	
	
	$wp_customize->add_setting('dancing_star_facebooklink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'	
	));
	
	$wp_customize->add_control('dancing_star_facebooklink',array(
		'label' => __('Add facebook link here','dancing-star'),
		'section' => 'dancing_star_topstrip',
		'setting' => 'dancing_star_facebooklink'
	));	
	
	$wp_customize->add_setting('dancing_star_twitterlink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('dancing_star_twitterlink',array(
		'label' => __('Add twitter link here','dancing-star'),
		'section' => 'dancing_star_topstrip',
		'setting' => 'dancing_star_twitterlink'
	));

	
	$wp_customize->add_setting('dancing_star_linkedinlink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('dancing_star_linkedinlink',array(
		'label' => __('Add linkedin link here','dancing-star'),
		'section' => 'dancing_star_topstrip',
		'setting' => 'dancing_star_linkedinlink'
	));
	
	$wp_customize->add_setting('dancing_star_instagramlink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('dancing_star_instagramlink',array(
		'label' => __('Add instagram link here','dancing-star'),
		'section' => 'dancing_star_topstrip',
		'setting' => 'dancing_star_instagramlink'
	));		
	
	$wp_customize->add_setting('dancing_star_show_topstrip',array(
		'default' => false,
		'sanitize_callback' => 'dancing_star_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'dancing_star_show_topstrip', array(
	   'settings' => 'dancing_star_show_topstrip',
	   'section'   => 'dancing_star_topstrip',
	   'label'     => __('Check To show Header contact Section','dancing-star'),
	   'type'      => 'checkbox'
	 ));//Show Header Contact Details Sections
	 
	 	
	//Frontpage Slide Section		
	$wp_customize->add_section( 'dancing_star_frontslider', array(
		'title' => __('Frontpage Slider Sections', 'dancing-star'),
		'priority' => null,
		'description' => __('Default image size for slider is 1400 x 885 pixel.','dancing-star'), 
		'panel' => 	'dancing_star_theme_optionspanel',           			
    ));
	
	$wp_customize->add_setting('dancing_star_sliderpageno1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'dancing_star_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('dancing_star_sliderpageno1',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 1:','dancing-star'),
		'section' => 'dancing_star_frontslider'
	));	
	
	$wp_customize->add_setting('dancing_star_sliderpageno2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'dancing_star_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('dancing_star_sliderpageno2',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 2:','dancing-star'),
		'section' => 'dancing_star_frontslider'
	));	
	
	$wp_customize->add_setting('dancing_star_sliderpageno3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'dancing_star_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('dancing_star_sliderpageno3',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 3:','dancing-star'),
		'section' => 'dancing_star_frontslider'
	));	//frontpage Slider Section	
	
	//Slider Excerpt Length
	$wp_customize->add_setting( 'dancing_star_excerpt_length_frontslider', array(
		'default'              => 0,
		'type'                 => 'theme_mod',		
		'sanitize_callback'    => 'dancing_star_sanitize_excerptrange',		
	) );
	$wp_customize->add_control( 'dancing_star_excerpt_length_frontslider', array(
		'label'       => __( 'Slider Excerpt length','dancing-star' ),
		'section'     => 'dancing_star_frontslider',
		'type'        => 'range',
		'settings'    => 'dancing_star_excerpt_length_frontslider','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );	
	
	$wp_customize->add_setting('dancing_star_sliderpageno_btntext',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('dancing_star_sliderpageno_btntext',array(	
		'type' => 'text',
		'label' => __('enter button name here','dancing-star'),
		'section' => 'dancing_star_frontslider',
		'setting' => 'dancing_star_sliderpageno_btntext'
	)); // slider read more button text
	
		
	$wp_customize->add_setting('dancing_star_show_frontslider',array(
		'default' => false,
		'sanitize_callback' => 'dancing_star_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'dancing_star_show_frontslider', array(
	    'settings' => 'dancing_star_show_frontslider',
	    'section'   => 'dancing_star_frontslider',
	    'label'     => __('Check To Show This Section','dancing-star'),
	   'type'      => 'checkbox'
	 ));//Show FrontPage Slider Options	
	 
	 //Four Column Services Sections
	$wp_customize->add_section('dancing_star_fourcolumn_options', array(
		'title' => __('Four Column Services Sections','dancing-star'),
		'description' => __('Select pages from the dropdown for four column sections','dancing-star'),
		'priority' => null,
		'panel' => 	'dancing_star_theme_optionspanel',          
	));
		
	$wp_customize->add_setting('dancing_star_fourcolpage1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'dancing_star_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'dancing_star_fourcolpage1',array(
		'type' => 'dropdown-pages',			
		'section' => 'dancing_star_fourcolumn_options',
	));		
	
	$wp_customize->add_setting('dancing_star_fourcolpage2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'dancing_star_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'dancing_star_fourcolpage2',array(
		'type' => 'dropdown-pages',			
		'section' => 'dancing_star_fourcolumn_options',
	));
	
	$wp_customize->add_setting('dancing_star_fourcolpage3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'dancing_star_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'dancing_star_fourcolpage3',array(
		'type' => 'dropdown-pages',			
		'section' => 'dancing_star_fourcolumn_options',
	));	
	
	$wp_customize->add_setting('dancing_star_fourcolpage4',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'dancing_star_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'dancing_star_fourcolpage4',array(
		'type' => 'dropdown-pages',			
		'section' => 'dancing_star_fourcolumn_options',
	));		
	
	$wp_customize->add_setting( 'dancing_star_excerpt_length_fourcolumn', array(
		'default'              => 10,
		'type'                 => 'theme_mod',		
		'sanitize_callback'    => 'dancing_star_sanitize_excerptrange',		
	) );
	$wp_customize->add_control( 'dancing_star_excerpt_length_fourcolumn', array(
		'label'       => __( 'four page box excerpt length','dancing-star' ),
		'section'     => 'dancing_star_fourcolumn_options',
		'type'        => 'range',
		'settings'    => 'dancing_star_excerpt_length_fourcolumn','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );	
	
	$wp_customize->add_setting('dancing_star_show_fourcolumn_options',array(
		'default' => false,
		'sanitize_callback' => 'dancing_star_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));		
	
	$wp_customize->add_control( 'dancing_star_show_fourcolumn_options', array(
	   'settings' => 'dancing_star_show_fourcolumn_options',
	   'section'   => 'dancing_star_fourcolumn_options',
	   'label'     => __('Check To Show This Section','dancing-star'),
	   'type'      => 'checkbox'
	 ));//Show Four Column Options
	 
	 
	 //Welcome Page Sections
	$wp_customize->add_section('dancing_star_welcome_sections', array(
		'title' => __('Welcome Page Sections','dancing-star'),
		'description' => __('Select pages from the dropdown for welcome page sections','dancing-star'),
		'priority' => null,
		'panel' => 	'dancing_star_theme_optionspanel',          
	));
		
	$wp_customize->add_setting('dancing_star_welcomepgbx',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'dancing_star_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'dancing_star_welcomepgbx',array(
		'type' => 'dropdown-pages',			
		'section' => 'dancing_star_welcome_sections',
	));	
	
	$wp_customize->add_setting( 'dancing_star_excerpt_length_welcomepgbx', array(
		'default'              => 40,
		'type'                 => 'theme_mod',		
		'sanitize_callback'    => 'dancing_star_sanitize_excerptrange',		
	) );
	$wp_customize->add_control( 'dancing_star_excerpt_length_welcomepgbx', array(
		'label'       => __( 'excerpt length for welcome page','dancing-star' ),
		'section'     => 'dancing_star_welcome_sections',
		'type'        => 'range',
		'settings'    => 'dancing_star_excerpt_length_welcomepgbx','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );
	
	$wp_customize->add_setting('dancing_star_show_welcome_sections',array(
		'default' => false,
		'sanitize_callback' => 'dancing_star_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));		
	
	$wp_customize->add_control( 'dancing_star_show_welcome_sections', array(
	   'settings' => 'dancing_star_show_welcome_sections',
	   'section'   => 'dancing_star_welcome_sections',
	   'label'     => __('Check To Show This Section','dancing-star'),
	   'type'      => 'checkbox'
	 ));//Show Welcome Page sections
	 
	 //Blog Posts Settings
	$wp_customize->add_panel( 'dancing_star_blogpage_settings', array(
		'priority' => 3,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Blog Posts Settings', 'dancing-star' ),		
	) );
	
	$wp_customize->add_section('dancing_star_blog_meta',array(
		'title' => __('Blog Meta Options','dancing-star'),			
		'priority' => null,
		'panel' => 	'dancing_star_blogpage_settings', 	         
	));		
	
	$wp_customize->add_setting('dancing_star_hide_blogdate',array(
		'sanitize_callback' => 'dancing_star_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'dancing_star_hide_blogdate', array(
    	'label' => __('Check to hide post date','dancing-star'),	
		'section'   => 'dancing_star_blog_meta', 
		'setting' => 'dancing_star_hide_blogdate',		
    	'type'      => 'checkbox'
     )); //Blog Post Date
	 
	 
	 $wp_customize->add_setting('dancing_star_hide_postcats',array(
		'sanitize_callback' => 'dancing_star_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'dancing_star_hide_postcats', array(
		'label' => __('Check to hide post category','dancing-star'),	
    	'section'   => 'dancing_star_blog_meta',		
		'setting' => 'dancing_star_hide_postcats',		
    	'type'      => 'checkbox'
     )); //blog Posts category	 
	 
	 
	 $wp_customize->add_section('dancing_star_post_ftimg',array(
		'title' => __('Posts Featured image','dancing-star'),			
		'priority' => null,
		'panel' => 	'dancing_star_blogpage_settings', 	         
	));		
	
	$wp_customize->add_setting('dancing_star_hide_postfeatured_image',array(
		'sanitize_callback' => 'dancing_star_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'dancing_star_hide_postfeatured_image', array(
		'label' => __('Check to hide post featured image','dancing-star'),
    	'section'   => 'dancing_star_post_ftimg',		
		'setting' => 'dancing_star_hide_postfeatured_image',	
    	'type'      => 'checkbox'
     )); //Posts featured image
	
	$wp_customize->add_section('dancing_star_blogpost_contentoption',array(
		'title' => __('Posts Excerpt Options','dancing-star'),			
		'priority' => null,
		'panel' => 	'dancing_star_blogpage_settings', 	         
	 ));	 
	 
	$wp_customize->add_setting( 'dancing_star_blogexcerptlength', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'dancing_star_sanitize_excerptrange',		
	) );
	
	$wp_customize->add_control( 'dancing_star_blogexcerptlength', array(
		'label'       => __( 'Excerpt length','dancing-star' ),
		'section'     => 'dancing_star_blogpost_contentoption',
		'type'        => 'range',
		'settings'    => 'dancing_star_blogexcerptlength','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting('dancing_star_blogfullcontent',array(
        'default' => 'Excerpt',     
        'sanitize_callback' => 'dancing_star_sanitize_choices'
	));
	
	$wp_customize->add_control('dancing_star_blogfullcontent',array(
        'type' => 'select',
        'label' => __('Posts Content','dancing-star'),
        'section' => 'dancing_star_blogpost_contentoption',
        'choices' => array(
        	'Content' => __('Content','dancing-star'),
            'Excerpt' => __('Excerpt','dancing-star'),
            'No Content' => __('No Excerpt','dancing-star')
        ),
	) ); 
	
	
	$wp_customize->add_section('dancing_star_postsinglemeta',array(
		'title' => __('Posts Single Settings','dancing-star'),			
		'priority' => null,
		'panel' => 	'dancing_star_blogpage_settings', 	         
	));	
	
	$wp_customize->add_setting('dancing_star_hide_postdate_fromsingle',array(
		'sanitize_callback' => 'dancing_star_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'dancing_star_hide_postdate_fromsingle', array(
    	'label' => __('Check to hide post date from single','dancing-star'),	
		'section'   => 'dancing_star_postsinglemeta', 
		'setting' => 'dancing_star_hide_postdate_fromsingle',		
    	'type'      => 'checkbox'
     )); //Hide Posts date from single
	 
	 
	 $wp_customize->add_setting('dancing_star_hide_postcats_fromsingle',array(
		'sanitize_callback' => 'dancing_star_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'dancing_star_hide_postcats_fromsingle', array(
		'label' => __('Check to hide post category from single','dancing-star'),	
    	'section'   => 'dancing_star_postsinglemeta',		
		'setting' => 'dancing_star_hide_postcats_fromsingle',		
    	'type'      => 'checkbox'
     )); //Hide blogposts category single

	
		 
}
add_action( 'customize_register', 'dancing_star_customize_register' );

function dancing_star_custom_css(){ 
?>
	<style type="text/css"> 					
        a,
        #sidebar ul li a:hover,
		#sidebar ol li a:hover,							
        .PostStyle_01 h3 a:hover,
        .postmeta a:hover,
		.FourCol:hover h4 a,
		.FourCol .BX1 h4 a,			 			
        .button:hover,
		.Wel_DescBX h3 span,
		.woocommerce table.shop_table th, 
		.woocommerce-page table.shop_table th,
		h2.services_title span,			
		.site-footer ul li a:hover, 
		.site-footer ul li.current_page_item a,				
		.blog-postmeta a:hover,
		.blog-postmeta a:focus,
		blockquote::before	
            { color:<?php echo esc_html( get_theme_mod('dancing_star_colorscheme','#8160b2')); ?>;}					 
            
        .pagination ul li .current, .pagination ul li a:hover, 
        #commentform input#submit:hover,
		.HeadStrip,
		.WelImgBX:after,
		.HeadStrip:before,
		.HeadStrip:after,
        .nivo-controlNav a.active,
		.sd-search input, .sd-top-bar-nav .sd-search input,			
		a.blogreadmore,		
		.FourCol .ImgCol,
		.thumbbx-title h4,
		a.ReadMoreBtn,
		.copyrigh-wrapper:before,										
        #sidebar .search-form input.search-submit,				
        .wpcf7 input[type='submit'],				
        nav.pagination .page-numbers.current,		
		.morebutton,		
		.nivo-directionNav a:hover,	
		.nivo-caption .slidermorebtn:hover		
            { background-color:<?php echo esc_html( get_theme_mod('dancing_star_colorscheme','#8160b2')); ?>;}
			

		
		.tagcloud a:hover,
		.logo::after,
		blockquote
            { border-color:<?php echo esc_html( get_theme_mod('dancing_star_colorscheme','#8160b2')); ?>;}
			
		#SiteWrapper a:focus,
		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="date"]:focus,
		input[type="search"]:focus,
		input[type="number"]:focus,
		input[type="tel"]:focus,
		input[type="button"]:focus,
		input[type="month"]:focus,
		button:focus,		
		input[type="range"]:focus,		
		input[type="password"]:focus,
		input[type="datetime"]:focus,
		input[type="week"]:focus,
		input[type="submit"]:focus,
		input[type="datetime-local"]:focus,		
		input[type="url"]:focus,
		input[type="time"]:focus,
		input[type="reset"]:focus,
		input[type="color"]:focus,
		textarea:focus
            { outline:1px solid <?php echo esc_html( get_theme_mod('dancing_star_colorscheme','#8160b2')); ?>;}	
			
		.FourCol .BX2 h4 a			
            { color:<?php echo esc_html( get_theme_mod('dancing_star_secondcolor','#d4739e')); ?>;}	
		
		
		a.quote:hover,
		.site-header.innerpage_header a.quote:hover,
		.nivo-directionNav a,
		.FourCol .BX2 a.PageMorebtn,
		.nivo-caption .slidermorebtn:hover 			
            { background-color:<?php echo esc_html( get_theme_mod('dancing_star_secondcolor','#d4739e')); ?>;}		
			
		
		.SiteNav a,
		.SiteNav ul li.current_page_parent ul.sub-menu li a,
		.SiteNav ul li.current_page_parent ul.sub-menu li.current_page_item ul.sub-menu li a,
		.SiteNav ul li.current-menu-ancestor ul.sub-menu li.current-menu-item ul.sub-menu li a  			
            { color:<?php echo esc_html( get_theme_mod('dancing_star_menufontcolor','#333333')); ?>;}	
			
		
		 
		.SiteNav .nav-menu a:hover,
		.SiteNav .nav-menu a:focus,
		.SiteNav .nav-menu ul a:hover,
		.SiteNav .nav-menu ul a:focus,
		.SiteNav ul li a:hover, 
		.SiteNav ul.nav-menu .current_page_item > a,
		.SiteNav ul.nav-menu .current-menu-item > a,
		.SiteNav ul.nav-menu .current_page_ancestor > a,
		.SiteNav ul.nav-menu .current-menu-ancestor > a,
		.SiteNav ul li.current-menu-item a,			
		.SiteNav ul li.current_page_parent ul.sub-menu li.current-menu-item a,
		.SiteNav ul li.current_page_parent ul.sub-menu li a:hover,
		.SiteNav ul li.current-menu-item ul.sub-menu li a:hover,
		.SiteNav ul li.current-menu-ancestor ul.sub-menu li.current-menu-item ul.sub-menu li a:hover 		 			
            { color:<?php echo esc_html( get_theme_mod('dancing_star_menufontactivecolor','#8160b2')); ?>;}
			
	
			
		#SiteWrapper .SiteNav a:focus		 			
            { outline:1px solid <?php echo esc_html( get_theme_mod('dancing_star_menufontactivecolor','#8160b2')); ?>;}	
	
    </style> 
<?php 
}
         
add_action('wp_head','dancing_star_custom_css');	 

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function dancing_star_customize_preview_js() {
	wp_enqueue_script( 'dancing_star_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '19062019', true );
}
add_action( 'customize_preview_init', 'dancing_star_customize_preview_js' );