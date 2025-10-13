<?php
if (!function_exists("get_plugin_directory")) {
	function get_plugin_directory() {
	    return IW_HELPER_DIR;
	}
}

if (!function_exists("get_plugin_url")) {
	function get_plugin_url() {
	    return IW_HELPER_URL;
	}
}

if (!function_exists("get_content_directory")) {
	function get_content_directory() {
	    return WP_CONTENT_DIR; // Devuelve la ruta absoluta a /wp-content
	}
}

if (!function_exists("get_content_url")) {
	function get_content_url() {
	    return content_url(); // Devuelve la URL pública a /wp-content
	}
}

if (!function_exists("get_custom_helper_directory")) {
	function get_custom_helper_directory() {
	    return WP_CONTENT_DIR."/iw-helper"; // Devuelve la ruta absoluta a /wp-content
	}
}

if (!function_exists("get_custom_helper_url")) {
	function get_custom_helper_url() {
	    return content_url()."/iw-helper"; // Devuelve la URL pública a /wp-content
	}
}
