<?php

if (!function_exists('iw_load_template')) {
    /**
     * Carga un template desde el plugin editable o el plugin base.
     *
     * @param string $template_name  Nombre del template (sin extensión .php)
     * @param array  $vars           Variables a pasar al template
     */
    function iw_load_template($template_name, $vars = array()) {
        // Rutas base
        $user_template = get_custom_helper_url() . 'includes/templates/' . $template_name . '.php';
        $core_template = get_plugin_dir() . 'includes/templates/' . $template_name . '.php';

        // Determinar cuál existe
        $template_path = file_exists($user_template) ? $user_template : (file_exists($core_template) ? $core_template : false);

        if (!$template_path) {
            trigger_error("Template no encontrado: {$template_name}", E_USER_WARNING);
            return;
        }

        if (!empty($vars) && is_array($vars)) {
            extract($vars, EXTR_SKIP);
        }

        // Incluir el archivo
        include $template_path;
    }
}
