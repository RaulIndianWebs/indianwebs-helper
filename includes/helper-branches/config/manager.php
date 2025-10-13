<?php
namespace IW_Helper\Config;

add_action("Iw_Helper_Load_Config",  __NAMESPACE__ . "\\iw_load_constants");
function iw_load_constants() {
    define('IW_HELPER_VERSION', '1.0.0');
    define('IW_HELPER_DIR', plugin_dir_path(dirname(__FILE__, 2)));
    define('IW_HELPER_URL', plugin_dir_url(dirname(__FILE__, 2)));
    define('IW_HELPER_DEV_CONTENT_PATH', WP_CONTENT_DIR . '/iw-helper');
}



add_action("Iw_Helper_Load_Config", __NAMESPACE__ . "\\iw_load_ddbb");
function iw_load_ddbb() {
    $prefix = 'iw-';

    $config_dir = plugin_dir_path(__FILE__) . 'includes/config/';

    $config_files = glob($config_dir . '*.php');

    foreach ($config_files as $file_path) {
        $filename = basename($file_path);
        $option_slug = $prefix . str_replace('.php', '', $filename);

        if (get_option($option_slug) === false) {
            $config_array = include $file_path;

            if (is_array($config_array)) {
                update_option($option_slug, $config_array);
            } else {
                error_log("[$option_slug] El archivo PHP no devuelve un array: $filename");
            }
        }
    }
}


