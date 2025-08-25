<?php
/**
 * text
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$title = (isset($input['title'])) ? $input['title'] : '';
$description = (isset($input['description'])) ? $input['description'] : '';
$label = (isset($input['label'])) ? $input['label'] : '';
$placeholder = (isset($input['placeholder'])) ? $input['placeholder'] : '';
$parent_class = (isset($input['parent_class'])) ? $input['parent_class'] : '';

?>
<div class="row ctc_component_text <?php echo esc_attr($parent_class) ?>">
    <div class="input-field col s12">
        <input name="<?php echo esc_attr($dbrow) ?>[<?php echo esc_attr($db_key) ?>]" type="text" value="<?php echo esc_attr($db_value) ?>" placeholder="<?php echo esc_attr($placeholder) ?>"/>
        <label for="pre_filled"><?php echo esc_html($label) ?></label>
        <p class="description"><?php echo esc_html($description) ?></p>
    </div>
</div>