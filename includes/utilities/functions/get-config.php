<?php
if (!function_exists("saveHelperOptions")) {
	function saveHelperOptions($options_slug, $options_array) {
		$options_slug = "iw-".$options_slug;
	    if (!is_string($options_slug) || empty($options_slug)) {
	        return false;
	    }

	    return update_option($options_slug, $options_array);
	}
}

if (!function_exists("getHelperOptions")) {
	function getHelperOptions($options_slug) {
		$options_slug = "iw-".$options_slug;
	    if (!is_string($options_slug) || empty($options_slug)) {
	        return array();
	    }

	    return get_option($options_slug);
	}

}