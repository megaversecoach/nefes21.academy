<?php

function online_courses_hub_remove_customize_register() {
    global $wp_customize;

    $wp_customize->remove_setting( 'elearning_education_footer_widget_image' );
    $wp_customize->remove_control( 'elearning_education_footer_widget_image' );

    $wp_customize->remove_setting( 'elearning_education_tp_footer_bg_color_option' );
    $wp_customize->remove_control( 'elearning_education_tp_footer_bg_color_option' );

    $wp_customize->remove_setting( 'elearning_education_slider_content_layout' );
    $wp_customize->remove_control( 'elearning_education_slider_content_layout' );

    $wp_customize->remove_setting( 'elearning_education_tp_secoundary_color_option' );
    $wp_customize->remove_control( 'elearning_education_tp_secoundary_color_option' );

}
add_action( 'customize_register', 'online_courses_hub_remove_customize_register', 11 );

function online_courses_hub_customize_register( $wp_customize ) {

    // Register the custom control type.
    $wp_customize->register_control_type( 'Online_Courses_Hub_Toggle_Control' );


    $wp_customize->add_setting('online_courses_hub_slider_content_layout',array(
        'default' => 'CENTER-ALIGN',
        'sanitize_callback' => 'elearning_education_sanitize_choices'
    ));
    $wp_customize->add_control('online_courses_hub_slider_content_layout',array(
        'type' => 'radio',
        'label'     => __('Slider Content Layout', 'online-courses-hub'),
        'section' => 'elearning_education_slider_section',
        'choices' => array(
            'LEFT-ALIGN' => __('LEFT-ALIGN','online-courses-hub'),
            'CENTER-ALIGN' => __('CENTER-ALIGN','online-courses-hub'),
            'RIGHT-ALIGN' => __('RIGHT-ALIGN','online-courses-hub'),
        ),
    ) );

    // Course Fields
    $wp_customize->add_section('online_courses_hub_course_fields_section',array(
        'title' => __('Course Fields','online-courses-hub'),
        'description'   => __('Course Fields Sections','online-courses-hub'),
        'panel' => 'elearning_education_panel_id',
        'priority' => 17,
    ));

    $wp_customize->add_setting( 'online_courses_hub_course_enable', array(
        'default'           => false,
        'transport'         => 'refresh',
        'sanitize_callback' => 'elearning_education_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Online_Courses_Hub_Toggle_Control( $wp_customize, 'online_courses_hub_course_enable', array(
        'label'       => esc_html__( 'Show / Hide section', 'online-courses-hub' ),
        'section'     => 'online_courses_hub_course_fields_section',
        'type'        => 'toggle',
        'settings'    => 'online_courses_hub_course_enable',
    ) ) );

    $wp_customize->add_setting('online_courses_hub_course_fields_number',array(
        'default'   => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_courses_hub_course_fields_number',array(
        'label' => __('Number of Courses','online-courses-hub'),
        'section' => 'online_courses_hub_course_fields_section',
        'type'=>'number'
    ));
    $wp_customize->selective_refresh->add_partial( 'online_courses_hub_course_fields_number', array(
        'selector' => '.course-fields-box h4',
        'render_callback' => 'online_courses_hub_customize_partial_online_courses_hub_course_fields_number',
    ) );

    $online_courses_hub_count =  get_theme_mod('online_courses_hub_course_fields_number');
    for($i=1; $i<=$online_courses_hub_count; $i++ ) {

        $wp_customize->add_setting('online_courses_hub_course_fields_icon_'.$i,array(
            'default' => '',
            'sanitize_callback'   => 'sanitize_text_field',
        ));
        $wp_customize->add_control('online_courses_hub_course_fields_icon_'.$i,array(
            'label' => __('Course Icon','online-courses-hub'),
            'section' => 'online_courses_hub_course_fields_section',
            'type'  => 'text'
        ));

        $wp_customize->add_setting('online_courses_hub_course_fields_heading_'.$i,array(
            'default' => '',
            'sanitize_callback'   => 'sanitize_text_field',
        ));
        $wp_customize->add_control('online_courses_hub_course_fields_heading_'.$i,array(
            'label' => __('Course Name','online-courses-hub'),
            'section' => 'online_courses_hub_course_fields_section',
            'type'  => 'text'
        ));

        $wp_customize->add_setting('online_courses_hub_course_fields_text_'.$i,array(
            'default'  => '',
            'sanitize_callback'    => 'sanitize_text_field',
        ));
        $wp_customize->add_control('online_courses_hub_course_fields_text_'.$i,array(
            'label' => __('Course Description','online-courses-hub'),
            'section' => 'online_courses_hub_course_fields_section',
            'type' => 'text'
        ));
    }

    // Popular Course
    $wp_customize->add_section('online_courses_hub_popular_course_section',array(
        'title' => __('Popular Course','online-courses-hub'),
        'description' => __('Popular Course Sections','online-courses-hub'),
        'panel' => 'elearning_education_panel_id',
        'priority' => 18,
    ));
    
    $wp_customize->add_setting( 'online_courses_hub_popular_courses_enable', array(
        'default'           => false,
        'transport'         => 'refresh',
        'sanitize_callback' => 'elearning_education_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Online_Courses_Hub_Toggle_Control( $wp_customize, 'online_courses_hub_popular_courses_enable', array(
        'label'       => esc_html__( 'Show / Hide section', 'online-courses-hub' ),
        'section'     => 'online_courses_hub_popular_course_section',
        'type'        => 'toggle',
        'settings'    => 'online_courses_hub_popular_courses_enable',
    ) ) );

    $wp_customize->add_setting('online_courses_hub_popular_courses_text',array(
        'default'   => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_courses_hub_popular_courses_text',array(
        'label' => __('Section Title','online-courses-hub'),
        'section' => 'online_courses_hub_popular_course_section',
        'type' => 'text'
    ));
    $wp_customize->selective_refresh->add_partial( 'online_courses_hub_popular_courses_text', array(
        'selector' => '#popular_topic h2',
        'render_callback' => 'online_courses_hub_customize_partial_online_courses_hub_popular_courses_text',
    ) );


    $categories = get_categories();
    $cats = array();
    $i = 0;
    $online_courses_offer_cat[]= 'select';
    foreach($categories as $category){
        if($i==0){
            $default = $category->slug;
            $i++;
        }
        $online_courses_offer_cat[$category->slug] = $category->name;
    }

    $wp_customize->add_setting('online_courses_hub_popular_courses_category',array(
        'default'   => 'select',
        'sanitize_callback' => 'elearning_education_sanitize_choices',
    ));
    $wp_customize->add_control('online_courses_hub_popular_courses_category',array(
        'type'    => 'select',
        'choices' => $online_courses_offer_cat,
        'label' => __('Select Category','online-courses-hub'),
        'section' => 'online_courses_hub_popular_course_section',
    ));

}
add_action( 'customize_register', 'online_courses_hub_customize_register' );
