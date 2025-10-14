<?php
namespace IW_Helper\Setup;

add_action("Iw_Helper_Load_Setup",  __NAMESPACE__ . "\\iw_load_custom_config");
function iw_load_custom_config() {
    $custom_config = getHelperConfig("custom-wordpress-config");
    include_php_files(get_plugin_directory() . 'includes/wordpress-config/');
}

