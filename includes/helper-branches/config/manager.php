<?php
namespace IW_Helper\Config;

add_action("Iw_Helper_Load_Config",  __NAMESPACE__ . "\\iw_load_constants");
function iw_load_constants() {
    define('IW_HELPER_VERSION', '1.0.0');
    define('IW_HELPER_DIR', plugin_dir_path(dirname(__FILE__, 2)));
    define('IW_HELPER_URL', plugin_dir_url(dirname(__FILE__, 2)));
    define('IW_HELPER_DEV_CONTENT_PATH', WP_CONTENT_DIR . '/iw-helper');
}




