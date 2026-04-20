<?php
$atts = shortcode_atts(array(
    "auto"      => true,
    "template"  => "default",
    "parent"    => "",
    "orderby"   => "name",
    "order"     => "ASC",
), $atts);

$args = array();

if ($atts['auto'] && is_product_category()) {
    $term = get_queried_object();
    $parent_id = $term->term_id;

    $display_type = get_term_meta($parent_id, 'display_type', true);

    if ($display_type === 'subcategories' || $display_type === 'both') {
        $args['parent'] = $parent_id;
    } else if ($display_type === 'products') {
        return '';
    } else {
        $default_value = get_option("woocommerce_category_archive_display");

        if ($default_value === 'subcategories' || $default_value === 'both') {
            $args['parent'] = $parent_id;
        } else {
            return '';
        }
    }
} else if (!empty($atts['parent'])) {
    // Si se pasa un slug de categoría padre manualmente
    $parent_term = get_term_by('slug', sanitize_text_field($atts['parent']), 'product_cat');
    if ($parent_term) {
        $args['parent'] = $parent_term->term_id;
    }
}
else {
    return "";
}

$args = array_merge($args, array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'orderby'    => sanitize_text_field($atts['orderby']),
    'order'      => sanitize_text_field($atts['order']),
));

$subcategories = get_terms($args);

if (empty($subcategories) || is_wp_error($subcategories)) {
    return '';
}

$output = iw_load_template("woocommerce/category-list", array(
    "query" => $subcategories,
), $atts["template"]);

return $output;
