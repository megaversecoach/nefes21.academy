<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>" alt="">
<h1 class="hello-academy-text-center"><?php the_title(); ?></h1>
<?php get_template_part( 'template-parts/blog/blog', 'meta' ); ?>
<div class="hello-ecademy-signle-blog-content">

<?php
if ( true === HelloAcademy\get_customizer_settings( 'enable_post_toc', true ) ) :
	get_template_part( 'template-parts/table-of-content/toc', 'content' );
	else :
		the_content();
	endif;
	?>
</div>
