<?php

$config = getPluginOptions("integration-config")["woocommerce"]["shortcodes-options"]["product-list"];

$atts = shortcode_atts(array(
    "auto"      => true,
    "template"  => $config["template"],
    "limit"     => $config["limit"],
    "orderby"   => "date",
    "order"     => "DESC",
    "category"  => "",
    "paginate"  => $config["paginate"],
), $atts);

$wc_query = null;
$main_loop_error = false;

$atts['auto'] = filter_var($atts['auto'], FILTER_VALIDATE_BOOLEAN);
$atts['paginate'] = filter_var($atts['paginate'], FILTER_VALIDATE_BOOLEAN);

$paged = max(1, get_query_var('paged') ? get_query_var('paged') : get_query_var('page'));

if ($atts['auto']) {
    if (is_product_category() || is_product_tag()) {
        $term = get_queried_object();
        $term_id = $term->term_id;
        $display_type = get_term_meta($term_id, 'display_type', true);
        if ($display_type === 'subcategories') {
            return '';
        }

        global $wp_query;
        $wc_query = $wp_query;
    }
    else if (is_shop()) {
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => intval($atts['limit']),
            'orderby'        => sanitize_text_field($atts['orderby']),
            'order'          => sanitize_text_field($atts['order']),
            'post_status'    => 'publish',
        );

        if (!empty($atts['category'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($atts['category']),
                )
            );
        }

        if ($atts['paginate']) {
            $args['paged'] = $paged;
        }

        $wc_query = new WP_Query($args);
    }
}

if (!$wc_query || !$atts['auto']) {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => intval($atts['limit']),
        'orderby'        => sanitize_text_field($atts['orderby']),
        'order'          => sanitize_text_field($atts['order']),
        'post_status'    => 'publish',
    );

    if (!empty($atts['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($atts['category']),
            )
        );
    }

    if ($atts['paginate']) {
        $args['paged'] = $paged;
    }

    $wc_query = new WP_Query($args);
}

$output = iw_load_template("woocommerce/product-list", array(
    "query"         => $wc_query,
    "paginate"      => !empty($atts["paginate"]) ? $atts["paginate"] : false,
    "limit"         => $atts["limit"],
    "add_to_cart"   => $config["add-to-cart"],
), $atts["template"]);


if (!$atts['auto']) {
    wp_reset_postdata();
}

return $output;
