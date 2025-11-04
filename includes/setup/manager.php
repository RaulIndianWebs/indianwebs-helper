<?php
namespace IW_Helper\Setup;


add_action("Iw_Helper_Load_Setup", __NAMESPACE__ . "\\iw_load_ddbb");
function iw_load_ddbb() {
    $prefix = 'iw-';

    $config_dir = plugin_dir_path(__FILE__) . 'includes/config/';

    $config_files = glob($config_dir . '*.php');

    foreach ($config_files as $file_path) {
        $filename = basename($file_path);
        $option_slug = str_replace('.php', '', $filename);

        if (\Iw_Helper_DB_Manager::options("get", $option_slug) === false) {
            $config_array = include $file_path;

            if (is_array($config_array)) {
                \Iw_Helper_DB_Manager::options("update", $option_slug, $config_array);
            } else {
                \IW_Log::error("[$option_slug] El archivo PHP no devuelve un array: $filename", false);
            }
        }
    }
}


add_action("Iw_Helper_Load_Setup",  __NAMESPACE__ . "\\iw_load_custom_config");
function iw_load_custom_config() {
    if (\Iw_Helper_DB_Manager::options("get", "custom-wordpress-config")) {
        include_php_files(get_plugin_directory() . 'includes/wordpress-config/');
    }
}
