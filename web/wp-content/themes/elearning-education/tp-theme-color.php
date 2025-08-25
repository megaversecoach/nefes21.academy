<?php

$elearning_education_tp_theme_css = '';

//theme color
$elearning_education_tp_color_option = get_theme_mod('elearning_education_tp_color_option');

if($elearning_education_tp_color_option != false){
$elearning_education_tp_theme_css .='button[type="submit"],.main-navigation .menu > ul > li.highlight,.box:before,.box:after,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.page-numbers,.prev.page-numbers,.next.page-numbers,span.meta-nav,#theme-sidebar button[type="submit"],#footer button[type="submit"],#comments input[type="submit"],.site-info,.book-tkt-btn a.register-btn,a.register-btn,a.login-btn,#theme-sidebar .tagcloud a:hover,.search_inner [type="submit"],.error-404 [type="submit"],.wc-block-cart__submit-container a,.wc-block-checkout__actions_row .wc-block-components-checkout-place-order-button,.wc-block-grid__product-add-to-cart.wp-block-button .wp-block-button__link,.woocommerce ul.products li.product .onsale, .woocommerce span.onsale,.main-navigation,.sidenav,.page-template-front-page .innermenubox ,.page-template-front-page .stick_head,#theme-sidebar .wp-block-search .wp-block-search__label:before,#theme-sidebar h3:before, #theme-sidebar h1.wp-block-heading:before, #theme-sidebar h2.wp-block-heading:before, #theme-sidebar h3.wp-block-heading:before,#theme-sidebar h4.wp-block-heading:before, #theme-sidebar h5.wp-block-heading:before, #theme-sidebar h6.wp-block-heading:before {';
$elearning_education_tp_theme_css .='background-color: '.esc_attr($elearning_education_tp_color_option).'!important ;';
$elearning_education_tp_theme_css .='}';
}
if($elearning_education_tp_color_option != false){
$elearning_education_tp_theme_css .='a,a:hover ,#theme-sidebar .textwidget a,#footer .textwidget a,.comment-body a,.entry-content a,.entry-summary a,.page-template-front-page .media-links a:hover,.topbar-home i.fas.fa-phone-volume,#theme-sidebar h3,.page-box h4 a,#footer h3,.courses-info strong,#footer h1.wp-block-heading, #footer h2.wp-block-heading, #footer h3.wp-block-heading,#footer h4.wp-block-heading, #footer h5.wp-block-heading, #footer h6.wp-block-heading ,#theme-sidebar h3, #theme-sidebar h1.wp-block-heading, #theme-sidebar h2.wp-block-heading, #theme-sidebar h3.wp-block-heading,#theme-sidebar h4.wp-block-heading, #theme-sidebar h5.wp-block-heading, #theme-sidebar h6.wp-block-heading,.box-content a, #footer li a:hover, #theme-sidebar li a:hover , #theme-sidebar a:hover, theme-sidebar .wp-block-search .wp-block-search__label, #theme-sidebar .widget_tag_cloud a:hover,.box-info i,.readmore-btn a,a.added_to_cart.wc-forward,#footer .tagcloud a:hover,#footer p.wp-block-tag-cloud a:hover,#theme-sidebar .tagcloud a:hover, #slider .inner_carousel p.slider-top{';
$elearning_education_tp_theme_css .='color: '.esc_attr($elearning_education_tp_color_option).';';
$elearning_education_tp_theme_css .='}';
}
if($elearning_education_tp_color_option != false){
$elearning_education_tp_theme_css .='#footer .tagcloud a:hover,#footer p.wp-block-tag-cloud a:hover, #theme-sidebar a:hover,.post_tag a:hover, #theme-sidebar .widget_tag_cloud a:hover,.readmore-btn a{';
	$elearning_education_tp_theme_css .='border-color: '.esc_attr($elearning_education_tp_color_option).';';
$elearning_education_tp_theme_css .='}';
}
if($elearning_education_tp_color_option != false){
$elearning_education_tp_theme_css .='.page-box,#theme-sidebar section {';
    $elearning_education_tp_theme_css .='border-left-color: '.esc_attr($elearning_education_tp_color_option).';';
$elearning_education_tp_theme_css .='}';
}
if($elearning_education_tp_color_option != false){
$elearning_education_tp_theme_css .='.page-box,#theme-sidebar section {';
    $elearning_education_tp_theme_css .='border-bottom-color: '.esc_attr($elearning_education_tp_color_option).';';
$elearning_education_tp_theme_css .='}';
}
if($elearning_education_tp_color_option != false){
$elearning_education_tp_theme_css .='@media screen and (max-width:560px){';
$elearning_education_tp_theme_css .='.page-template-front-page .menubar{';
	$elearning_education_tp_theme_css .='background-color: '.esc_attr($elearning_education_tp_color_option).' !important;';
$elearning_education_tp_theme_css .='} }';
}

