<?php
if (!function_exists("iw_post_list")) {
    function iw_post_list($base = [], $filters = [], $structure = [], $partial = "posts/archive", $template = "default") {
        $base = $base ?? array();
        $filters = $filters ?? array();
        $structure = $structure ?? array();
        $atts = array();

        $atts['base'] = array(
            'post_type'      => $base["post_type"]          ?? 'page',
            'orderby'        => $base["orderby"]            ?? 'date',
            'order'          => $base["order"]              ?? 'DESC',
            'posts_per_page' => $base["posts_per_page"]     ?? -1,
            'paged'          => $base["paged"]              ?? '1',
            'paginate'       => $base["paginate"]           ?? '1',
        );

        $atts['filters'] = array(
            'post_parent'    => $filters["post_parent"]     ?? '',
            'category_name'  => $filters["category_name"]   ?? '',
            'tag'            => $filters["tag"]             ?? '',
            'meta_key'       => $filters["meta_key"]        ?? '',
            'meta_value'     => $filters["meta_value"]      ?? '',
            'author'         => $filters["author"]          ?? '',
            's'              => $filters["s"]               ?? '',
        );

        $atts['structure'] = shortcode_atts(array(
            'container'     => $structure["container"]      ?? 'ul',
            'container-id'  => $structure["container-id"]   ?? '',
            'item'          => $structure["item"]           ?? 'li',
            'item-header'   => $structure["item-header"]    ?? 'h2',
        ), $atts);




        // Construcción de la query
        $query_args = $atts['base'];

        foreach ($atts['filters'] as $key => $value) {
            if ($value !== '') {
                if (in_array($key, ['post_parent', 'author'])) {
                    $query_args[$key] = intval($value);
                } else {
                    $query_args[$key] = sanitize_text_field($value);
                }
            }
        }

        $query_args["paged"] = max(1, get_query_var('paged') ? get_query_var('paged') : get_query_var('page'));

        return iw_load_template($partial, array(
            "query" => new WP_Query($query_args),
            "container_tag" => tag_escape($atts['structure']['container'] ?? 'div'),
            "container_id"  => esc_attr($atts['structure']['container-id'] ?? ''),
            "item_tag"      => tag_escape($atts['structure']['item'] ?? 'article'),
            "header_tag"    => tag_escape($atts['structure']['item-header'] ?? 'h3'),
            "post_type"     => $atts['base']["post_type"],
            "paginate"      => $atts['base']["paginate"],
        ), $template);
    }
}