<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package Dancing Star
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
?>
<a class="skip-link screen-reader-text" href="#tabnavigation">
<?php esc_html_e('Skip to content', 'dancing-star' ); ?>
</a>
<?php
$dancing_star_show_topstrip 	   			= esc_attr( get_theme_mod('dancing_star_show_topstrip', false) ); 
$dancing_star_show_frontslider 	  		= esc_attr( get_theme_mod('dancing_star_show_frontslider', false) );
$dancing_star_show_fourcolumn_options      	= esc_attr( get_theme_mod('dancing_star_show_fourcolumn_options', false) );
$dancing_star_show_welcome_sections      		= esc_attr( get_theme_mod('dancing_star_show_welcome_sections', false) );
?>
<div id="SiteWrapper" <?php if( get_theme_mod( 'dancing_star_sitelayout' ) ) { echo 'class="boxlayout"'; } ?>>
<?php
if ( is_front_page() && !is_home() ) {
	if( !empty($dancing_star_show_frontslider)) {
	 	$innerpage_cls = '';
	}
	else {
		$innerpage_cls = 'innerpage_header';
	}
}
else {
$innerpage_cls = 'innerpage_header';
}
?>

<div id="masthead" class="site-header <?php echo esc_attr($innerpage_cls); ?> "> 
     <div class="container">
        <?php if( $dancing_star_show_topstrip != ''){ ?> 
           <div class="HeadStrip">
             <div class="left">
				<?php $dancing_star_hdrtelephone = get_theme_mod('dancing_star_hdrtelephone');
                    if( !empty($dancing_star_hdrtelephone) ){ ?>              
                    <div class="cdbox">
                        <i class="fas fa-phone fa-rotate-90"></i>
                        <?php echo esc_html($dancing_star_hdrtelephone); ?>
                    </div>       
                <?php } ?>
            
             <?php $email = get_theme_mod('dancing_star_emailid');
                if( !empty($email) ){ ?>                
                <div class="cdbox">
                    <i class="far fa-envelope"></i>
                    <a href="<?php echo esc_url('mailto:'.sanitize_email($email)); ?>"><?php echo sanitize_email($email); ?></a>
                </div>            
            <?php } ?>
            </div><!--end .left-->
            <div class="right">
                <div class="cdbox hdrsocial">                                                
                           <?php $dancing_star_facebooklink = get_theme_mod('dancing_star_facebooklink');
                            if( !empty($dancing_star_facebooklink) ){ ?>
                            <a class="fab fa-facebook-f" target="_blank" href="<?php echo esc_url($dancing_star_facebooklink); ?>"></a>
                           <?php } ?>
                        
                           <?php $dancing_star_twitterlink = get_theme_mod('dancing_star_twitterlink');
                            if( !empty($dancing_star_twitterlink) ){ ?>
                            <a class="fab fa-twitter" target="_blank" href="<?php echo esc_url($dancing_star_twitterlink); ?>"></a>
                           <?php } ?>
                    
                          <?php $dancing_star_linkedinlink = get_theme_mod('dancing_star_linkedinlink');
                            if( !empty($dancing_star_linkedinlink) ){ ?>
                            <a class="fab fa-linkedin" target="_blank" href="<?php echo esc_url($dancing_star_linkedinlink); ?>"></a>
                          <?php } ?> 
                          
                          <?php $dancing_star_instagramlink = get_theme_mod('dancing_star_instagramlink');
                            if( !empty($dancing_star_instagramlink) ){ ?>
                            <a class="fab fa-instagram" target="_blank" href="<?php echo esc_url($dancing_star_instagramlink); ?>"></a>
                          <?php } ?> 
                   </div><!--end .hdrsocial-->
            </div><!--end .right-->
          <div class="clear"></div> 
           <?php
                $dancing_star_bookbtn = get_theme_mod('dancing_star_bookbtn');
                if( !empty($dancing_star_bookbtn) ){ ?>        
                <?php $dancing_star_bookbtnlink = get_theme_mod('dancing_star_bookbtnlink');
                if( !empty($dancing_star_bookbtnlink) ){ ?>              
                        <a class="quote" target="_blank" href="<?php echo esc_url($dancing_star_bookbtnlink); ?>">
                        	<?php echo esc_html($dancing_star_bookbtn); ?>            
                        </a>
             <?php }} ?> 
       </div><!-- .HeadStrip -->  
   <?php } ?>   
       
       
       
       <div class="logo">
           <?php dancing_star_the_custom_logo(); ?>
            <div class="site_branding">
                <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                <?php $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) : ?>
                    <p><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>
         </div><!-- logo --> 
         
          <div class="RightNavMenu"> 
             <div id="navigationpanel"> 
                 <nav id="main-navigation" class="SiteNav" role="navigation" aria-label="Primary Menu">
                    <button type="button" class="menu-toggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php
                    	wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                    ) );
                    ?>
                </nav><!-- #main-navigation -->  
            </div><!-- #navigationpanel -->   
          </div><!-- .RightNavMenu --> 
         <div class="clear"></div>
    </div><!-- .container --> 
 <div class="clear"></div> 
