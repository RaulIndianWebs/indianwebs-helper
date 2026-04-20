<?php
/*
Plugin Name: IndianWebs Helper
Plugin URI: https://www.indianwebs.com/
Description: Plugin para la implementación adicional de la página.
Version: 6.2
Author: IndianWebs L'Hospitalet
Author URI: https://www.indianwebs.com/
Text Domain: iw-helper
Domain Path: /languages
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/



define('IW_HELPER_DIR', plugin_dir_path(__FILE__));
define('IW_HELPER_URL', plugin_dir_url(__FILE__));

require_once IW_HELPER_DIR.'/includes/file-management.php';
include_php_files(IW_HELPER_DIR . '/includes/functions/');
include_php_files(IW_HELPER_DIR . '/includes/classes/');



/* Require features */
require_once plugin_dir_path(__FILE__) . 'loader.php';




add_action('wp_footer', ['IW_Scripts_Cache', 'print_cached_css'], 999999);
add_action('wp_footer', ['IW_Scripts_Cache', 'print_cached_js'], 999999);






