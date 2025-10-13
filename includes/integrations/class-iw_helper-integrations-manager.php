<?php
class IW_Helper_Integrations_Manager {

    public static function init() {
        // WooCommerce
        if ( class_exists('WooCommerce') ) {
            self::woocommerce_shortcodes();
        }

        // Divi
        if ( function_exists('et_builder_ready') ) {
            self::load_divi_modules();
        }

        // ACF
        if ( function_exists('acf') || class_exists('ACF') ) {
            self::load_acf_fields();
        }

        // IW_BOOTSTRAP (si quieres, puedes dejarlo siempre cargado)
        self::enqueue_iw_bootstrap();

        // Head & Body custom includes
        self::include_head();
        self::include_body();

        // Dashicons
        self::enqueue_dashicons();

        // Thickbox en admin
        self::enqueue_thickbox_admin();
    }

    private static function woocommerce_shortcodes() {
        add_action('plugins_loaded', function() {
            include_php_files(get_plugin_directory() . 'includes/integration/woocommerce/shortcodes');
        }, 11);
    }

    private static function load_divi_modules() {
        add_action('et_builder_ready', function() {
            include_php_files(get_plugin_directory() . 'includes/divi-custom-modules/');
        });
    }

    private static function load_acf_fields() {
        add_action('acf/include_field_types', function($version) {
            include_php_files(get_plugin_directory() . 'includes/acf-custom-fields/');
        });
    }

    private static function enqueue_iw_bootstrap() {
        add_action('wp_enqueue_scripts', function() {
            enqueue_css_files(get_plugin_directory() . 'vendor/iw-bootstrap/css/');
            enqueue_js_files(get_plugin_directory() . 'vendor/iw-bootstrap/js/');
        });
    }

    private static function include_head() {
        add_action('wp_head', function() {
            include_php_files(get_stylesheet_directory() . '/iw-includes/integration/head');
        });
    }

    private static function include_body() {
        add_action('wp_footer', function() {
            include_php_files(get_stylesheet_directory() . '/iw-includes/integration/body');
        });
    }

    private static function enqueue_dashicons() {
        add_action('wp_enqueue_scripts', function() {
            wp_enqueue_style('dashicons');
        });
    }

    private static function enqueue_thickbox_admin() {
        add_action('admin_enqueue_scripts', function($hook) {
            if ( strpos($hook, 'settings_page_iw-helper-config') !== false ) {
                wp_enqueue_script('thickbox');
                wp_enqueue_style('thickbox');
            }
        });
    }
}
