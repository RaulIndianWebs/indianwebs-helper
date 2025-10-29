<?php
namespace IW_Helper\Setup;


add_action("Iw_Helper_Load_Setup", __NAMESPACE__ . "\\iw_load_ddbb");
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


add_action("Iw_Helper_Load_Setup",  __NAMESPACE__ . "\\iw_load_custom_config");
function iw_load_custom_config() {
    $custom_config = getHelperConfig("custom-wordpress-config");
    include_php_files(get_plugin_directory() . 'includes/wordpress-config/');
}


