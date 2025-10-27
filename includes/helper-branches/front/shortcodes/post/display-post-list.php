<?php
// Base
$atts['base'] = shortcode_atts(array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'paged'          => '1',
    'orderby'        => 'date',
    'order'          => 'DESC',
), $atts);

// Filtros
$atts['filtros'] = shortcode_atts(array(
    'post_parent'    => '',
    'category_name'  => '',
    'tag'            => '',
    'meta_key'       => '',
    'meta_value'     => '',
    'author'         => '',
    's'              => '',
), $atts);

// Estructura
$atts['estructura'] = shortcode_atts(array(
    'container'     => 'ul',
    'container-id'  => '',
    'item'          => 'li',
    'item-header'   => 'h2',
    'layout'        => null,
), $atts);

// Construcción de la query
$query_args = $atts['base'];

foreach ($atts['filtros'] as $key => $value) {
    if ($value !== '') {
        if (in_array($key, ['post_parent', 'author'])) {
            $query_args[$key] = intval($value);
        } else {
            $query_args[$key] = sanitize_text_field($value);
        }
    }
}

$query = new WP_Query($query_args);

// Etiquetas
$container_tag   = tag_escape($atts['estructura']['container']);
$container_id    = $atts['estructura']['container-id'] !== '' 
                    ? ' id="' . esc_attr($atts['estructura']['container-id']) . '"' 
                    : '';
$item_tag        = tag_escape($atts['estructura']['item']);
$header_tag      = tag_escape($atts['estructura']['item-header']);

// Render
ob_start();
iw_load_template("main/shortcodes/post-list", array(
    "container_tag" => $container_tag,
    "container_id" => $container_id,
    "query" => $query,
    "item_tag" => $item_tag,
    "header_tag" => $header_tag,
));
return ob_get_clean();