if($elearning_education_tp_color_option != false){
$elearning_education_tp_theme_css .='@media screen and (max-width:560px){';
$elearning_education_tp_theme_css .='#slider .carousel-control-prev-icon, #slider .carousel-control-next-icon{';
	$elearning_education_tp_theme_css .='color: '.esc_attr($elearning_education_tp_color_option).';';
$elearning_education_tp_theme_css .='} }';
}



if($elearning_education_tp_color_option != false){
$elearning_education_tp_theme_css .='#slider .carousel-control-prev-icon, #slider .carousel-control-next-icon,.menubar{';
	$elearning_education_tp_theme_css .='background: '.esc_attr($elearning_education_tp_color_option).';';
$elearning_education_tp_theme_css .='}';
}

//--secoundary-color----
$elearning_education_tp_secoundary_color_option = get_theme_mod('elearning_education_tp_secoundary_color_option');

if($elearning_education_tp_secoundary_color_option != false){
$elearning_education_tp_theme_css .='.top-header,a.teacher-btn,#theme-sidebar button[type="submit"]:hover, #footer button[type="submit"]:hover,.main-navigation ul ul,  .next.page-numbers:hover , .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce button.button.alt:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button.alt:hover,.wc-block-cart__submit-container a:hover,.wc-block-grid__product-add-to-cart.wp-block-button .wp-block-button__link:hover{';
$elearning_education_tp_theme_css .='background-color: '.esc_attr($elearning_education_tp_secoundary_color_option).';';
$elearning_education_tp_theme_css .='}';
}
if($elearning_education_tp_secoundary_color_option != false){
$elearning_education_tp_theme_css .=' a:hover, .headerbox i,.main-navigation .current_page_item > a, .main-navigation .current-menu-item > a,.main-navigation a:hover, #online-courses h2,.readmore-btn a:hover {';
$elearning_education_tp_theme_css .='color: '.esc_attr($elearning_education_tp_secoundary_color_option).';';
$elearning_education_tp_theme_css .='}';
}
if($elearning_education_tp_secoundary_color_option != false){
$elearning_education_tp_theme_css .='.readmore-btn a:hover{';
	$elearning_education_tp_theme_css .='border-color: '.esc_attr($elearning_education_tp_secoundary_color_option).';';
$elearning_education_tp_theme_css .='}';
}

if($elearning_education_tp_secoundary_color_option != false){
$elearning_education_tp_theme_css .='@media screen and (max-width:1000px){';
$elearning_education_tp_theme_css .='.nav ul li a:hover {';
	$elearning_education_tp_theme_css .='color: '.esc_attr($elearning_education_tp_secoundary_color_option).';';
$elearning_education_tp_theme_css .='} }';
}
//preloader

$elearning_education_tp_preloader_color1_option = get_theme_mod('elearning_education_tp_preloader_color1_option');
$elearning_education_tp_preloader_color2_option = get_theme_mod('elearning_education_tp_preloader_color2_option');
$elearning_education_tp_preloader_bg_color_option = get_theme_mod('elearning_education_tp_preloader_bg_color_option');

if($elearning_education_tp_preloader_color1_option != false){
$elearning_education_tp_theme_css .='.center1{';
	$elearning_education_tp_theme_css .='border-color: '.esc_attr($elearning_education_tp_preloader_color1_option).' !important;';
$elearning_education_tp_theme_css .='}';
}
if($elearning_education_tp_preloader_color1_option != false){
$elearning_education_tp_theme_css .='.center1 .ring::before{';
	$elearning_education_tp_theme_css .='background: '.esc_attr($elearning_education_tp_preloader_color1_option).' !important;';
$elearning_education_tp_theme_css .='}';
}
if($elearning_education_tp_preloader_color2_option != false){
$elearning_education_tp_theme_css .='.center2{';
	$elearning_education_tp_theme_css .='border-color: '.esc_attr($elearning_education_tp_preloader_color2_option).' !important;';
$elearning_education_tp_theme_css .='}';
}
if($elearning_education_tp_preloader_color2_option != false){
$elearning_education_tp_theme_css .='.center2 .ring::before{';
	$elearning_education_tp_theme_css .='background: '.esc_attr($elearning_education_tp_preloader_color2_option).' !important;';
$elearning_education_tp_theme_css .='}';
}
if($elearning_education_tp_preloader_bg_color_option != false){
$elearning_education_tp_theme_css .='.loader{';
	$elearning_education_tp_theme_css .='background: '.esc_attr($elearning_education_tp_preloader_bg_color_option).';';
$elearning_education_tp_theme_css .='}';
}

$elearning_education_tp_footer_bg_color_option = get_theme_mod('elearning_education_tp_footer_bg_color_option');
if($elearning_education_tp_footer_bg_color_option != false){
$elearning_education_tp_theme_css .='#footer{';
	$elearning_education_tp_theme_css .='background-color: '.esc_attr($elearning_education_tp_footer_bg_color_option).';';
$elearning_education_tp_theme_css .='}';
}
