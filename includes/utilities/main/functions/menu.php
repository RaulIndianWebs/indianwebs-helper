<?php

namespace IW_Helper\Utilities\Features\Customization;

if (!function_exists("iw_render_custom_accordion_menu")) {
    function iw_render_custom_accordion_menu($theme_location) {
        $locations = \get_nav_menu_locations();

        if (!isset($locations[$theme_location])) {
            echo '<p>No hay menú asignado a la ubicación "' . esc_html($theme_location) . '".</p>';
            return;
        }

        // Obtener el objeto de menú
        $menu = \wp_get_nav_menu_object($locations[$theme_location]);
        $menu_items = \wp_get_nav_menu_items($menu->term_id);

        // Construir un array jerárquico
        $menu_tree = [];

        foreach ($menu_items as $item) {
            $item->children = [];
            $menu_tree[$item->ID] = $item;
        }

        foreach ($menu_items as $item) {
            if ($item->menu_item_parent) {
                $menu_tree[$item->menu_item_parent]->children[] = $item;
            }
        }

        // Renderizamos el HTML recursivo
        echo '<nav class="off-canvas-nav">';
        echo '<ul class="off-canvas-menu">';
        
        foreach ($menu_tree as $item) {
            if (!$item->menu_item_parent) {
                iw_render_menu_item($item);
            }
        }

        echo '</ul>';
        echo '</nav>';
    }
}


if (!function_exists("iw_render_menu_item")) {
    function iw_render_menu_item($item) {
        echo '<li class="iw-menu-item">';
        echo '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';

        if (!empty($item->children)) {
            echo '<button class="iw-submenu-toggle"></button>';
            echo '<ul class="iw-sub-menu">';
            foreach ($item->children as $child) {
                iw_render_menu_item($child); // llamada recursiva para multianidado
            }
            echo '</ul>';
        }
        else {
            
        }

        echo '</li>';
    }
}




