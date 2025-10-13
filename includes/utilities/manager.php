<?php
namespace IW_Helper\Utilities;

add_action("Iw_Helper_Load_Utilities",  __NAMESPACE__ . "\\iw_load_functions");

add_action("Iw_Helper_Load_Utilities",  __NAMESPACE__ . "\\iw_load_classes");



function iw_load_functions() {
    foreach (get_php_files(__DIR__ . '/functions') as $file) {
        require_once $file;
    }
}

function iw_load_classes() {
    foreach (get_php_files(__DIR__ . '/classes') as $file) {
        require_once $file;
    }
}

function get_php_files($dir) {
    $files = [];
    foreach (glob($dir . '/*.php') as $file) {
        $files[] = $file;
    }
    foreach (glob($dir . '/*', GLOB_ONLYDIR) as $subdir) {
        $files = array_merge($files, self::get_php_files($subdir));
    }
    return $files;
}
