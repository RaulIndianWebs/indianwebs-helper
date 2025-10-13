<?php
namespace IW_Helper\Integrations;

// WooCommerce
if ( class_exists('WooCommerce') ) {
    add_action('plugins_loaded', function() {
        include_php_files(get_plugin_directory() . 'includes/integration/woocommerce/shortcodes');
    }, 11);
}

// Divi
if ( function_exists('et_builder_ready') ) {
    add_action('et_builder_ready', function() {
        include_php_files(get_plugin_directory() . 'includes/divi-custom-modules/');
    });
}

// ACF
if ( function_exists('acf') || class_exists('ACF') ) {
    add_action('acf/include_field_types', function($version) {
        include_php_files(get_plugin_directory() . 'includes/acf-custom-fields/');
    });
}

// IW_BOOTSTRAP (si quieres, puedes dejarlo siempre cargado)
add_action('wp_enqueue_scripts', function() {
    enqueue_css_files(get_plugin_directory() . 'vendor/iw-bootstrap/css/');
    enqueue_js_files(get_plugin_directory() . 'vendor/iw-bootstrap/js/');
});

// Head & Body custom includes
add_action('wp_head', function() {
    include_php_files(get_stylesheet_directory() . '/iw-includes/integration/head');
});

add_action('wp_footer', function() {
    include_php_files(get_stylesheet_directory() . '/iw-includes/integration/body');
});

// Dashicons
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('dashicons');
});

// Thickbox en admin
add_action('admin_enqueue_scripts', function($hook) {
    if ( strpos($hook, 'settings_page_iw-helper-config') !== false ) {
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
    }
});