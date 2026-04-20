<?php
if (getPluginOptions('disable_core_updates')) {
	add_filter('auto_update_core', '__return_false');
}
if (getPluginOptions('disable_plugin_updates')) {
	add_filter('auto_update_plugin', '__return_false');
}
if (getPluginOptions('disable_theme_updates')) {
	add_filter('auto_update_theme', '__return_false');
}
if (getPluginOptions('disable_default_themes')) {
	remove_action('wp_install_defaults', 'wp_install_defaults');
	add_filter('automatic_updates_is_vcs_checkout', '__return_true');
	add_filter('wpmu_welcome_notification', '__return_false');
}
if (getPluginOptions('disable_translation_updates')) {
	add_filter('auto_update_translation', '__return_false');
}
if (getPluginOptions('disable_security_options')) {
	add_filter('allow_dev_auto_core_updates', '__return_false');
	add_filter('allow_minor_auto_core_updates', '__return_false');
	add_filter('allow_major_auto_core_updates', '__return_false');
}