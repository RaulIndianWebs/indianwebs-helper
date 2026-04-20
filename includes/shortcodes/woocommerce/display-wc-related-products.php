<?php
$atts = shortcode_atts(array(
    "auto"      => true,
    "template"  => "default",
    "limit"     => 6,
    "product_id"  => "",
), $atts);

$atts['auto'] = filter_var($atts['auto'], FILTER_VALIDATE_BOOLEAN);

if ($atts['auto']) {
    if (is_product()) {
        $product = wc_get_product(get_queried_object_id());
        $product_id = $product ? $product->get_id() : 0;

        if (!$product_id) {
            return "<p>Hay un problema con el producto actual.</p>";
        }
        else {
            $related_ids = wc_get_related_products($product_id, intval($atts['limit']));
        }
    }
    else {
        return "<p>No estás en un producto de WooCommerce.</p>";
    }
}
else {
    $product_id = intval($atts["product_id"]);
    if (!$product_id) {
        return "<p>Hay un problema con el producto proporcionado.</p>";
    }

    $related_ids = wc_get_related_products($product_id, intval($atts['limit']));
}

$wc_query = new WP_Query(array(
    'post_type'      => 'product',
    'posts_per_page' => intval($atts['limit']),
    'post__in'       => $related_ids,
    'orderby'        => 'post__in',
    'post_status'    => 'publish',
));

$output = iw_load_template("woocommerce/product-list", array(
    "query"             => $wc_query,
    "paginate"          => false,
    "limit"             => $atts["limit"],
    "container_classes" => "iw-related-products",
), $atts["template"]);


if (!$atts['auto']) {
    wp_reset_postdata();
}

return $output;
