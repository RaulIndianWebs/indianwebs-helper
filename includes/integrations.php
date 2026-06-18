<?php
// WooCommerce
add_action( 'plugins_loaded', function () {
	if ( class_exists( 'WooCommerce' ) ) {
        include_php_files(get_plugin_directory() . 'includes/integration/woocommerce/shortcodes');
        include_php_files(get_plugin_directory() . 'includes/integration/woocommerce/overides/');
    }
    if (function_exists( 'wpcf7' )) {
    	include_php_files(get_plugin_directory() . 'includes/integration/cf7/');
    }
    if (defined("MTNC_VERSION")) {
    	include_php_files(get_plugin_directory() . 'includes/integration/maintenance/');
    }
}, 11 );

add_action( 'after_setup_theme', function () {
    if (defined("ET_CORE_VERSION")) {
        include_php_files(get_plugin_directory() . 'includes/integration/divi/');
    }
}, 11 );

// Custom Divi Modules
add_action('et_builder_ready', function() {
    include_php_files(get_plugin_directory() . 'includes/divi-custom-modules/');
});

// Custom ACF Fields
add_action('acf/include_field_types', function($version) {
    include_php_files(get_plugin_directory() . 'includes/acf-custom-fields/');
});