<?php

	$elearning_education_tp_theme_css = "";

	$elearning_education_theme_lay = get_theme_mod( 'elearning_education_tp_body_layout_settings','Full');
    if($elearning_education_theme_lay == 'Container'){
		$elearning_education_tp_theme_css .='body{';
			$elearning_education_tp_theme_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$elearning_education_tp_theme_css .='}';

		$elearning_education_tp_theme_css .='@media screen and (min-width:1367px){';
		$elearning_education_tp_theme_css .='body{';
			$elearning_education_tp_theme_css .='max-width: 1320px;';
		$elearning_education_tp_theme_css .='} }';

		$elearning_education_tp_theme_css .='@media screen and (max-width:575px){';
		$elearning_education_tp_theme_css .='body{';
			$elearning_education_tp_theme_css .='max-width: 100%; padding-right:0px; padding-left: 0px';
		$elearning_education_tp_theme_css .='} }';
		$elearning_education_tp_theme_css .='.scrolled{';
			$elearning_education_tp_theme_css .='width: auto; left:0; right:0;';
		$elearning_education_tp_theme_css .='}';
	}else if($elearning_education_theme_lay == 'Container Fluid'){
		$elearning_education_tp_theme_css .='body{';
			$elearning_education_tp_theme_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$elearning_education_tp_theme_css .='}';
		$elearning_education_tp_theme_css .='.page-template-front-page .menubar{';
			$elearning_education_tp_theme_css .='width: 99%';
		$elearning_education_tp_theme_css .='}';
		$elearning_education_tp_theme_css .='@media screen and (max-width:575px){';
		$elearning_education_tp_theme_css .='body{';
			$elearning_education_tp_theme_css .='max-width: 100%; padding-right:0px; padding-left:0px';
		$elearning_education_tp_theme_css .='} }';
		$elearning_education_tp_theme_css .='.scrolled{';
			$elearning_education_tp_theme_css .='width: auto; left:0; right:0;';
		$elearning_education_tp_theme_css .='}';
	}else if($elearning_education_theme_lay == 'Full'){
		$elearning_education_tp_theme_css .='body{';
			$elearning_education_tp_theme_css .='max-width: 100%;';
		$elearning_education_tp_theme_css .='}';
	}

    $elearning_education_scroll_position = get_theme_mod( 'elearning_education_scroll_top_position','Right');
    if($elearning_education_scroll_position == 'Right'){
        $elearning_education_tp_theme_css .='#return-to-top{';
            $elearning_education_tp_theme_css .='right: 20px;';
        $elearning_education_tp_theme_css .='}';
    }else if($elearning_education_scroll_position == 'Left'){
        $elearning_education_tp_theme_css .='#return-to-top{';
            $elearning_education_tp_theme_css .='left: 20px;';
        $elearning_education_tp_theme_css .='}';
    }else if($elearning_education_scroll_position == 'Center'){
        $elearning_education_tp_theme_css .='#return-to-top{';
            $elearning_education_tp_theme_css .='right: 50%;left: 50%;';
        $elearning_education_tp_theme_css .='}';
    }

		//Social icon Font size
$elearning_education_social_icon_fontsize = get_theme_mod('elearning_education_social_icon_fontsize');
			$elearning_education_tp_theme_css .='.media-links a i{';
$elearning_education_tp_theme_css .='font-size: '.esc_attr($elearning_education_social_icon_fontsize).'px;';
			$elearning_education_tp_theme_css .='}';

// site title and tagline font size option
$elearning_education_site_title_font_size = get_theme_mod('elearning_education_site_title_font_size', 30);{
			$elearning_education_tp_theme_css .='.logo h1 a, .logo p a{';
$elearning_education_tp_theme_css .='font-size: '.esc_attr($elearning_education_site_title_font_size).'px;';
			$elearning_education_tp_theme_css .='}';
}

$elearning_education_site_tagline_font_size = get_theme_mod('elearning_education_site_tagline_font_size', 15);{
			$elearning_education_tp_theme_css .='.logo p{';
$elearning_education_tp_theme_css .='font-size: '.esc_attr($elearning_education_site_tagline_font_size).'px;';
			$elearning_education_tp_theme_css .='}';
}


