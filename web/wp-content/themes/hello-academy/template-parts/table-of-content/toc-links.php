<?php
/**
 * Hello Academy Table of content - Links.
 *
 * @package HelloAcademy
 */

// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( 'sticky' === HelloAcademy\get_customizer_settings( 'table_of_content_layout', true ) ) {
	$toc_sticky = 'toc-sticky';
} elseif ( 'inline' === HelloAcademy\get_customizer_settings( 'table_of_content_layout', true ) ) {
	$toc_sticky = 'toc-inline';
} else {
	$toc_sticky = 'toc-inline';
}

if ( 'hierarchy' === HelloAcademy\get_customizer_settings( 'table_of_content_structure', true ) ) {
	$toc_structure = '1';
} elseif ( 'list' === HelloAcademy\get_customizer_settings( 'table_of_content_structure', true ) ) {
	$toc_structure = '0';
} else {
	$toc_structure = '0';
}

if ( HelloAcademy\get_customizer_settings( 'table_of_content_list_style', true ) ) {
	$toc_list_style = HelloAcademy\get_customizer_settings( 'table_of_content_list_style', true );
} else {
	$toc_list_style = 'none';
}

?>

<div class="hello-academy-toc-link-wrapper <?php echo $toc_sticky; ?> <?php echo $toc_list_style; ?>">
	<?php echo HelloAcademy\toc_heading_list( get_the_content(), $toc_structure, '1,2,3,4,5,6' ); ?>	
</div>
