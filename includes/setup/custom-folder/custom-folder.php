<?php
// Create folder if not created
$plugin_data_dir = 'iw-helper';
$plugin_data_path = trailingslashit(get_content_directory()) . $plugin_data_dir;

if (!file_exists($plugin_data_path)) {
    wp_mkdir_p($plugin_data_path);
}


$base_dir = trailingslashit(get_content_directory()) . 'iw-helper';

$structure = [
	'',
	'assets',
	'assets/css',
	'assets/css/divi-overides',
	'assets/css/divi-presets',
	'assets/js',
	'assets/js-functions',
	'assets/img',
	'assets/img/icons',
	'php',
	'shortcodes',
	'includes',
	'includes/functions',
	'includes/integration',
	'includes/integration/head',
	'includes/integration/body',
	'includes/acf-custom-fields',
	'includes/divi-custom-modules',
	'templates',
];

foreach ($structure as $relative_path) {
	$full_path = trailingslashit($base_dir) . $relative_path;

	if (!file_exists($full_path)) {
		wp_mkdir_p($full_path);
	}
}

// Create files if not exist
$css_variables_file = trailingslashit($base_dir) . 'assets/css-variables.css';
if (!file_exists($css_variables_file)) {
	file_put_contents($css_variables_file, "/* Archivo generado automáticamente */\n");
}



// Load Custom Plugin Theme Scripts
include_php_files(get_custom_helper_directory() . '/includes/php-functions/');
include_php_files(get_custom_helper_directory() . '/php');


IW_Scripts_Cache::cache_css_files(get_custom_helper_directory() . '/assets/css-variables.css');
IW_Scripts_Cache::cache_css_files(get_custom_helper_directory() . '/assets/css/');

IW_Scripts_Cache::cache_js_files(get_custom_helper_directory() . '/assets/js-functions/');
IW_Scripts_Cache::cache_js_files(get_custom_helper_directory() . '/assets/js/');


// Load custom Divi Modules
add_action('et_builder_ready', function() {
    include_php_files(get_custom_helper_directory() . '/includes/divi-custom-modules/');
});

// Load custom ACF Fields
add_action('acf/include_field_types', function($version) {
    include_php_files(get_custom_helper_directory() . '/includes/acf-custom-fields/');
});

load_custom_shortcodes(get_custom_helper_directory() . '/shortcodes/');



add_action("wp_head", function() {
	include_php_files(get_custom_helper_directory() . '/includes/integration/head/');
});

add_action("wp_footer", function() {
	include_php_files(get_custom_helper_directory() . '/includes/integration/body/');
});