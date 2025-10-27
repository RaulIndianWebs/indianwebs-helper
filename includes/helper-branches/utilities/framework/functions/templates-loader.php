<?php

if (!function_exists('iw_load_template')) {
    /**
     * Carga un template desde el plugin, la carpeta de desarrollo o un tema hijo.
     *
     * @param string $template_name  Nombre del template (sin extensión .php)
     * @param array  $vars           Variables a pasar al template
     */
    function iw_load_template($template_name, $vars = array(), $layout="default") {
        // Rutas base
        $base_path = 'includes/templates/' . $template_name;
        $theme_template = get_stylesheet_dir() . $base_path;
        $user_template = get_custom_helper_dir() . $base_path;
        $core_template = get_plugin_dir() . $base_path;

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
        include $template_path . $layout . '.php';

        IW_Scripts_Cache::cache_css_files($template_path."/css");
	    IW_Scripts_Cache::cache_js_files($template_path."/js");
    }
}

