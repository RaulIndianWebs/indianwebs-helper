<?php
add_action( 'plugins_loaded', function () {
	if ( class_exists( 'WooCommerce' ) ) {
        include_php_files(get_plugin_directory() . 'includes/integration/woocommerce/shortcodes');
        include_php_files(get_plugin_directory() . 'includes/integration/woocommerce/overides/');
    }
    else if (function_exists( 'wpcf7' )) {
    	include_php_files(get_plugin_directory() . 'includes/integration/cf7/');
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