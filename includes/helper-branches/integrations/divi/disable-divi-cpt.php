<?php
/**
 * Desactiva por completo el CPT "project" de Divi
 */
add_action('init', function () {
    // 1) Desregistrar post type
    if ( post_type_exists('project') ) {
        unregister_post_type('project');
    }

    // 2) Desregistrar sus taxonomías
    if ( taxonomy_exists('project_category') ) {
        unregister_taxonomy('project_category');
    }
    if ( taxonomy_exists('project_tag') ) {
        unregister_taxonomy('project_tag');
    }


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


    add_action('after_switch_theme', 'flush_rewrite_rules');
}, 20);
