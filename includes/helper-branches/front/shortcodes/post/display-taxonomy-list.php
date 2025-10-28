<?php
$atts = shortcode_atts(array(
    "taxonomy-name" => "",
    "depth"         => -1,
    "parent"        => 0,
    "layout"        => "default",
), $atts);

if (empty($atts['taxonomy-name']) || !taxonomy_exists($atts['taxonomy-name'])) {
    return "<p>Taxonomía no válida.</p>";
}

ob_start();

iw_load_template('main/shortcodes/taxonomy-list', array(
    'taxonomy' => $atts['taxonomy-name'],
    'part'    => "container-open",
), $atts["layout"]);

iw_render_taxonomy_items($atts['taxonomy-name'], $atts["depth"], $atts["parent"], $atts["layout"]);

iw_load_template('main/shortcodes/taxonomy-list', array(
    'part'    => "container-close",
), $atts["layout"]);

return ob_get_clean();




/**
 * Carga recursiva de los términos usando templates
 */
function iw_render_taxonomy_items($taxonomy, $depth, $parent,  $layout = "default", $current_depth = 0) {
    if ($current_depth >= $depth) {
        iw_load_template('main/shortcodes/taxonomy-list', array(
            'term_name'          => $term->name,
            'term_url'          => get_term_link($term),
            'part'    => "child-single",
        ), $layout);
    }
    else {
        foreach ($terms as $term) {
            $children = get_terms(array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
                'parent'     => $term->term_id,
            ));

            if (empty($children)) {
                $single = true;
            }
            else {
                iw_load_template('main/shortcodes/taxonomy-list', array(
                    'term'          => $term,
                    'part'    => "child-has-children-open",
                ), $layout);
                iw_render_taxonomy_items($taxonomy, $children, $current_depth + 1, $layout);
                iw_load_template('main/shortcodes/taxonomy-list', array(
                    'term'          => $term,
                    'part'    => "child-has-children-close",
                ), $layout);
            }
        }
    }
}