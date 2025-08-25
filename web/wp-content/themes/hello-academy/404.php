<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package HelloAcademy
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="hello-academy-content" role="main" id="content">
	<div class="academy-container">
		<div class="academy-row">
			<div class="academy-col-lg-12">
				<div class="academy-404-content-wrapper">
					<?php if ( apply_filters( 'helloacademy/templates/page_title', true ) ) : ?>
					<header class="page-header">
						<h1 class="entry-title">
							<span class="academy-404-big-text">404</span>
							<?php esc_html_e( 'The page can&rsquo;t be found.', 'hello-academy' ); ?>
						</h1>
					</header>
					<?php endif; ?>
					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'hello-academy' ); ?>
						</p>
					</div>
					<div class="search-form-wrapper">
						<?php get_search_form(); ?>
					</div>

				</div>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
