<?php
namespace IW_Helper\Admin;

add_action("Iw_Helper_Load_Admin",  __NAMESPACE__ . "\\iw_load_admin_pages");
function iw_load_admin_pages() {
  require_once "admin-pages/admin-pages-loader.php";
  IW_Helper_Admin_Pages_Loader::add_dir(get_plugin_directory()."includes/admin-pages");
  IW_Helper_Admin_Pages_Loader::add_dir(get_custom_helper_directory()."includes/admin-pages");
  IW_Helper_Admin_Pages_Loader::add_dir(get_stylesheet_directory()."includes/admin-pages");
  IW_Helper_Admin_Pages_Loader::init();
}


