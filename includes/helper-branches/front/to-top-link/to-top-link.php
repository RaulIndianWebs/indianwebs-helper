<?php
// Get menu options
$options = getHelperOptions("helper-config")["features-options"]["to-top-link"];


if ($options["active"]) {
	IW_Scripts_Cache::cache_js_files(get_plugin_directory() . 'assets/js/features/to-top-link.js');
	IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/features/to-top-link.css');

	$custom_template = get_custom_helper_directory().'/templates/to-top-link.php';
    if (file_exists($custom_template)) {
    	add_action("wp_footer", function() use ($custom_template) {
    		load_template($custom_template, true);
		});
    } else {
        $default_template = get_plugin_directory().'includes/templates/to-top-link.php';
        add_action("wp_footer", function() use ($default_template) {
    		load_template($default_template, true);
		});
    }
}