<?php
/**
 * Block Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 *
	 * @since Academy Lite 1.0
	 *
	 * @return void
	 */
	function academy_lite_register_block_styles() {
		// Columns: Overlap.
		register_block_style(
			'core/columns',
			array(
				'name'  => 'academy-lite-columns-overlap',
				'label' => esc_html__( 'Overlap', 'academy-lite' ),
			)
		);

		// Cover: Borders.
		register_block_style(
			'core/cover',
			array(
				'name'  => 'academy-lite-border',
				'label' => esc_html__( 'Borders', 'academy-lite' ),
			)
		);

		// Group: Borders.
		register_block_style(
			'core/group',
			array(
				'name'  => 'academy-lite-border',
				'label' => esc_html__( 'Borders', 'academy-lite' ),
			)
		);

		// Image: Borders.
		register_block_style(
			'core/image',
			array(
				'name'  => 'academy-lite-border',
				'label' => esc_html__( 'Borders', 'academy-lite' ),
			)
		);

		// Image: Frame.
		register_block_style(
			'core/image',
			array(
				'name'  => 'academy-lite-image-frame',
				'label' => esc_html__( 'Frame', 'academy-lite' ),
			)
		);

		// Latest Posts: Dividers.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'academy-lite-latest-posts-dividers',
				'label' => esc_html__( 'Dividers', 'academy-lite' ),
			)
		);

		// Latest Posts: Borders.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'academy-lite-latest-posts-borders',
				'label' => esc_html__( 'Borders', 'academy-lite' ),
			)
		);

		// Media & Text: Borders.
		register_block_style(
			'core/media-text',
			array(
				'name'  => 'academy-lite-border',
				'label' => esc_html__( 'Borders', 'academy-lite' ),
			)
		);

		// Separator: Thick.
		register_block_style(
			'core/separator',
			array(
				'name'  => 'academy-lite-separator-thick',
				'label' => esc_html__( 'Thick', 'academy-lite' ),
			)
		);

		// Social icons: Dark gray color.
		register_block_style(
			'core/social-links',
			array(
				'name'  => 'academy-lite-social-icons-color',
				'label' => esc_html__( 'Dark gray', 'academy-lite' ),
			)
		);
	}
	add_action( 'init', 'academy_lite_register_block_styles' );
}
