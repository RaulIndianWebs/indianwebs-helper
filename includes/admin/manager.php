<?php
namespace IW_Helper\Admin;

add_action("Iw_Helper_Load_Admin",  __NAMESPACE__ . "\\iw_load_admin_custom_pages", 10);
function iw_load_admin_custom_pages() {
  IW_Helper_Custom_Admin_Pages_Loader::add_dir(get_plugin_directory()."includes/admin/admin-pages");
  IW_Helper_Custom_Admin_Pages_Loader::add_dir(get_custom_helper_directory()."includes/-pages");
  IW_Helper_Custom_Admin_Pages_Loader::add_dir(get_stylesheet_directory()."includes/-pages");
  IW_Helper_Custom_Admin_Pages_Loader::init();
}


add_action("admin_menu", function() {
  \Iw_Admin_Page_Manager::init();
}, 999);
