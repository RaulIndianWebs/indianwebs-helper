<?php
/*
Plugin Name: IndianWebs Helper
Plugin URI: https://www.indianwebs.com/
Description: Plugin para la implementación adicional de la página.
Version: 3.0
Author: IndianWebs L'Hospitalet
Author URI: https://www.indianwebs.com/
Text Domain: iw-helper
Domain Path: /languages
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit;


// Iniciar Loader
add_action('plugins_loaded', "iw_helper_load");
function iw_helper_load() {
    require_once __DIR__."/loader.php";
}


// Gestión de actualizaciones
require 'vendor/plugin-update-checker-master';


$updateChecker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
    'https://github.com/RaulDominguezSalgado/indianwebs_helper',
    __FILE__,
    'iw-helper'
);


// Gestión al desinstalar
register_uninstall_hook(__FILE__, 'iw_helper_uninstall');
function iw_helper_uninstall() {
    Iw_Helper_DB_Manager::resetAll();
}










