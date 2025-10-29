<?php
namespace IW_Helper\Utilities;

add_action("Iw_Helper_Load_Utilities",  __NAMESPACE__ . "\\load_core", 10);
add_action("Iw_Helper_Load_Utilities",  __NAMESPACE__ . "\\load_framework", 20);
add_action("Iw_Helper_Load_Utilities",  __NAMESPACE__ . "\\load_main", 30);




function load_core() {
    load_module(__DIR__."/core");
}

function load_framework() {
    load_module(__DIR__."/framework");
}

function load_main() {
    load_module(__DIR__."/main");
}






function load_module($path) {
    if (!is_dir($path)) {
        return false;
    }

    foreach (get_php_files($path."/functions") as $file) {
        require_once $file;
    }
    foreach (get_php_files($path."/classes") as $file) {
        require_once $file;
    }

    return true;
}

function get_php_files($dir) {
    $files = [];
    foreach (glob($dir . '/*.php') as $file) {
        $files[] = $file;
    }
    foreach (glob($dir . '/*', GLOB_ONLYDIR) as $subdir) {
        $files = array_merge($files, get_php_files($subdir));
    }
    return $files;
}
