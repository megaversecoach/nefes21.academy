<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Dancing Star
 */

get_header(); ?>

<div class="container">
    <div id="tabnavigation">
        <div class="PageLS_70">
           <div class="PostStyle_01">
            <div class="blogin-bx"> 
             <header class="page-header">
                <h1 class="entry-title"><?php esc_html_e( '404 Not Found', 'dancing-star' ); ?></h1>                
            </header><!-- .page-header -->
            <div class="page-content">
                <p><?php esc_html_e( 'Looks like you have taken a wrong turn....Dont worry... it happens to the best of us.', 'dancing-star' ); ?></p>  
            </div><!-- .page-content -->
           </div><!--.blogin-bx-->
          </div><!--.PostStyle_01-->      
       </div><!-- PageLS_70-->   
        <?php get_sidebar();?>       
        <div class="clear"></div>
    </div>
</div>
<?php get_footer(); ?>