<?php
class IW_Helper_Setup_Manager {
    public static function init() {
        self::load_custom_config();
        self::custom_folder();
    }

    
    public static function load_custom_config() {
        $custom_config = getHelperConfig("custom-wordpress-config");
        include_php_files(get_plugin_directory() . 'includes/wordpress-config/');
    }

    public static function custom_folder() {
        
    }
}
