<?php

if (!class_exists("Iw_Admin_Page_Manager")) {
    class Iw_Admin_Page_Manager {
        public static array $admin_pages;
        public static array $admin_subpages;

        public static function add_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url=null, $position=null) {
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

        public static function add_subpage($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function) {
            self::$admin_pages[] = array(
                "parent_slug"   => $parent_slug,
                "page_title"    => $page_title,
                "menu_title"    => $menu_title,
                "capability"    => $capability,
                "menu_slug"     => $menu_slug,
                "function"      => $function,
            );
        }

        public static function init() {
            foreach (self::$admin_pages as $page) {
                add_menu_page($page["page_title"], $page["menu_title"], $page["capability"], $page["menu_slug"], $page["function"], $page["icon_url"], $page["position"]);
            }

            foreach (self::$admin_subpages as $subpage) {
                add_submenu_page($subpage["parent_slug"], $subpage["page_title"], $subpage["menu_title"], $subpage["capability"], $subpage["menu_slug"], $subpage["function"]);
            }
        }
    }
}