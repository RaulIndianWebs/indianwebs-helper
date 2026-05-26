<?php
// Solo si la opción está activada
if (!getPluginOptions("wordpress-config")["disable_divi_cpt"]) return;


add_action('admin_menu', function () {
    remove_menu_page('edit.php?post_type=project');
});


add_filter('et_builder_post_types', function($post_types){
    return array_diff($post_types, ['project']);
});
add_filter('et_pb_blog_filterable_post_types', function($types){
    return array_diff($types, ['project']);
});


add_filter('rest_post_types', function($post_types){
    unset($post_types['project']);
    return $post_types;
});


add_action('template_redirect', function () {
    if (is_singular('project') || is_post_type_archive('project')) {
        wp_redirect(home_url(), 301);
        exit;
    }
});