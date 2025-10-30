<?php

if (!class_exists("Iw_Admin_Page_Manager")) {
    class Iw_Admin_Page_Manager {
        public static array $admin_pages;
        public static array $admin_subpages;

        public static function add_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position) {
            self::$admin_pages[] = array(
                "page_title" => $page_title,
                "menu_title" => $menu_title,
                "capability" => $capability,
                "menu_slug" => $menu_slug,
                "function" => $function,
                "icon_url" => $icon_url,
                "position" => $position,
            );
        }

        public static function add_subpage() {
            self::$admin_pages[] = array(

            );
        }

        public static function init() {

        }
    }
}