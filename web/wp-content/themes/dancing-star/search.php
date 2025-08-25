<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Dancing Star
 */

get_header(); ?>

<div class="container">
     <div id="tabnavigation">
        <div class="PageLS_70">          
				<?php if ( have_posts() ) : ?>
                    <header>
                        <h1 class="entry-title"><?php /* translators: %s: search term */ 
						printf( esc_html__( 'Search Results for: %s', 'dancing-star' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                    </header>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'content', 'search' ); ?>
                    <?php endwhile; ?>
                    <?php the_posts_pagination(); ?>
                <?php else : ?>
                    <?php get_template_part( 'no-results' ); ?>
                <?php endif; ?>                 

        </div> <!-- .PageLS_70-->        
       <?php get_sidebar();?>       
        <div class="clear"></div>
    </div><!-- site-aligner -->
</div><!-- container -->

<?php get_footer(); ?>