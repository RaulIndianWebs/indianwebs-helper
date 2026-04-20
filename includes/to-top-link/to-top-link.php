<?php
// Get menu options
$options = getPluginOptions("helper-config")["features-options"]["to-top-link"];


if ($options["active"]) {
	/*IW_Scripts_Cache::cache_js_files(get_plugin_directory() . 'assets/js/features/to-top-link.js');
	IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/features/to-top-link.css');*/
    add_action("wp_footer", function() {
        echo iw_load_template("to-top-link", array());
    }, 10);
}