<?php
// Prefijo para las opciones en la base de datos
$prefix = 'iw-';

// Carpeta de configuración
$config_dir = plugin_dir_path(__FILE__) . 'includes/config/';

// Obtenemos todos los archivos PHP de la carpeta
$config_files = glob($config_dir . '*.php');

foreach ($config_files as $file_path) {
    // Generamos un slug para la opción a partir del nombre del archivo
    $filename = basename($file_path); // ej: company-info.php
    $option_slug = $prefix . str_replace('.php', '', $filename);

    // Verifica si ya existe en la base de datos
    if (get_option($option_slug) === false) {
        $config_array = include $file_path;

        if (is_array($config_array)) {
            update_option($option_slug, $config_array);
        } else {
            error_log("[$option_slug] El archivo PHP no devuelve un array: $filename");
        }
    }
}







// Load custom WordPress config
include_php_files(get_plugin_directory() . 'includes/wordpress-config/');



/* Require plugin features */
require_once plugin_dir_path(__FILE__) . 'includes/features.php';
/* Require vendor features */
require_once plugin_dir_path(__FILE__) . 'includes/vendor.php';
/* Require vendor features */
require_once plugin_dir_path(__FILE__) . 'includes/integrations.php';
/* Require child features */
require_once plugin_dir_path(__FILE__) . 'includes/custom-folder.php';



