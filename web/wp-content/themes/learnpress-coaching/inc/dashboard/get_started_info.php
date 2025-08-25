<?php

add_action( 'admin_menu', 'learnpress_coaching_gettingstarted' );
function learnpress_coaching_gettingstarted() {    	
	add_theme_page( esc_html__('About Theme', 'learnpress-coaching'), esc_html__('Theme Demo Content', 'learnpress-coaching'), 'edit_theme_options', 'learnpress-coaching-guide-page', 'learnpress_coaching_guide');   
}

function learnpress_coaching_admin_theme_style() {
   wp_enqueue_style('learnpress-coaching-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/dashboard/get_started_info.css');
}
add_action('admin_enqueue_scripts', 'learnpress_coaching_admin_theme_style');

function learnpress_coaching_notice(){
    global $pagenow;
    if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {?>
    <div class="notice notice-success is-dismissible getting_started">
		<div class="notice-content">
			<h2><?php esc_html_e( 'Thanks for installing Learnpress Coaching, you rock!', 'learnpress-coaching' ) ?> </h2>
			<p><?php esc_html_e( 'Take benefit of a variety of features, functionalities, elements, and an exclusive set of customization options to build your own professional coaching website. Please Click on the link below to know the theme setup information.', 'learnpress-coaching' ) ?></p>
			<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=learnpress-coaching-guide-page' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Get Start with Theme Demo Import', 'learnpress-coaching' ); ?></a></p>
		</div>
	</div>
	<?php }
}
add_action('admin_notices', 'learnpress_coaching_notice');

/**
 * Theme Info Page
 */
