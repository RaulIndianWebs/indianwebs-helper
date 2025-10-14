<?php
namespace IW_Helper\Admin;

add_action("Iw_Helper_Load_Admin",  __NAMESPACE__ . "\\iw_load_admin_pages");
function iw_load_admin_pages() {
  include_php_files(get_plugin_directory() . 'includes/admin/admin-pages-loader.php');
}


