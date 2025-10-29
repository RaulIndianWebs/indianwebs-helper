<?php
$atts = shortcode_atts(array(
    "taxonomy" => "",
    "depth"         => -1,
    "parent"        => 0,
    "layout"        => "default",
), $atts);

if (empty($atts['taxonomy']) || !taxonomy_exists($atts['taxonomy'])) {
    return "<p>Taxonomía no válida.</p>";
}

$atts["terms"] = get_terms(array(
    'taxonomy'   => $atts["taxonomy"],
    'hide_empty' => false,
    'parent'     => $atts["parent"],
));

if (empty($terms) || is_wp_error($terms)) {
    return "<p>La taxonomia no tiene términos.</p>";
}

ob_start();

iw_load_template('main/shortcodes/taxonomy-list', array(
    'taxonomy' => $atts['taxonomy'],
    'part'    => "container-open",
), $atts["layout"]);

iw_render_taxonomy_items($atts['terms'], $atts["depth"], $atts["layout"]);

iw_load_template('main/shortcodes/taxonomy-list', array(
    'part'    => "container-close",
), $atts["layout"]);

return ob_get_clean();




/**
 * Carga recursiva de los términos usando templates
 */
function iw_render_taxonomy_items($terms, $depth,  $layout = "default") {
    foreach ($terms as $term) {
        $children = get_terms(array(
            'taxonomy'   => $term->taxonomy,
            'hide_empty' => false,
            'parent'     => $term->term_id,
        ));

        if ($depth <= 1 || empty($children)) {
            iw_load_template('main/shortcodes/taxonomy-list', array(
                'term_name'          => $term->name,
                'term_url'          => get_term_link($term),
                'part'    => "child-single",
            ), $layout);
        }
        else {
            iw_load_template('main/shortcodes/taxonomy-list', array(
                'term'          => $term,
                'part'    => "child-has-children-open",
            ), $layout);
            iw_render_taxonomy_items($children, $depth - 1, $layout);
            iw_load_template('main/shortcodes/taxonomy-list', array(
                'term'          => $term,
                'part'    => "child-has-children-close",
            ), $layout);
        }
    }
}