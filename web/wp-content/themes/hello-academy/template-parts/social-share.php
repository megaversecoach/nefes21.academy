<?php
/**
 * Hello Academy Post Share.
 *
 * @package HelloAcademy
 *
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$share_config = array(
	'title' => get_the_title(),
	'text'  => get_the_excerpt(),
	'image' => get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' ),
);

if ( 'sticky' === HelloAcademy\get_customizer_settings( 'enable_sticky_social_share', true ) ) {
	$social_share_sticky = 'social-share-sticky';
} elseif ( 'inline' === HelloAcademy\get_customizer_settings( 'enable_sticky_social_share', true ) ) {
	$social_share_sticky = 'social-share-inline';
} else {
	$social_share_sticky = '';
}
?>


<div class="hello-academy-social-share">
	<div class="hello-academy-post-share hello-academy-social-share-wrapper <?php echo $social_share_sticky; ?>">
		<h5><?php echo esc_html_e( 'Share Now', 'hello-academy' ); ?></h5>
		<button class="academy-btn academy-btn--bg-white-border academy-share-button"><i class="academy-icon academy-icon--share"></i><?php esc_html_e( 'Share', 'hello-academy' ); ?></button>
		<div class="academy-share-wrap" data-social-share-config="<?php echo esc_attr( wp_json_encode( $share_config ) ); ?>">
			<button class="academy-social-share academy_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></button>
			<button class="academy-social-share academy_linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></button>
			<button class="academy-social-share academy_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></button>
			<button class="academy-social-share academy_pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></button>
			<button class="academy-social-share academy_gmail"><i class="fa fa-envelope-o" aria-hidden="true"></i></button>
			<button class="academy-social-share academy_whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></button>
			<button class="academy-social-share academy_vk"><i class="fa fa-vk" aria-hidden="true"></i></button>
			<button class="academy-social-share academy_tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i></button>
			<button class="academy-social-share academy_pocket"><i class="fa fa-get-pocket" aria-hidden="true"></i></button>
			<button class="academy-social-share academy_instapaper"><i class="fa fa-italic" aria-hidden="true"></i></button>
		</div>
		<div class="hello-academy-social-share-expend-icon">
			<i class="fa fa-angle-down" aria-hidden="true"></i>
			<i class="fa fa-angle-up" aria-hidden="true"></i>
		</div>
	</div>
</div>
