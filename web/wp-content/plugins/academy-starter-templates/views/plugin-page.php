<?php
/**
 * The plugin page view - the "settings" page of the plugin.
 *
 * @package academyst
 */

namespace AcademyStarter\Library;

$predefined_themes = $this->import_files;
/**
 * Hook for adding the custom plugin page header
 */
Helpers::do_action( 'academyst/plugin_page_header' );
?>

<div class="academyst">

	<?php echo wp_kses_post( ViewHelpers::plugin_header_output() ); ?>

	<div class="academyst__content-container">

		<?php
		// Display warrning if PHP safe mode is enabled, since we wont be able to change the max_execution_time.
		if ( ini_get( 'safe_mode' ) ) {
			printf( /* translators: %1$s - the opening div and paragraph HTML tags, %2$s and %3$s - strong HTML tags, %4$s - the closing div and paragraph HTML tags. */
				esc_html__( '%1$sWarning: your server is using %2$sPHP safe mode%3$s. This means that you might experience server timeout errors.%4$s', 'academy-starter-templates' ),
				'<div class="notice  notice-warning  is-dismissible"><p>',
				'<strong>',
				'</strong>',
				'</p></div>'
			);
		}
		?>

		<div class="academyst__admin-notices js-academyst-admin-notices-container"></div>

		<?php if ( !empty( $predefined_themes ) ) : ?>

			<!-- OCDI grid layout -->
			<div class="academyst__gl  js-academyst-gl">
			<?php
				// Prepare navigation data.
				$categories = Helpers::get_all_demo_import_categories( $predefined_themes );
			?>
				<?php if ( ! empty( $categories ) ) : ?>
					<div class="academyst__gl-header  js-academyst-gl-header">
						<nav class="academyst__gl-navigation">
							<ul>
								<li class="active"><a href="#all" class="academyst__gl-navigation-link  js-academyst-nav-link"><span><?php esc_html_e( 'All Demos', 'academy-starter-templates' ); ?></span></a></li>
								<?php foreach ( $categories as $key => $name ) : ?>
									<li>
										<a href="#<?php echo esc_attr( $key ); ?>" class="academyst__gl-navigation-link  js-academyst-nav-link">
											<span>
												<?php echo esc_html( $name ); ?>
											</span>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</nav>
						<div clas="academyst__gl-search">
							<input type="search" class="academyst__gl-search-input  js-academyst-gl-search" name="academyst-gl-search" value="" placeholder="<?php esc_html_e( 'Search Demos...', 'academy-starter-templates' ); ?>">
						</div>
					</div>
				<?php else : ?>
					<hr>
				<?php endif; ?>
				<div class="academyst__gl-item-container js-academyst-gl-item-container">
					<?php foreach ( $predefined_themes as $index => $import_file ) : ?>
						<?php
							// Prepare import item display data.
							$img_src = isset( $import_file['import_preview_image_url'] ) ? $import_file['import_preview_image_url'] : '';
							// Default to the theme screenshot, if a custom preview image is not defined.
							if ( empty( $img_src ) ) {
								$theme = wp_get_theme();
								$img_src = $theme->get_screenshot();
							}

						?>
						<div class="academyst__gl-item js-academyst-gl-item" data-categories="<?php echo esc_attr( Helpers::get_demo_import_item_categories( $import_file ) ); ?>" data-name="<?php echo esc_attr( strtolower( $import_file['import_file_name'] ) ); ?>">
							<div class="academyst__gl-item-image-container">
								<?php if ( ! empty( $img_src ) ) : ?>
									<img class="academyst__gl-item-image" src="<?php echo esc_url( $img_src ) ?>">
								<?php else : ?>
									<div class="academyst__gl-item-image  academyst__gl-item-image--no-image"><?php esc_html_e( 'No preview image.', 'academy-starter-templates' ); ?></div>
								<?php endif; ?>
							</div>
							<div class="academyst__gl-item-footer<?php echo ! empty( $import_file['preview_url'] ) ? '  academyst__gl-item-footer--with-preview' : ''; ?>">
								<h4 class="academyst__gl-item-title" title="<?php echo esc_attr( $import_file['import_file_name'] ); ?>"><?php echo esc_html( $import_file['import_file_name'] ); ?></h4>
								<span class="academyst__gl-item-buttons">
									<?php if ( ! empty( $import_file['preview_url'] ) ) : ?>
										<a class="academyst__gl-item-button  button" href="<?php echo esc_url( $import_file['preview_url'] ); ?>" target="_blank"><?php esc_html_e( 'Preview Demo', 'academy-starter-templates' ); ?></a>
									<?php endif; ?>
									<a class="academyst__gl-item-button academy-import-button button  button-primary" data-demo-index="<?php echo esc_attr( $index ) ?>" href="<?php echo $this->get_plugin_settings_url( [ 'step' => 'import', 'import' => esc_attr( $index ) ] ); ?>"><?php esc_html_e( 'Import Demo', 'academy-starter-templates' ); ?></a>
								</span>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>



<!-- <div class="installation-screen modal-wrapper">
	<div class="modal-content">
		<div class="modal-head">
			<h4><span>Hold on a moment</span>Your site is installing...</h4>
		</div>
		<div class="modal-body">
			<div class="percentage">75%</div>
		</div>
		<div class="plugin-status">
			<div class="plugin-item">
				<div class="title">Tutor LMS</div>
			</div>
			<div class="demo-content">
				<div class="title-notactive">Demo Content</div>
			</div>
		</div>
		<button class="btn btn-primary inactive"><a href="javascript:" target="_self">View Your Site</a></button>
	</div>
</div> -->

<?php
/**
 * Hook for adding the custom admin page footer
 */
Helpers::do_action( 'academyst/plugin_page_footer' );
