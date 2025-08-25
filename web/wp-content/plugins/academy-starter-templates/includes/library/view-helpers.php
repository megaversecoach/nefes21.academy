<?php
/**
 * Static functions used in the OCDI plugin views.
 *
 * @credit https://github.com/awesomemotive/one-click-demo-import
 * @package academyst
 */

namespace AcademyStarter\Library;

class ViewHelpers {
	/**
	 * The HTML output of the plugin page header.
	 *
	 * @return string HTML output.
	 */
	public static function plugin_header_output() {
		ob_start(); ?>
		<div class="academyst__title-container">
			<h1 class="academyst__title-container-title"><?php esc_html_e( 'Academy Starter Templates', 'academy-starter-templates' ); ?></h1>
			<a href="https://academylms.net/docs/how-to-use-academy-starter-template/" target="_blank" rel="noopener noreferrer">
				<img class="academyst__title-container-icon" src="<?php echo esc_url( ACADEMY_STARTER_ASSETS_URI . 'images/icons/question-circle.svg' ); ?>" alt="<?php esc_attr_e( 'Questionmark icon', 'academy-starter-templates' ); ?>">
			</a>
		</div>
		<?php
		$plugin_title = ob_get_clean();

		// Display the plugin title (can be replaced with custom title text through the filter below).
		return Helpers::apply_filters( 'academyst/plugin_page_title', $plugin_title );
	}

	/**
	 * The HTML output of a small card with theme screenshot and title.
	 *
	 * @return string HTML output.
	 */
	public static function small_theme_card( $selected = null ) {
		$theme      = wp_get_theme();
		$screenshot = $theme->get_screenshot();
		$name       = $theme->name;

		if ( isset( $selected ) ) {
			$academyst          = OneClickDemoImport::get_instance();
			$selected_data = $academyst->import_files[ $selected ];
			$name          = ! empty( $selected_data['import_file_name'] ) ? $selected_data['import_file_name'] : $name;
			$screenshot    = ! empty( $selected_data['import_preview_image_url'] ) ? $selected_data['import_preview_image_url'] : $screenshot;
		}

		ob_start(); ?>
		<div class="academyst__card academyst__card--theme">
			<div class="academyst__card-content">
				<?php if ( $screenshot ) : ?>
					<div class="screenshot"><img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'academy-starter-templates' ); ?>" /></div>
				<?php else : ?>
					<div class="screenshot blank"></div>
				<?php endif; ?>
			</div>
			<div class="academyst__card-footer">
				<h3><?php echo esc_html( $name ); ?></h3>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
