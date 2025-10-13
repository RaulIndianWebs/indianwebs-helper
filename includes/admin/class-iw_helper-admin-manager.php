<?php
class IW_Helper_Admin_Manager {
    public static function init() {
        self::load_admin_pages();
    }

    public static function load_admin_pages() {
		include_php_files(get_plugin_directory() . 'includes/admin/admin-pages-loader.php');
    }
}