</div><!--.site-header --> 
 
<?php 
if ( is_front_page() && !is_home() ) {
if($dancing_star_show_frontslider != '') {
	for($i=1; $i<=3; $i++) {
	  if( get_theme_mod('dancing_star_sliderpageno'.$i,false)) {
		$slider_Arr[] = absint( get_theme_mod('dancing_star_sliderpageno'.$i,true));
	  }
	}
?> 
<div class="HomepageSlider">              
<?php if(!empty($slider_Arr)){ ?>
<div id="slider" class="nivoSlider">
<?php 
$i=1;
$slidequery = new WP_Query( array( 'post_type' => 'page', 'post__in' => $slider_Arr, 'orderby' => 'post__in' ) );
while( $slidequery->have_posts() ) : $slidequery->the_post();
$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); 
$thumbnail_id = get_post_thumbnail_id( $post->ID );
$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 
?>
<?php if(!empty($image)){ ?>
<img src="<?php echo esc_url( $image ); ?>" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php }else{ ?>
<img src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/images/slides/slider-default.jpg" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php } ?>
<?php $i++; endwhile; ?>
</div>   

<?php 
$j=1;
$slidequery->rewind_posts();
while( $slidequery->have_posts() ) : $slidequery->the_post(); ?>                 
    <div id="slidecaption<?php echo esc_attr( $j ); ?>" class="nivo-html-caption">         
     <h2><?php the_title(); ?></h2>
     <p><?php $excerpt = get_the_excerpt(); echo esc_html( dancing_star_string_limit_words( $excerpt, esc_attr(get_theme_mod('dancing_star_excerpt_length_frontslider','10')))); ?></p>
		<?php
        $dancing_star_sliderpageno_btntext = get_theme_mod('dancing_star_sliderpageno_btntext');
        if( !empty($dancing_star_sliderpageno_btntext) ){ ?>
            <a class="slidermorebtn" href="<?php the_permalink(); ?>"><?php echo esc_html($dancing_star_sliderpageno_btntext); ?></a>
        <?php } ?>         
    </div>   
<?php $j++; 
endwhile;
wp_reset_postdata(); ?>   
<?php } ?>
</div><!-- .HomepageSlider -->    
<?php } } ?> 

<?php if ( is_front_page() && ! is_home() ) { ?> 
     
 <?php if( $dancing_star_show_fourcolumn_options != ''){ ?> 
   <section id="Section-1">
     <div class="container">
     <div class="box-equal-height"> 
          <?php 
                for($n=1; $n<=4; $n++) {    
                if( get_theme_mod('dancing_star_fourcolpage'.$n,false)) {      
                    $queryvar = new WP_Query('page_id='.absint(get_theme_mod('dancing_star_fourcolpage'.$n,true)) );		
                    while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>     
                     <div class="FourCol <?php if($n % 4 == 0) { echo "last_column"; } ?>">   
                         <div class="topboxbg">
                            <div class="thumbbx-title">
								  <?php if(has_post_thumbnail() ) { ?>
                                    <div class="ImgCol">
                                      <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>                                
                                    </div> 
                                     <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>       
                                   <?php } ?>
                               </div>
                               <div class="InfoCol">                               
                               <p><?php $excerpt = get_the_excerpt(); echo esc_html( dancing_star_string_limit_words( $excerpt, esc_attr(get_theme_mod('dancing_star_excerpt_length_fourcolumn','10')))); ?></p> 
                                <a class="PageMorebtn" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'dancing-star'); ?></a>
                             </div>
                        </div>
                     </div>
                    <?php endwhile;
                    wp_reset_postdata();                                  
                } } ?>                                 
               <div class="clear"></div>
         </div><!-- .box-equal-height-->
      </div><!-- .container -->
    </section><!-- #Section-1 -->
  <?php } ?> 
  
   <?php if( $dancing_star_show_welcome_sections != ''){ ?> 
   <section id="Section-2">
     <div class="container"> 
          <?php 
        if( get_theme_mod('dancing_star_welcomepgbx',false)) {     
        $queryvar = new WP_Query('page_id='.absint(get_theme_mod('dancing_star_welcomepgbx',true)) );			
            while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>     
                    
							  <?php if(has_post_thumbnail() ) { ?>
                                <div class="WelImgBX">
                                  <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>                                
                                </div>        
                               <?php } ?>
                               <div class="Wel_DescBX">
                               <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                             <p><?php $excerpt = get_the_excerpt(); echo esc_html( dancing_star_string_limit_words( $excerpt, esc_attr(get_theme_mod('dancing_star_excerpt_length_welcomepgbx','40')))); ?></p>
                             <a class="ReadMoreBtn" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'dancing-star'); ?></a>
                           </div>
                           <div class="clear"></div>  
                     <?php endwhile;
					 wp_reset_postdata(); ?>                                    
            <?php } ?>                              
               <div class="clear"></div>  
      </div><!-- .container -->
    </section><!-- #Section-2-->
  <?php } ?> 
<?php } ?>