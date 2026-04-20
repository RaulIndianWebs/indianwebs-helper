<?php
// Solo si la opción está activada
if (!getPluginOptions("wordpress-config")["disable_divi_cpt"]) return;

// 1) Ocultar del admin
add_action('admin_init', function () {
    remove_menu_page('edit.php?post_type=project'); // Quita el menu de Project
});

// 2) Quitar soporte de Divi
add_filter('et_builder_post_types', function($post_types){
    return array_diff($post_types, ['project']);
});
add_filter('et_pb_blog_filterable_post_types', function($types){
    return array_diff($types, ['project']);
});

// 3) Quitar del REST API
add_filter('rest_post_types', function($post_types){
    unset($post_types['project']);
    return $post_types;
});

// 4) Opcional: redirigir cualquier intento de acceder a un proyecto
add_action('template_redirect', function () {
    if (is_singular('project') || is_post_type_archive('project')) {
        wp_redirect(home_url(), 301);
        exit;
    }
});