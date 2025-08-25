<?php
/**
 * The template for displaying the footer.
 * @package LearnPress Coaching
 */
?>
<?php if( get_theme_mod( 'learnpress_coaching_hide_show_scroll',true) != '' || get_theme_mod( 'learnpress_coaching_display_scrolltop',true) != '') { ?>
    <?php $learnpress_coaching_theme_lay = get_theme_mod( 'learnpress_coaching_footer_options','Right');
        if($learnpress_coaching_theme_lay == 'Left align'){ ?>
            <a href="#" id="scrollbutton" class="left"><i class="<?php echo esc_attr(get_theme_mod('learnpress_coaching_back_to_top_icon','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Back to Top', 'learnpress-coaching' ); ?></span></a>
        <?php }else if($learnpress_coaching_theme_lay == 'Center align'){ ?>
            <a href="#" id="scrollbutton" class="center"><i class="<?php echo esc_attr(get_theme_mod('learnpress_coaching_back_to_top_icon','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Back to Top', 'learnpress-coaching' ); ?></span></a>
        <?php }else{ ?>
            <a href="#" id="scrollbutton"><i class="<?php echo esc_attr(get_theme_mod('learnpress_coaching_back_to_top_icon','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Back to Top', 'learnpress-coaching' ); ?></span></a>
    <?php }?>
<?php }?>
<footer role="contentinfo">
    <?php if (get_theme_mod('learnpress_coaching_show_hide_footer', true)){ ?>
    <?php //Set widget areas classes based on user choice
        $learnpress_coaching_widget_areas = get_theme_mod('learnpress_coaching_footer_widget_areas', '4');
        if ($learnpress_coaching_widget_areas == '3') {
            $cols = 'col-md-4';
        } elseif ($learnpress_coaching_widget_areas == '4') {
            $cols = 'col-md-3';
        } elseif ($learnpress_coaching_widget_areas == '2') {
            $cols = 'col-md-6';
        } else {
            $cols = 'col-md-12';
        }
    ?>
    <aside id="sidebar-footer" class="footer-wp p-4" role="complementary">
        <div class="container">
        <div class="row">
            <div class="<?php echo !is_active_sidebar('footer-1') ? 'footer_hide' : esc_attr($learnpress_coaching_colmd); ?> col-lg-3 col-xs-12 footer-block">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <?php dynamic_sidebar('footer-1'); ?>
                <?php else : ?>
                    <aside id="search" class="widget py-3" role="complementary" aria-label="firstsidebar">
                        <h3 class="widget-title"><?php esc_html_e( 'Search', 'learnpress-coaching' ); ?></h3>
                        <?php get_search_form(); ?>
                    </aside>
                <?php endif; ?>
            </div>

            <div class="<?php echo !is_active_sidebar('footer-2') ? 'footer_hide' : esc_attr($learnpress_coaching_colmd); ?> col-lg-3 col-xs-12 footer-block pe-2">
                <?php if (is_active_sidebar('footer-2')) : ?>
                    <?php dynamic_sidebar('footer-2'); ?>
                <?php else : ?>
                    <aside id="archives" class="widget py-3" role="complementary" >
                        <h3 class="widget-title"><?php esc_html_e( 'Archives', 'learnpress-coaching' ); ?></h3>
                        <ul>
                            <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
                        </ul>
                    </aside>
                <?php endif; ?>
            </div>  

            <div class="<?php echo !is_active_sidebar('footer-3') ? 'footer_hide' : esc_attr($learnpress_coaching_colmd); ?> col-lg-3 col-xs-12 footer-block">
                <?php if (is_active_sidebar('footer-3')) : ?>
                    <?php dynamic_sidebar('footer-3'); ?>
                <?php else : ?>
                    <aside id="meta" class="widget py-3" role="complementary" >
                        <h3 class="widget-title"><?php esc_html_e( 'Meta', 'learnpress-coaching' ); ?></h3>
                        <ul>
                            <?php wp_register(); ?>
                            <li><?php wp_loginout(); ?></li>
                            <?php wp_meta(); ?>
                        </ul>
                    </aside>
                <?php endif; ?>
            </div>

            <div class="<?php echo !is_active_sidebar('footer-4') ? 'footer_hide' : esc_attr($learnpress_coaching_colmd); ?> col-lg-3 col-xs-12 footer-block">
                <?php if (is_active_sidebar('footer-4')) : ?>
                    <?php dynamic_sidebar('footer-4'); ?>
                <?php else : ?>
                    <aside id="categories" class="widget py-3" role="complementary"> 
                        <h3 class="widget-title"><?php esc_html_e( 'Categories', 'learnpress-coaching' ); ?></h3>          
                        <ul>
                            <?php wp_list_categories('title_li=');  ?>
                        </ul>
                    </aside>
                <?php endif; ?>
            </div>
        </div>
        </div>
    </aside>
    <?php }?>
    <?php if (get_theme_mod('learnpress_coaching_show_hide_copyright', true)) {?>
	<div class="copyright-wrapper py-3 px-0">
        <div class="container">
            <p><?php learnpress_coaching_credit(); ?> <?php echo esc_html(get_theme_mod('learnpress_coaching_footer_copy',__('By Buywptemplate','learnpress-coaching'))); ?></p>
            <?php if (get_theme_mod('learnpress_coaching_show_footer_icons', true)){ ?> 
            <div class="d-flex justify-content-center align-items-center gap-3 mt-2">
                <?php if ( get_theme_mod('learnpress_coaching_footer_facebook_link','') != "" ) {?>
                    <a target="_blank" href="<?php echo esc_attr( get_theme_mod('learnpress_coaching_footer_facebook_link','' )); ?>"><i class="<?php echo esc_attr(get_theme_mod('learnpress_coaching_footer_facebook_icon','fab fa-facebook-f')); ?>"></i><span class="screen-reader-text"><?php echo esc_html('Facebook', 'learnpress-coaching'); ?></span></a>
                <?php }?>
                <?php if ( get_theme_mod('learnpress_coaching_footer_twitter_link','') != "" ) {?>
                    <a target="_blank" href="<?php echo esc_attr( get_theme_mod('learnpress_coaching_footer_twitter_link','' )); ?>"><i class="<?php echo esc_attr(get_theme_mod('learnpress_coaching_footer_twitter_icon','fab fa-twitter')); ?>"></i><span class="screen-reader-text"><?php echo esc_html('Twitter', 'learnpress-coaching'); ?></span></a>
                <?php }?>
                <?php if ( get_theme_mod('learnpress_coaching_footer_linkdin_link','') != "" ) {?>
                    <a target="_blank" href="<?php echo esc_attr( get_theme_mod('learnpress_coaching_footer_linkdin_link','' )); ?>"><i class="<?php echo esc_attr(get_theme_mod('learnpress_coaching_footer_linkdin_icon','fab fa-linkedin-in')); ?>"></i><span class="screen-reader-text"><?php echo esc_html('Linkdin', 'learnpress-coaching'); ?></span></a>
                <?php }?>   
                <?php if ( get_theme_mod('learnpress_coaching_footer_instagram_link','') != "" ) {?>
                    <a target="_blank" href="<?php echo esc_attr( get_theme_mod('learnpress_coaching_footer_instagram_link','' )); ?>"><i class="<?php echo esc_attr(get_theme_mod('learnpress_coaching_footer_instagram_icon','fab fa-instagram')); ?>"></i><span class="screen-reader-text"><?php echo esc_html('Instagram', 'learnpress-coaching'); ?></span></a>
                <?php }?>   
                <?php if ( get_theme_mod('learnpress_coaching_footer_pintrest_link','') != "" ) {?>
                    <a target="_blank" href="<?php echo esc_attr( get_theme_mod('learnpress_coaching_footer_pintrest_link','' )); ?>"><i class="<?php echo esc_attr(get_theme_mod('learnpress_coaching_footer_pintrest_icon','fab fa-pinterest-p')); ?>"></i><span class="screen-reader-text"><?php echo esc_html('Pintrest', 'learnpress-coaching'); ?></span></a>
                <?php }?>                
            </div> 
            <?php }?>   
        </div>
        <div class="clear"></div>
    </div>
    <?php }?>
</footer>
    
<?php wp_footer(); ?>

</body>
</html>