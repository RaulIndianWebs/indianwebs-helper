<?php
namespace IW_Helper\Admin;

add_action("Iw_Helper_Load_Admin",  __NAMESPACE__ . "\\iw_load_admin_custom_pages");
function iw_load_admin_custom_pages() {
  require_once get_plugin_directory()."includes/admin/custom-admin-pages/admin-pages-loader.php";
  IW_Helper_Custom_Admin_Pages_Loader::add_dir(get_plugin_directory()."includes/admin-pages");
  IW_Helper_Custom_Admin_Pages_Loader::add_dir(get_custom_helper_directory()."includes/admin-pages");
  IW_Helper_Custom_Admin_Pages_Loader::add_dir(get_stylesheet_directory()."includes/admin-pages");
  IW_Helper_Custom_Admin_Pages_Loader::init();
}


