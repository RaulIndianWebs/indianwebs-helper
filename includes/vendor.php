<?php
// Load slick library
add_action("wp_enqueue_scripts", function () {
    // Slick CSS
    wp_enqueue_style( 'slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );
    wp_enqueue_style( 'slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css' );

    // Slick JS
    wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, true );
});

// Load IW_BOOTSTRAP
add_action("wp_enqueue_scripts", function () {
    enqueue_css_files(get_plugin_directory() . 'vendor/iw-bootstrap/css/');
    enqueue_js_files(get_plugin_directory() . 'vendor/iw-bootstrap/js/');
});

// Add content to head
add_action('wp_head', function() {
    include_php_files(get_stylesheet_directory() . '/iw-includes/integration/head');
});

// Add content to body
add_action('wp_footer', function() {
    include_php_files(get_stylesheet_directory() . '/iw-includes/integration/body');
});

// Load Dashicons on front
add_action("wp_enqueue_scripts", function () {
    wp_enqueue_style('dashicons');
});

add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( strpos( $hook, 'settings_page_iw-helper-config' ) === false ) {
        return;
    }
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_style( 'thickbox' );
});



