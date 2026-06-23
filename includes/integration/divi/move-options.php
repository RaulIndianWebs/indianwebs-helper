<?php
add_action('admin_bar_menu', function ($wp_admin_bar) {

    global $submenu;

    $parent_slug = 'et_divi_options';

    // Crear nodo principal
    $wp_admin_bar->add_node([
        'id'    => 'divi',
        'title' => 'Divi',
        'href'  => admin_url('admin.php?page=' . $parent_slug),
    ]);

    // Copiar automáticamente todos los hijos
    if (!empty($submenu[$parent_slug])) {

        foreach ($submenu[$parent_slug] as $item) {

            $title = wp_strip_all_tags($item[0]);
            $slug  = $item[2];

            $href = strpos($slug, '.php') !== false
                ? admin_url($slug)
                : admin_url('admin.php?page=' . $slug);

            $wp_admin_bar->add_node([
                'id'     => 'divi_' . sanitize_key($slug),
                'parent' => 'divi',
                'title'  => $title,
                'href'   => $href,
            ]);
        }
    }
}, 100);




add_action('admin_menu', function () {
    remove_menu_page('et_divi_options');
}, 999);