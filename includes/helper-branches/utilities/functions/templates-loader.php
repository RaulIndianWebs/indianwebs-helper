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
        $theme_template = get_stylesheet_dir() . 'includes/templates/' . $template_name . '.php';
        $user_template = get_custom_helper_dir() . 'includes/templates/' . $template_name . '.php';
        $core_template = get_plugin_dir() . 'includes/templates/' . $template_name . '.php';

        // Determinar cuál existe
        if (file_exists($theme_template)) {
            $template_path = $theme_template;
        } elseif (file_exists($user_template)) {
            $template_path = $user_template;
        } elseif (file_exists($core_template)) {
            $template_path = $core_template;
        } else {
            $template_path = false;
        }

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
