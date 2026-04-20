<?php
// Template
$template = shortcode_atts(array(
    'parcial' => 'posts/archive',
    'archivo' => 'default',
), $atts);

// Base
$base = shortcode_atts(array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'paged'          => '1',
    'orderby'        => 'date',
    'order'          => 'DESC',
), $atts);

// Filtros
$filtros = shortcode_atts(array(
    'post_parent'    => '',
    'category_name'  => '',
    'tag'            => '',
    'meta_key'       => '',
    'meta_value'     => '',
    'author'         => '',
    's'              => '',
), $atts);

// Estructura
$estructura = shortcode_atts(array(
    'container'     => 'div',
    'container-id'  => '',
    'item'          => 'article',
    'item-header'   => 'h3',
), $atts);


return iw_post_list($base, $filtros, $estructura, $template["parcial"], $template["archivo"]);