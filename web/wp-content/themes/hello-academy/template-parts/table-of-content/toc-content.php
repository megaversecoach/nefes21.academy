<?php
/**
 * Hello Academy Table of content - Contents.
 *
 * @package HelloAcademy
 */

// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="hello-academy-single-content" class="hello-academy-toc-content">
	<?php 
		$content = apply_filters('the_content', get_the_content());
		echo HelloAcademy\toc_content( $content, 'h1,h2,h3,h4,h5,h6' ); 
	?> 
</div>
