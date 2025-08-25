<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_post_thumbnail(); ?>
		<?php if ( apply_filters( 'hello_academy_theme_page_title', true ) ) : ?>
			<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
		<?php endif; ?>
	</header>
	<div class="post-meta">
		<span class="user-info">
			<i class="fa fa-user-o" aria-hidden="true"></i>
			<?php the_author(); ?>
		</span>
		<span class="post-date">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/clock.svg" alt="">
			<?php echo get_the_date( get_option( 'date_format' ) ); ?>
		</span>
	</div>
	<div class="entry-content">
	<?php
	if ( true === HelloAcademy\get_customizer_settings( 'enable_post_toc', false ) ) :
		get_template_part( 'template-parts/table-of-content/toc', 'links' );
		get_template_part( 'template-parts/table-of-content/toc', 'content' );
			else :
				the_content();
			endif;
			wp_link_pages(
				array(
					'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'hello-academy' ),
					'after'       => '</div>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				)
			);
			?>
	</div>
</div>
