<?php
/**
 * The install plugins page view.
 *
 * @package academyst
 */

namespace AcademyStarter\Library;

$plugin_installer = new PluginInstaller();
?>

<div class="academyst academyst--install-plugins">

	<?php echo wp_kses_post( ViewHelpers::plugin_header_output() ); ?>

	<div class="academyst__content-container">

		<div class="academyst__admin-notices js-academyst-admin-notices-container"></div>

		<div class="academyst__content-container-content">
			<div class="academyst__content-container-content--main">
				<div class="academyst-install-plugins-content">
					<div class="academyst-install-plugins-content-header">
						<h2><?php esc_html_e( 'Install Recommended Plugins', 'academy-starter-templates' ); ?></h2>
						<p>
							<?php esc_html_e( 'Want to use the best plugins for the job? Here is the list of awesome plugins that will help you achieve your goals.', 'academy-starter-templates' ); ?>
						</p>
					</div>
					<div class="academyst-install-plugins-content-content">
						<?php foreach ( $plugin_installer->get_partner_plugins() as $plugin ) : ?>
							<?php $is_plugin_active = $plugin_installer->is_plugin_active( $plugin['slug'] ); ?>
							<label class="plugin-item plugin-item-<?php echo esc_attr( $plugin['slug'] ); ?><?php echo $is_plugin_active ? ' plugin-item--active' : ''; ?>" for="academyst-<?php echo esc_attr( $plugin['slug'] ); ?>-plugin">
								<div class="plugin-item-content">
									<div class="plugin-item-content-title">
										<h3><?php echo esc_html( $plugin['name'] ); ?></h3>
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
									<input type="checkbox" id="academyst-<?php echo esc_attr( $plugin['slug'] ); ?>-plugin" name="<?php echo esc_attr( $plugin['slug'] ); ?>" <?php checked( ! empty( $plugin['preselected'] ) || $is_plugin_active ); ?><?php disabled( $is_plugin_active ); ?>>
									<span class="checkbox">
										<img src="<?php echo esc_url( ACADEMY_STARTER_ASSETS_URI . 'images/icons/check-solid-white.svg' ); ?>" class="academyst-check-icon" alt="<?php esc_attr_e( 'Checkmark icon', 'academy-starter-templates' ); ?>">
										<img src="<?php echo esc_url( ACADEMY_STARTER_ASSETS_URI . 'images/loader.svg' ); ?>" class="academyst-loading academyst-loading-md" alt="<?php esc_attr_e( 'Loading...', 'academy-starter-templates' ); ?>">
									</span>
								</span>
							</label>
						<?php endforeach; ?>
					</div>
					<div class="academyst-install-plugins-content-footer">
						<a href="<?php echo esc_url( $this->get_plugin_settings_url() ); ?>" class="button"><img src="<?php echo esc_url( ACADEMY_STARTER_ASSETS_URI . 'images/icons/long-arrow-alt-left-blue.svg' ); ?>" alt="<?php esc_attr_e( 'Back icon', 'academy-starter-templates' ); ?>"><span><?php esc_html_e( 'Go Back', 'academy-starter-templates' ); ?></span></a>
						<a href="#" class="button button-primary js-academyst-install-plugins"><?php esc_html_e( 'Install & Activate', 'academy-starter-templates' ); ?></a>
					</div>
				</div>
			</div>
			<div class="academyst__content-container-content--side">
				<?php echo wp_kses_post( ViewHelpers::small_theme_card() ); ?>
			</div>
		</div>

	</div>
</div>