// related post
$elearning_education_related_post_mob = get_theme_mod('elearning_education_related_post_mob', true);
$elearning_education_related_post = get_theme_mod('elearning_education_remove_related_post', true);
$elearning_education_tp_theme_css .= '.related-post-block {';
if ($elearning_education_related_post == false) {
    $elearning_education_tp_theme_css .= 'display: none;';
}
$elearning_education_tp_theme_css .= '}';
$elearning_education_tp_theme_css .= '@media screen and (max-width: 575px) {';
if ($elearning_education_related_post == false || $elearning_education_related_post_mob == false) {
    $elearning_education_tp_theme_css .= '.related-post-block { display: none; }';
}
$elearning_education_tp_theme_css .= '}';

// slider btn
$elearning_education_slider_buttom_mob = get_theme_mod('elearning_education_slider_buttom_mob', true);
$elearning_education_slider_button = get_theme_mod('elearning_education_slider_button', true);
$elearning_education_tp_theme_css .= '#slider .more-btn {';
if ($elearning_education_slider_button == false) {
    $elearning_education_tp_theme_css .= 'display: none;';
}
$elearning_education_tp_theme_css .= '}';
$elearning_education_tp_theme_css .= '@media screen and (max-width: 575px) {';
if ($elearning_education_slider_button == false || $elearning_education_slider_buttom_mob == false) {
    $elearning_education_tp_theme_css .= '#slider .more-btn { display: none; }';
}
$elearning_education_tp_theme_css .= '}';

//return to header mobile				
$elearning_education_return_to_header_mob = get_theme_mod('elearning_education_return_to_header_mob', true);
$elearning_education_return_to_header = get_theme_mod('elearning_education_return_to_header', true);
$elearning_education_tp_theme_css .= '.return-to-header{';
if ($elearning_education_return_to_header == false) {
    $elearning_education_tp_theme_css .= 'display: none;';
}
$elearning_education_tp_theme_css .= '}';
$elearning_education_tp_theme_css .= '@media screen and (max-width: 575px) {';
if ($elearning_education_return_to_header == false || $elearning_education_return_to_header_mob == false) {
    $elearning_education_tp_theme_css .= '.return-to-header{ display: none; }';
}
$elearning_education_tp_theme_css .= '}';


	$elearning_education_footer_widget_image = get_theme_mod('elearning_education_footer_widget_image');
	if($elearning_education_footer_widget_image != false){
		$elearning_education_tp_theme_css .='#footer{';
			$elearning_education_tp_theme_css .='background: url('.esc_attr($elearning_education_footer_widget_image).');';
		$elearning_education_tp_theme_css .='}';
	}

$elearning_education_related_product = get_theme_mod('elearning_education_related_product',true);
		if($elearning_education_related_product == false){
			$elearning_education_tp_theme_css .='.related.products{';
				$elearning_education_tp_theme_css .='display: none;';
			$elearning_education_tp_theme_css .='}';
		}



//======================= MENU TYPOGRAPHY ===================== //


$elearning_education_menu_font_size = get_theme_mod('elearning_education_menu_font_size', '');{
$elearning_education_tp_theme_css .='.main-navigation a, .main-navigation li.page_item_has_children:after,.main-navigation li.menu-item-has-children:after{';
$elearning_education_tp_theme_css .='font-size: '.esc_attr($elearning_education_menu_font_size).'px;';
	$elearning_education_tp_theme_css .='}';
}

$elearning_education_menu_text_tranform = get_theme_mod( 'elearning_education_menu_text_tranform','');
    if($elearning_education_menu_text_tranform == 'Uppercase'){
		$elearning_education_tp_theme_css .='.main-navigation a {';
			$elearning_education_tp_theme_css .='text-transform: uppercase;';
		$elearning_education_tp_theme_css .='}';
	}else if($elearning_education_menu_text_tranform == 'Lowercase'){
		$elearning_education_tp_theme_css .='.main-navigation a {';
			$elearning_education_tp_theme_css .='text-transform: lowercase;';
		$elearning_education_tp_theme_css .='}';
	}
	else if($elearning_education_menu_text_tranform == 'Capitalize'){
		$elearning_education_tp_theme_css .='.main-navigation a {';
			$elearning_education_tp_theme_css .='text-transform: capitalize;';
		$elearning_education_tp_theme_css .='}';
	}