function learnpress_coaching_guide() {

	// Theme info
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'learnpress-coaching' ); ?>

	<div class="wrap getting-started">
		<div class="getting-started__header">
	    	<div>
                <h2 class="tgmpa-notice-warning"></h2>
            </div>
			<div class="row">
				<div class="col-md-5 intro">
					<div class="pad-box">
						<h2><?php esc_html_e( 'Welcome to Learnpress Coaching', 'learnpress-coaching' ); ?></h2>
						<p>Version: <?php echo esc_html($theme['Version']);?></p>
						<span class="intro__version"><?php esc_html_e( 'Congratulations! You are about to use the most easy to use and flexible WordPress theme.', 'learnpress-coaching' ); ?>	
						</span>
						<div class="powered-by">
							<p><strong><?php esc_html_e( 'Theme created by Buy WP Templates', 'learnpress-coaching' ); ?></strong></p>
							<p>
								<img class="logo" src="<?php echo esc_url(get_template_directory_uri() . '/inc/dashboard/media/theme-logo.png'); ?>"/>
							</p>
							<div class="demo-content">
							<?php
								/* Get Started. */
								require get_parent_theme_file_path( '/inc/dashboard/demo-content.php' );
							?>
						</div>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="pro-links">
				    	<a href="<?php echo esc_url( LEARNPREE_COACHING_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'learnpress-coaching'); ?></a>
						<a href="<?php echo esc_url( LEARNPREE_COACHING_BUY_PRO ); ?>" target="_blank"><?php esc_html_e('Buy Pro', 'learnpress-coaching'); ?></a>
						<a href="<?php echo esc_url( LEARNPREE_COACHING_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'learnpress-coaching'); ?></a>
					</div>
					<div class="install-plugins">
						<img src="<?php echo esc_url(get_template_directory_uri() . '/inc/dashboard/media/responsive1.png'); ?>" alt="" />
					</div>
				</div>
			</div>
			<h2 class="tg-docs-section intruction-title" id="section-4"><?php esc_html_e( '1). Setup Learnpress Coaching Theme', 'learnpress-coaching' ); ?></h2>
			<div class="row">
				<div class="theme-instruction-block col-md-7">
					<div class="pad-box">
	                    <p><?php esc_html_e( 'LearnPress Coaching is a beautiful and modern WordPress theme. It is a multipurpose theme ideal for corporate, business, health coach, life coaching, education theme, learning management system, tutor, wellness coach, religious and spiritual preacher, motivational speaker websites. A branding website is very important for any mentor or coach. This theme will help you achieve milestones. It is loaded with numerous features and options. It has a lot of header layout options. With a responsive and minimal design your website will look awesome on any device. It has full support for WooCommerce. Drag and drop page builder is available to easily create pages. You can change layout, colours and style, and customize your website as you like. It comes with RTL support and can be translated into any language you want. Also, it comes with demo importer which can install demo data in just one click. It takes care of your websites SEO and makes it rank soon on major search engines like Google. The powerful Live Customizer lets you design your blog website. It has 800+ Google Fonts to choose from. Custom styled Trending Posts widget makes your visitors spend more time on your site. Built-in beautifully styled related posts module is also available.', 'learnpress-coaching' ); ?><p><br>
						<ol>
							<li><?php esc_html_e( 'Start','learnpress-coaching'); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customizing','learnpress-coaching'); ?></a> <?php esc_html_e( 'your website.','learnpress-coaching'); ?> </li>
							<li><?php esc_html_e( 'Learnpress Coaching','learnpress-coaching'); ?> <a target="_blank" href="<?php echo esc_url( LEARNPREE_COACHING_FREE_DOC ); ?>"><?php esc_html_e( 'Documentation','learnpress-coaching'); ?></a> </li>
						</ol>
                    </div>
              	</div>
				<div class="col-md-5">
					<div class="pad-box">
              			<img class="logo" src="<?php echo esc_url(get_template_directory_uri() . '/inc/dashboard/media/screenshot.png'); ?>"/>
              		 </div> 
              	</div>
            </div>
			<div class="col-md-12 text-block">
					<h2 class="dashboard-install-title"><?php esc_html_e( '2.) Premium Theme Information.','learnpress-coaching'); ?></h2>
					<div class="row">
						<div class="col-md-7">
							<img src="<?php echo esc_url(get_template_directory_uri() . '/inc/dashboard/media/responsive.png'); ?>" alt="">
							<div class="pad-box">
								<h3><?php esc_html_e( 'Pro Theme Description','learnpress-coaching'); ?></h3>
	                    		<p class="pad-box-p"><?php esc_html_e( 'LearnPress Coaching is a beautiful and modern WordPress theme. It is a multipurpose theme ideal for education learning management system, tutor, religious and spiritual preacher, online courses, e-learning, coaching, workshops, webinars, mentorship, corporate training, skill development, instructor-led, certification, knowledge base, professional development, academic coaching and digital workshops. A branding website is very important for any mentor or coach. This theme will help you achieve milestones. It is loaded with numerous features and options. It has a lot of header layout options. With a responsive and minimal design your website will look awesome on any device. It has full support for WooCommerce. Drag and drop page builder is available to easily create pages. You can change layout, colours and style, and customize your website as you like. It comes with RTL support and can be translated into any language you want. Also, it comes with demo importer which can install demo data in just one click. It takes care of your website’s SEO and makes it rank soon on major search engines like Google. The powerful Live Customizer lets you design your blog website. It has 800+ Google Fonts to choose from. Custom styled Trending Posts widget makes your visitors spend more time on your site. Built-in beautifully styled related posts module is also available.', 'learnpress-coaching' ); ?><p>
	                    	</div>
						</div>
						<div class="col-md-5 install-plugin-right">
							<div class="pad-box">								
								<h3><?php esc_html_e( 'Pro Theme Features','learnpress-coaching'); ?></h3>
								<div class="dashboard-install-benefit">
									<ul>
										<li><?php esc_html_e( 'Car listing Shortcode with category','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Car listing Shortcode','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Multiple image feature for each property with slider.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Brand Listing Section','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Car Brand(categories) Option','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Car Tags(categories) Option','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Testimonial listing.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Testimonial shortcode.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Social icons widget.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Latest post with the image widget.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Live customize editor for the About US section.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Font Awesome integrated.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Advanced Color options and color pallets.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( '100+ Font Family Options.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Enable-Disable options on All sections.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Well sanitized as per WordPress standards.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Allow to set site title, tagline, logo.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Sticky post & Comment threads.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Left and Right Sidebar.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Customizable Home Page.','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Footer Widgets & Editor style','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Gallery & Banner functionality','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Multiple inner page templates','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Full-width Template','learnpress-coaching'); ?></li>
										<li><?php esc_html_e( 'Custom Menu, Colors Editor','learnpress-coaching'); ?></li>
									</ul>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
		<div class="dashboard__blocks">
			<div class="row">
				<div class="col-md-3">
					<h3><?php esc_html_e( 'Get Support','learnpress-coaching'); ?></h3>
					<ol>
						<li><a target="_blank" href="<?php echo esc_url( LEARNPREE_COACHING_FREE_SUPPORT ); ?>"><?php esc_html_e( 'Free Theme Support','learnpress-coaching'); ?></a></li>
						<li><a target="_blank" href="<?php echo esc_url( LEARNPREE_COACHING_PRO_SUPPORT ); ?>"><?php esc_html_e( 'Premium Theme Support','learnpress-coaching'); ?></a></li>
					</ol>
				</div>

				<div class="col-md-3">
					<h3><?php esc_html_e( 'Getting Started','learnpress-coaching'); ?></h3>
					<ol>
						<li><?php esc_html_e( 'Start','learnpress-coaching'); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customizing','learnpress-coaching'); ?></a> <?php esc_html_e( 'your website.','learnpress-coaching'); ?> </li>
					</ol>
				</div>
				<div class="col-md-3">
					<h3><?php esc_html_e( 'Help Docs','learnpress-coaching'); ?></h3>
					<ol>
						<li><a target="_blank" href="<?php echo esc_url( LEARNPREE_COACHING_FREE_DOC ); ?>"><?php esc_html_e( 'Free Theme Documentation','learnpress-coaching'); ?></a></li>
						<li><a target="_blank" href="<?php echo esc_url( LEARNPREE_COACHING_PRO_DOC ); ?>"><?php esc_html_e( 'Premium Theme Documentation','learnpress-coaching'); ?></a></li>
					</ol>
				</div>
				<div class="col-md-3">
					<h3><?php esc_html_e( 'Buy Premium','learnpress-coaching'); ?></h3>
					<ol>
						<a href="<?php echo esc_url( LEARNPREE_COACHING_BUY_PRO ); ?>" target="_blank"><?php esc_html_e('Buy Pro', 'learnpress-coaching'); ?></a>
					</ol>
				</div>
			</div>
		</div>
	</div>

<?php }?>