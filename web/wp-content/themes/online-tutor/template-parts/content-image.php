<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Online Tutor
 */

$online_tutor_post_page_title =  get_theme_mod( 'online_tutor_post_page_title', 1 );
$online_tutor_post_page_meta =  get_theme_mod( 'online_tutor_post_page_meta', 1 );
$online_tutor_post_page_btn = get_theme_mod( 'online_tutor_post_page_btn', 1 );
$online_tutor_post_page_content =  get_theme_mod( 'online_tutor_post_page_content', 1 );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article-box'); ?>>
    <div class="row">
        <?php if ( has_post_thumbnail() ) { ?>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <?php online_tutor_post_thumbnail(); ?>
            </div>
        <?php }?>
        <div class="<?php if(has_post_thumbnail()) { ?>col-lg-7 col-md-7<?php } else { ?>col-lg-12 col-md-12 <?php } ?>">
            <div class="entry-summary p-3 m-0">      
                <?php if ($online_tutor_post_page_title == 1 ) {?>
                    <?php the_title('<h3 class="entry-title pb-3"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>');?>
                <?php }?>

                <?php if ($online_tutor_post_page_content == 1 ) {?>
                    <p><?php echo wp_trim_words( get_the_content(), 30 ); ?></p>
                <?php }?>
                <?php if ($online_tutor_post_page_btn == 1 ) {?>
                    <a href="<?php the_permalink(); ?>" class="btn-text"><?php esc_html_e('Read Full','online-tutor'); ?><i class="fas fa-long-arrow-alt-right ml-3"></i></a>
                <?php }?>
            </div>
            <?php if ($online_tutor_post_page_meta == 1 ) {?>
                <div class="meta-info-box">
                    <span class="entry-view"><i class="fas fa-eye me-2"></i> <?php echo esc_html(online_tutor_gt_get_post_view()); ?></span>
                    <span class="entry-time ml-3"><i class="fas fa-clock me-2"></i> <?php echo esc_html( get_the_time() ); ?></span>
                    <span class="ms-3"><i class="fas fa-comments me-2"></i> <?php comments_number( esc_attr('0', 'online-tutor'), esc_attr('0', 'online-tutor'), esc_attr('%', 'online-tutor') ); ?> <?php esc_html_e('Comments','online-tutor'); ?></span>
                </div>
            <?php }?>

        </div>
    </div>
</article>