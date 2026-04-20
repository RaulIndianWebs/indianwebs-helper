<?php
// WooCommerce
add_action( 'plugins_loaded', 'iw_helper_integrations_woocommerce_add_custom_shortcodes', 11 );
function iw_helper_integrations_woocommerce_add_custom_shortcodes() {
	if ( class_exists( 'WooCommerce' ) ) {
        include_php_files(get_plugin_directory() . 'includes/integration/woocommerce/shortcodes');
    }
}
include_php_files(get_plugin_directory() . 'includes/integration/woocommerce/overides/');

// Custom Divi Modules
add_action('et_builder_ready', function() {
    include_php_files(get_plugin_directory() . 'includes/divi-custom-modules/');
});

// Custom ACF Fields
add_action('acf/include_field_types', function($version) {
    include_php_files(get_plugin_directory() . 'includes/acf-custom-fields/');
});