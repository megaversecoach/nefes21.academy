<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="blog-post-meta">
	<?php if ( true === HelloAcademy\get_customizer_settings( 'enable_post_author', true ) ) : ?>
		<div class="post-author">
			<i class="fa fa-user-o" aria-hidden="true"></i>
			<a class="author-url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
		</div>
	<?php endif;
	if ( true === HelloAcademy\get_customizer_settings( 'enable_post_date', true ) ) : ?>
		<div class="post-date">
			<i class="fa fa-clock-o" aria-hidden="true"></i>
			<?php echo get_the_date( 'F j, Y' ); ?>
		</div>
	<?php endif;
	if ( true === HelloAcademy\get_customizer_settings( 'enable_post_cat', true ) ) : ?>
		<div class="post-category">
			<i class="fa fa-tags" aria-hidden="true"></i>
			<?php echo $categories_list; ?>
		</div>
	<?php endif; ?>
</div>
