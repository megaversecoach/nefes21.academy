<?php
/**
 * Template part for displaying home page content
 *
 * @package Online Courses Hub
 * @subpackage online_courses_hub
 */
?>

<?php $online_courses_hub_static_image = get_stylesheet_directory_uri() . '/assets/images/sliderimage.png'; ?>
<?php if( get_theme_mod( 'online_courses_hub_popular_courses_enable') != '') { ?>
<section id="popular_topic" class="py-5">
  <div class="container">
    <?php if( get_theme_mod('online_courses_hub_popular_courses_text') != ''){ ?>
      <h2 class="text-center mb-5"><?php echo esc_html(get_theme_mod('online_courses_hub_popular_courses_text','')); ?><hr></h2>
    <?php }?>
    <div class="row">
      <?php
        $online_courses_hub_post_category = get_theme_mod('online_courses_hub_popular_courses_category');
        if($online_courses_hub_post_category){
          $online_courses_hub_page_query = new WP_Query(array( 'category_name' => esc_html( $online_courses_hub_post_category ,'online-courses-hub')));?>
          <?php while( $online_courses_hub_page_query->have_posts() ) : $online_courses_hub_page_query->the_post(); ?>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="cat-inner-box mb-3">
                <?php if(has_post_thumbnail()) { ?><?php the_post_thumbnail(); ?><?php }else {echo ('<img src="'.$online_courses_hub_static_image .'">'); } ?>
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              </div>
            </div>
          <?php endwhile;
          wp_reset_postdata();
        }
      ?>
    </div>
  </div>
</section>
 <?php }?>
