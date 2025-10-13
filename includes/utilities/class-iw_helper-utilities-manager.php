<?php
class IW_Helper_Utilities_Manager {
    public static function init() {
        self::load_functions();
        self::load_classes();
    }

    public static function load_functions() {
        foreach (self::get_php_files(__DIR__ . '/functions') as $file) {
            require_once $file;
        }
    }

    public static function load_classes() {
        foreach (self::get_php_files(__DIR__ . '/classes') as $file) {
            require_once $file;
        }
    }

    private static function get_php_files($dir) {
        $files = [];
        foreach (glob($dir . '/*.php') as $file) {
            $files[] = $file;
        }
        foreach (glob($dir . '/*', GLOB_ONLYDIR) as $subdir) {
            $files = array_merge($files, self::get_php_files($subdir));
        }
        return $files;
    }
}
