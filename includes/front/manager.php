<?php
namespace IW_Helper\Frontend;

add_action("Iw_Helper_Load_Utilities",  __NAMESPACE__ . "\\iw_start_cache_system");
function iw_start_cache_system() {
	add_action('wp_head', ['IW_Scripts_Cache', 'print_cached_css']);
	add_action('wp_footer', ['IW_Scripts_Cache', 'print_cached_js']);
}


add_action("Iw_Helper_Load_Utilities",  __NAMESPACE__ . "\\iw_load_cookie_manager");
function iw_load_cookie_manager() {
	include_php_files(get_plugin_directory() . 'includes/cookies-manager/');
}


add_action("Iw_Helper_Load_Utilities",  __NAMESPACE__ . "\\iw_load_helper_modules");
function iw_load_helper_modules() {
	// Load off-canva-menu
	include_php_files(get_plugin_directory() . 'includes/off-canva-menu/');

	// Load to top link
	include_php_files(get_plugin_directory() . 'includes/to-top-link/');
}


add_action("Iw_Helper_Load_Utilities",  __NAMESPACE__ . "\\iw_load_shortcodes");
function iw_load_shortcodes() {
	// Add plugin shortcodes
	load_custom_shortcodes(get_plugin_directory() . 'includes/shortcodes/');
}


add_action("Iw_Helper_Load_Utilities",  __NAMESPACE__ . "\\iw_load_front_scritps");
function iw_load_front_scritps() {
	// Load CSS Variables
	IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/css-variables.css');

	// Load overrides
	IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/divi-overides/');
	IW_Scripts_Cache::cache_js_files(get_plugin_directory() . 'assets/js/divi-overides/');
	IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/overides/');
	IW_Scripts_Cache::cache_js_files(get_plugin_directory() . 'assets/js/overides/');

	// Load CSS presets
	IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/presets/');
	IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/divi-presets/');
}









