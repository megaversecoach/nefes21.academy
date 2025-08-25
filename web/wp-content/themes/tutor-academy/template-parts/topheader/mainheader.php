<?php
/**
 * Displays main header
 *
 * @package Tutor Academy
 */
?>
<?php if(get_theme_mod('online_tutor_top_header_setting') != ''){ ?>
<div class="top_header py-2 text-center text-md-start">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12 align-self-center">
                <?php if(get_theme_mod('online_tutor_ticket_text') != '' ){ ?>
                    <p class="mb-0"><?php echo esc_html(get_theme_mod('online_tutor_ticket_text','')); ?></p>
                <?php }?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 align-self-center text-md-end">
                <?php if(get_theme_mod('tutor_academy_admission') != '' || get_theme_mod('tutor_academy_admission_link') != ''){ ?>
                    <a href="<?php echo esc_url(get_theme_mod('tutor_academy_admission_link','')); ?>" class="me-2 info-text"><?php echo esc_html(get_theme_mod('tutor_academy_admission','')); ?></a>
                <?php }?>
                <?php if(get_theme_mod('tutor_academy_research') != '' || get_theme_mod('tutor_academy_research_link') != ''){ ?>
                    <a href="<?php echo esc_url(get_theme_mod('tutor_academy_research_link','')); ?>" class="me-2 info-text"><?php echo esc_html(get_theme_mod('tutor_academy_research','')); ?></a>
                <?php }?>
                <?php if(get_theme_mod('tutor_academy_faq') != '' || get_theme_mod('tutor_academy_faq_link') != ''){ ?>
                    <a  href="<?php echo esc_url(get_theme_mod('tutor_academy_faq_link','')); ?>" class="info-text"><?php echo esc_html(get_theme_mod('tutor_academy_faq','')); ?></a>
                <?php }?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 align-self-center">
                <?php if(get_theme_mod('online_tutor_facebook_url') != '' || get_theme_mod('online_tutor_twitter_url') != '' || get_theme_mod('online_tutor_intagram_url') != '' || get_theme_mod('online_tutor_linkedin_url') != '' || get_theme_mod('online_tutor_pintrest_url') != ''){ ?>
                    <div class="social-link text-md-center">
                        <?php if(get_theme_mod('online_tutor_facebook_url') != ''){ ?>
                            <a href="<?php echo esc_url(get_theme_mod('online_tutor_facebook_url','')); ?>"><i class="fab fa-facebook-f me-2"></i></a>
                        <?php }?>
                        <?php if(get_theme_mod('online_tutor_twitter_url') != ''){ ?>
                            <a href="<?php echo esc_url(get_theme_mod('online_tutor_twitter_url','')); ?>"><i class="fab fa-twitter me-2"></i></a>
                        <?php }?>
                        <?php if(get_theme_mod('online_tutor_intagram_url') != ''){ ?>
                            <a href="<?php echo esc_url(get_theme_mod('online_tutor_intagram_url','')); ?>"><i class="fab fa-instagram me-2"></i></a>
                        <?php }?>
                        <?php if(get_theme_mod('online_tutor_linkedin_url') != ''){ ?>
                            <a href="<?php echo esc_url(get_theme_mod('online_tutor_linkedin_url','')); ?>"><i class="fab fa-linkedin-in me-2"></i></a>
                        <?php }?>
                        <?php if(get_theme_mod('online_tutor_pintrest_url') != ''){ ?>
                            <a href="<?php echo esc_url(get_theme_mod('online_tutor_pintrest_url','')); ?>"><i class="fab fa-pinterest-p"></i></a>
                        <?php }?>
                    </div>
                <?php }?>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-12 align-self-center">
                <?php if(get_theme_mod('tutor_academy_search_setting',false) != ''){ ?>
                    <span class="head-search">
                        <div class="header-search-wrapper">
                            <span class="search-main">
                                <i class="fa fa-search"></i>
                            </span>
                            <div class="search-form-main clearfix">
                                <form method="get" class="search-form">
                                  <label>
                                    <input type="search" class="search-field form-control" placeholder="Search …" value="" name="s">
                                  </label>
                                  <input type="submit" class="search-submit btn btn-primary mt-3" value="Search">
                                </form>
                            </div>
                        </div>
                    </span>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php }?>