<?php


$atts = shortcode_atts(array(
    "post-type" => "",
    "taxonomy-name" => "",
    "dimension" => "0",
    "parent" => null
), $atts);


$taxonomy_array = get_taxonomy_array($atts["post-type"], $atts["taxonomy-name"], intval($atts["dimension"]), $atts["parent"]);


// Comprobar si es WP_Error para mostrar error en el shortcode
if (is_wp_error($taxonomy_array)) {
    return '<div class="iw-taxonomy-list-error">Error: ' . esc_html($taxonomy_array->get_error_message()) . '</div>';
}

$output = '<div class="iw-taxonomy-list">';
$output .= iw_display_taxonomy_list_helper($taxonomy_array);
$output .= '</div>';
return $output;





/*
add_shortcode("iw-display-taxonomy-list", function($atts) {
    
});
*/
