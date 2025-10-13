<?php
// Get menu options
$options = getHelperOptions("helper-config")["features-options"]["off-canva-options"];


if ($options["active"]) {
	// Register new menu location
	register_nav_menu( 'off-canva', 'Off Canva Menu');

	IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/features/off-canva-menu.css');
	IW_Scripts_Cache::cache_js_files(get_plugin_directory() . 'assets/js/features/off-canva-menu.js');

	// Print off-canva-menu container in footer
	add_action("wp_footer", function() use ($options) {
		iw_load_template("to-top-link", array(
			
		));
	});
}