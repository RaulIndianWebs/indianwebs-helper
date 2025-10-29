<?php
namespace IW_Helper\Config;

add_action("Iw_Helper_Load_Config",  __NAMESPACE__ . "\\iw_load_env_constants");
function iw_load_env_constants() {
    // Plugin enviroment
    define('IW_HELPER_VERSION', '1.0.0');

    // Plugin Folders
    define('IW_HELPER_DIR', plugin_dir_path(dirname(__FILE__, 2)));
    define('IW_HELPER_URL', plugin_dir_url(dirname(__FILE__, 2)));
    
    define('IW_HELPER_DEV_CONTENT_PATH', WP_CONTENT_DIR . '/iw-helper');
    define('IW_HELPER_DEV_CONTENT_URL   ', WP_CONTENT_URL . '/iw-helper');

    define('IW_HELPER_TEMPLATES_PATH', plugin_dir_path(__FILE__) . '/includes/templates/    ');
    define('IW_HELPER_DEV_TEMPLATES_PATH', WP_CONTENT_DIR . '/iw-helper');
}




