<?php
/**
 * The install plugins page view.
 *
 * @package academyst
 */

namespace AcademyStarter\Library;

$plugin_installer = new PluginInstaller();
$theme_plugins    = $plugin_installer->get_theme_plugins();
$theme            = wp_get_theme();
?>

<div class="academyst academyst--install-plugins">

	<?php echo wp_kses_post( ViewHelpers::plugin_header_output() ); ?>

	<div class="academyst__content-container">

		<div class="academyst__admin-notices js-academyst-admin-notices-container"></div>

		<div class="academyst__content-container-content">
			<div class="academyst__content-container-content--main">
				<?php if ( isset( $_GET['import'] ) ) : ?>
					<div class="academyst-install-plugins-content js-academyst-install-plugins-content">
						<div class="academyst-install-plugins-content-header">
							<h2><?php esc_html_e( 'Before We Import Your Demo', 'academy-starter-templates' ); ?></h2>
							<p>
								<?php esc_html_e( 'To ensure the best experience, installing the following plugins is strongly recommended, and in some cases required.', 'academy-starter-templates' ); ?>
							</p>

							<?php if ( ! empty( $this->import_files[ $_GET['import'] ]['import_notice'] ) ) : ?>
								<div class="notice  notice-info">
									<p><?php echo wp_kses_post( $this->import_files[ $_GET['import'] ]['import_notice'] ); ?></p>
								</div>
							<?php endif; ?>
						</div>
						<div class="academyst-install-plugins-content-content">
							<?php if ( empty( $theme_plugins ) ) : ?>
								<div class="academyst-content-notice">
									<p>
										<?php esc_html_e( 'All required/recommended plugins are already installed. You can import your demo content.', 'academy-starter-templates' ); ?>
									</p>
								</div>
							<?php else : ?>
								<div>
								<?php foreach ( $theme_plugins as $plugin ) : ?>
									<?php $is_plugin_active = $plugin_installer->is_plugin_active( $plugin['slug'] ); ?>
									<label class="plugin-item plugin-item-<?php echo esc_attr( $plugin['slug'] ); ?><?php echo $is_plugin_active ? ' plugin-item--active' : ''; ?><?php echo ! empty( $plugin['required'] ) ? ' plugin-item--required' : ''; ?>" for="academyst-<?php echo esc_attr( $plugin['slug'] ); ?>-plugin">
										<div class="plugin-item-content">
											<div class="plugin-item-content-title">
												<h3><?php echo esc_html( $plugin['name'] ); ?></h3>
												<?php if ( in_array( $plugin['slug'], [ 'wpforms-lite', 'all-in-one-seo-pack', 'google-analytics-for-wordpress' ], true ) ) : ?>
													<span>
														<img src="<?php echo esc_url( ACADEMY_STARTER_ASSETS_URI . 'images/icons/star.svg' ); ?>" alt="<?php esc_attr_e( 'Star icon', 'academy-starter-templates' ); ?>">
													</span>
												<?php endif; ?>
											</div>
											<?php if ( ! empty( $plugin['description'] ) ) : ?>
												<p>
													<?php echo wp_kses_post( $plugin['description'] ); ?>
												</p>
											<?php endif; ?>
											<div class="plugin-item-error js-academyst-plugin-item-error"></div>
											<div class="plugin-item-info js-academyst-plugin-item-info"></div>
										</div>
										<span class="plugin-item-checkbox">
											<input type="checkbox" id="academyst-<?php echo esc_attr( $plugin['slug'] ); ?>-plugin" name="<?php echo esc_attr( $plugin['slug'] ); ?>" <?php checked( ! empty( $plugin['preselected'] ) || ! empty( $plugin['required'] ) || $is_plugin_active ); ?><?php disabled( $is_plugin_active ); ?>>
											<span class="checkbox">
												<img src="<?php echo esc_url( ACADEMY_STARTER_ASSETS_URI . 'images/icons/check-solid-white.svg' ); ?>" class="academyst-check-icon" alt="<?php esc_attr_e( 'Checkmark icon', 'academy-starter-templates' ); ?>">
												<?php if ( ! empty( $plugin['required'] ) ) : ?>
													<img src="<?php echo esc_url( ACADEMY_STARTER_ASSETS_URI . 'images/icons/lock.svg' ); ?>" class="academyst-lock-icon" alt="<?php esc_attr_e( 'Lock icon', 'academy-starter-templates' ); ?>">
												<?php endif; ?>
												<img src="<?php echo esc_url( ACADEMY_STARTER_ASSETS_URI . 'images/loader.svg' ); ?>" class="academyst-loading academyst-loading-md" alt="<?php esc_attr_e( 'Loading...', 'academy-starter-templates' ); ?>">
											</span>
										</span>
									</label>
								<?php endforeach; ?>
								</div>
								<div class="academyst-content-notice academyst-content-notice--warning">
									<p>
										<?php
											printf(
												esc_html__(
													'The plugins with %1$s are recommended by Academy Starter Templates plugin to help you grow your website. They are not required for the %2$s theme to work.',
													'academy-starter-templates'
												),
												'<span class="academyst-recommended-star"><img src="' . esc_url( ACADEMY_STARTER_ASSETS_URI . 'images/icons/star.svg' ) . '" alt="' . esc_attr__( 'Star icon', 'academy-starter-templates' ) . '"></span>',
												$theme->name
											);
										?>
									</p>
								</div>
							<?php endif; ?>
						</div>
						<div class="academyst-install-plugins-content-footer">
							<a href="<?php echo esc_url( $this->get_plugin_settings_url() ); ?>" class="button"><img src="<?php echo esc_url( ACADEMY_STARTER_ASSETS_URI . 'images/icons/long-arrow-alt-left-blue.svg' ); ?>" alt="<?php esc_attr_e( 'Back icon', 'academy-starter-templates' ); ?>"><span><?php esc_html_e( 'Go Back', 'academy-starter-templates' ); ?></span></a>
							<a href="#" class="button button-primary js-academyst-install-plugins-before-import"><?php esc_html_e( 'Continue & Import', 'academy-starter-templates' ); ?></a>
						</div>
					</div>
				<?php endif; ?>

				<div class="academyst-importing js-academyst-importing">
					<div class="academyst-importing-header">
						<h2><?php esc_html_e( 'Importing Content', 'academy-starter-templates' ); ?></h2>
						<p><?php esc_html_e( 'Please sit tight while we import your content. Do not refresh the page or hit the back button.', 'academy-starter-templates' ); ?></p>
					</div>
					<div class="academyst-importing-content">
						<img class="academyst-importing-content-importing" src="<?php echo esc_url( ACADEMY_STARTER_ASSETS_URI . 'images/importing.svg' ); ?>" alt="<?php esc_attr_e( 'Importing animation', 'academy-starter-templates' ); ?>">
					</div>
				</div>

				<div class="academyst-imported js-academyst-imported">
					<div class="academyst-imported-header">
						<h2 class="js-academyst-ajax-response-title"><?php esc_html_e( 'Import Complete!', 'academy-starter-templates' ); ?></h2>
						<div class="js-academyst-ajax-response-subtitle">
							<p>
								<?php esc_html_e( 'Congrats, your demo was imported successfully. You can now begin editing your site.', 'academy-starter-templates' ); ?>
							</p>
						</div>
					</div>
					<div class="academyst-imported-content">
						<div class="academyst__response  js-academyst-ajax-response"></div>
					</div>
					<div class="academyst-imported-footer">
						<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary button-hero"><?php esc_html_e( 'Theme Settings', 'academy-starter-templates' ); ?></a>
						<a href="<?php echo esc_url( get_home_url() ); ?>" class="button button-primary button-hero"><?php esc_html_e( 'Visit Site', 'academy-starter-templates' ); ?></a>
					</div>
				</div>
			</div>
			<div class="academyst__content-container-content--side">
				<?php
					$selected = isset( $_GET['import'] ) ? (int) $_GET['import'] : null;
					echo wp_kses_post( ViewHelpers::small_theme_card( $selected ) );
				?>
			</div>
		</div>

	</div>
</div>
