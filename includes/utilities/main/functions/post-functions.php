<?php

namespace IW_Helper\Utilities\Features\Posts;

if (!function_exists("get_taxonomy_array")) {
    function get_taxonomy_array($post_type, $taxonomy_name, $dimension, $parent=null) {
        // Validar que se reciban los parámetros
        if (empty($post_type)) {
            return new \WP_Error('missing_post_type', 'El parámetro post_type es obligatorio.');
        }

        if (empty($taxonomy_name)) {
            return new \WP_Error('missing_taxonomy_name', 'El parámetro taxonomy_name es obligatorio.');
        }

        if (!taxonomy_exists($taxonomy_name)) {
            return new \WP_Error('invalid_taxonomy', 'La taxonomía especificada no existe.');
        }

        // Validar dimension
        if (!is_numeric($dimension)) {
            return new \('invalid_dimension', 'El parámetro dimension debe ser numérico.');
        }
        $dimension = (int) $dimension;

        $taxonomy = get_taxonomy($taxonomy_name);

        if (!$taxonomy) {
            return new \('taxonomy_not_found', 'No se pudo obtener la taxonomía.');
        }

        // Validar post_type dentro de la taxonomía
        if (!isset($taxonomy->object_type) || !in_array($post_type, (array) $taxonomy->object_type)) {
            return new \('invalid_post_type', 'El post_type no está asociado a la taxonomía.');
        }

        $args = [
            'taxonomy' => $taxonomy_name,
            'hide_empty' => false,
        ];

        // Comprobar parent
        if (!is_null($parent)) {
            $parent_term = get_term_by('slug', $parent, $taxonomy_name);
            if ($parent_term && !is_wp_error($parent_term)) {
                $parent_id = $parent_term->term_id;
            } else {
                return new \('invalid_parent', 'El término padre proporcionado no es válido.');
            }
        }


        // Obtener términos
        $terms = \get_terms($args);



        



        if (is_wp_error($terms)) {
            return $terms; // Propagar error
        }

        if (empty($terms)) {
            return new \('no_terms', 'No se encontraron términos para la taxonomía.');
        }

        if ($dimension === 0) {
            return $terms;
        }

        return build_term_hierarchy($terms, $parent_id, $dimension);
    }
}

if (!function_exists('build_term_hierarchy')) {
    function build_term_hierarchy($terms, $parent_id = 0, $max_depth = -1, $current_depth = 0) {
        if (empty($terms) || !is_array($terms)) {
            return [];
        }

        $branch = [];

        foreach ($terms as $term) {
            if ((int) $term->parent === (int) $parent_id) {
                if ($max_depth === -1 || $current_depth < $max_depth) {
                    $children = build_term_hierarchy($terms, $term->term_id, $max_depth, $current_depth + 1);
                    if (!empty($children)) {
                        $term->children = $children;
                    }
                }
                $branch[] = $term;
            }
        }

        return $branch;
    }
}



if (!function_exists("iw_display_taxonomy_list_helper")) {
    function iw_display_taxonomy_list_helper($terms) {
        $return_value = '<ul>';

        foreach ($terms as $term) {
            $link = get_term_link($term);
            $title = esc_html($term->name);
            $return_value .= '<li>';
            $return_value .= '<a href="' . esc_url($link) . '">' . $title . '</a>';

            if (isset($term->children) && is_array($term->children) && !empty($term->children)) {
                $return_value .= iw_display_taxonomy_list_helper($term->children);
            }

            $return_value .= '</li>';
        }

        $return_value .= '</ul>';
        return $return_value;
    }
}

