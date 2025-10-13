<?php
global $custom_config;

if ($custom_config["auto-updates"]["core"] == true) {
    add_filter('auto_update_core', '__return_false');
}
if ($custom_config["auto-updates"]["plugins"] == true) {
    add_filter('auto_update_plugin', '__return_false');
}
if ($custom_config["auto-updates"]["themes"] == true) {
    add_filter('auto_update_theme', '__return_false');
}
if ($custom_config["auto-updates"]["translations"] == true) {
    add_filter('auto_update_translation', '__return_false');
}
if ($custom_config["auto-updates"]["critical"] == true) {
    add_filter('allow_dev_auto_core_updates', '__return_false');
    add_filter('allow_minor_auto_core_updates', '__return_false');
    add_filter('allow_major_auto_core_updates', '__return_false');
}



if ($custom_config["auto-installs"]["themes"] == true) {
    remove_action('wp_install_defaults', 'wp_install_defaults');
    add_filter('wpmu_welcome_notification', '__return_false');
    add_filter('automatic_updates_is_vcs_checkout', '__return_true');
}




