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
        $user_template = get_plugin_dir('my-plugin-user') . '/templates/' . $template_name . '.php';
        $core_template = get_plugin_dir('my-plugin') . '/templates/' . $template_name . '.php';

        // Filtros opcionales (por si algún otro plugin quiere modificar las rutas)
        $user_template = apply_filters('iw_user_template_path', $user_template, $template_name);
        $core_template = apply_filters('iw_core_template_path', $core_template, $template_name);

        // Determinar cuál existe
        $template_path = file_exists($user_template) ? $user_template : (file_exists($core_template) ? $core_template : false);

        if (!$template_path) {
            do_action('iw_template_not_found', $template_name);
            trigger_error("Template no encontrado: {$template_name}", E_USER_WARNING);
            return;
        }

        // Extraer las variables para el template
        if (!empty($vars) && is_array($vars)) {
            extract($vars, EXTR_SKIP);
        }

        // Incluir el archivo
        include $template_path;
    }
}
