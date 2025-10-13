<?php
class IW_Helper_Front_Manager {
    public static function init() {
        self::start_cache_system();
		self::load_cookie_manager();
		self::load_helper_modules();
		self::load_shortcodes();
		self::load_front_scritps();
    }
	
	public static function start_cache_system() {
		add_action('wp_head', ['IW_Scripts_Cache', 'print_cached_css']);
		add_action('wp_footer', ['IW_Scripts_Cache', 'print_cached_js']);
	}

	public static function load_cookie_manager() {
		include_php_files(get_plugin_directory() . 'includes/cookies-manager/');
	}

	public static function load_helper_modules() {
		// Load off-canva-menu
		include_php_files(get_plugin_directory() . 'includes/off-canva-menu/');

		// Load to top link
		include_php_files(get_plugin_directory() . 'includes/to-top-link/');
	}

	public static function load_shortcodes() {
		// Add plugin shortcodes
		load_custom_shortcodes(get_plugin_directory() . 'includes/shortcodes/');
	}

	public static function load_front_scritps() {
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
}