//======================= slider Content layout ===================== //

$elearning_education_slider_content_layout = get_theme_mod('elearning_education_slider_content_layout', ''); 
$elearning_education_tp_theme_css .= '#slider .carousel-caption{';
switch ($elearning_education_slider_content_layout) {
    case 'LEFT-ALIGN':
        $elearning_education_tp_theme_css .= 'text-align:left; right: 50%; left: 15%';
        break;
    case 'CENTER-ALIGN':
        $elearning_education_tp_theme_css .= 'text-align:center; right: 50%; left: 15%';
        break;
    case 'RIGHT-ALIGN':
        $elearning_education_tp_theme_css .= 'text-align:right; right: 50%; left: 15%';
        break;
    default:
        $elearning_education_tp_theme_css .= 'text-align:left; right: 50%; left: 15%';
        break;
}
$elearning_education_tp_theme_css .= '}';

//sale position
$elearning_education_scroll_position = get_theme_mod( 'elearning_education_sale_tag_position','right');
if($elearning_education_scroll_position == 'right'){
$elearning_education_tp_theme_css .='.woocommerce ul.products li.product .onsale{';
    $elearning_education_tp_theme_css .='right: 25px !important;';
$elearning_education_tp_theme_css .='}';
}else if($elearning_education_scroll_position == 'left'){
$elearning_education_tp_theme_css .='.woocommerce ul.products li.product .onsale{';
    $elearning_education_tp_theme_css .='left: 25px !important; right: auto !important;';
$elearning_education_tp_theme_css .='}';
}

//Font Weight
$elearning_education_menu_font_weight = get_theme_mod( 'elearning_education_menu_font_weight','');
if($elearning_education_menu_font_weight == '100'){
$elearning_education_tp_theme_css .='.main-navigation a{';
    $elearning_education_tp_theme_css .='font-weight: 100;';
$elearning_education_tp_theme_css .='}';
}else if($elearning_education_menu_font_weight == '200'){
$elearning_education_tp_theme_css .='.main-navigation a{';
    $elearning_education_tp_theme_css .='font-weight: 200;';
$elearning_education_tp_theme_css .='}';
}else if($elearning_education_menu_font_weight == '300'){
$elearning_education_tp_theme_css .='.main-navigation a{';
    $elearning_education_tp_theme_css .='font-weight: 300;';
$elearning_education_tp_theme_css .='}';
}else if($elearning_education_menu_font_weight == '400'){
$elearning_education_tp_theme_css .='.main-navigation a{';
    $elearning_education_tp_theme_css .='font-weight: 400;';
$elearning_education_tp_theme_css .='}';
}else if($elearning_education_menu_font_weight == '500'){
$elearning_education_tp_theme_css .='.main-navigation a{';
    $elearning_education_tp_theme_css .='font-weight: 500;';
$elearning_education_tp_theme_css .='}';
}else if($elearning_education_menu_font_weight == '600'){
$elearning_education_tp_theme_css .='.main-navigation a{';
    $elearning_education_tp_theme_css .='font-weight: 600;';
$elearning_education_tp_theme_css .='}';
}else if($elearning_education_menu_font_weight == '700'){
$elearning_education_tp_theme_css .='.main-navigation a{';
    $elearning_education_tp_theme_css .='font-weight: 700;';
$elearning_education_tp_theme_css .='}';
}else if($elearning_education_menu_font_weight == '800'){
$elearning_education_tp_theme_css .='.main-navigation a{';
    $elearning_education_tp_theme_css .='font-weight: 800;';
$elearning_education_tp_theme_css .='}';
}else if($elearning_education_menu_font_weight == '900'){
$elearning_education_tp_theme_css .='.main-navigation a{';
    $elearning_education_tp_theme_css .='font-weight: 900;';
$elearning_education_tp_theme_css .='}';
}
