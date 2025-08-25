<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Dancing Star
 */

get_header(); ?>

<div class="container">
     <div id="tabnavigation">
        <div class="PageLS_70">           
				<?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'content', 'single' ); ?>                  
                    <div class="clear"></div>
                    <?php
                    // If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || '0' != get_comments_number() )
                    	comments_template();
                    ?>
                <?php endwhile; // end of the loop. ?>                  
          </div><!-- .PageLS_70-->       
           <?php get_sidebar();?>
        <div class="clear"></div>
    </div><!-- #tabnavigation -->
</div><!-- container -->	
<?php get_footer(); ?>