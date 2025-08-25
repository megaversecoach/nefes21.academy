<?php
/**
 * Dancing Star About Theme
 *
 * @package Dancing Star
 */

//about theme info
add_action( 'admin_menu', 'dancing_star_abouttheme' );
function dancing_star_abouttheme() {    	
	add_theme_page( __('About Theme Info', 'dancing-star'), __('About Theme Info', 'dancing-star'), 'edit_theme_options', 'dancing_star_guide', 'dancing_star_mostrar_guide');   
} 

//Info of the theme
function dancing_star_mostrar_guide() { 	
?>

<h1><?php esc_html_e('About Theme Info', 'dancing-star'); ?></h1>
<hr />  

<p><?php esc_html_e('Dancing Star Lite is the ideal choice when it comes to picking up a free dance school WordPress theme for your dance school or studio. The theme plays a vital role in the success of a website, and hence it should be selected cautiously. The features that this theme has to offer are absolutely great! This minimalistic and professional-looking multipurpose theme is highly functional and efficient. With this easy to install theme, you can start working on your website in under minutes. This 100% responsive and user-friendly theme is retina-ready, which allows it to run smoothly on every device, regardless of what the resolution is. This Free dance school WordPress theme perfectly suits any ballet class, dance school, dance academy, dancing studio, dance instructor, fitness, dance club, jazz, salsa, Zumba, choreography and related websites. This theme can also be used for martial art training classes, aerobics classes, yoga centres, fitness trainer, musical projects, bands, radio, orchestra, studios, and more.', 'dancing-star'); ?></p>

<h2><?php esc_html_e('Theme Features', 'dancing-star'); ?></h2>
<hr />  
 
<h3><?php esc_html_e('Theme Customizer', 'dancing-star'); ?></h3>
<p><?php esc_html_e('The built-in customizer panel quickly change aspects of the design and display changes live before saving them.', 'dancing-star'); ?></p>


<h3><?php esc_html_e('Responsive Ready', 'dancing-star'); ?></h3>
<p><?php esc_html_e('The themes layout will automatically adjust and fit on any screen resolution and looks great on any device. Fully optimized for iPhone and iPad.', 'dancing-star'); ?></p>


<h3><?php esc_html_e('Cross Browser Compatible', 'dancing-star'); ?></h3>
<p><?php esc_html_e('Our themes are tested in all mordern web browsers and compatible with the latest version including Chrome,Firefox, Safari, Opera, IE11 and above.', 'dancing-star'); ?></p>


<h3><?php esc_html_e('E-commerce', 'dancing-star'); ?></h3>
<p><?php esc_html_e('Fully compatible with WooCommerce plugin. Just install the plugin and turn your site into a full featured online shop and start selling products.', 'dancing-star'); ?></p>

<hr />  	
<p><a href="http://gracethemesdemo.com/documentation/dancing-star/#homepage-lite" target="_blank"><?php esc_html_e('Documentation', 'dancing-star'); ?></a></p>

<?php } ?>