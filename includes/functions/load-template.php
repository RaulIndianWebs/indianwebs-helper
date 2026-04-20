<?php
if (!function_exists('iw_load_template')) {
    /**
     * Carga un template desde el plugin, la carpeta de desarrollo o un tema hijo.
     *
     * @param string $template_name  Nombre del template (sin extensión .php)
     * @param array  $vars           Variables a pasar al template
     * @param string $layout         Nombre del layout (indica carpeta y archivo .php)
     */
    function iw_load_template($template_name, $vars = array(), $layout = "default") {
        // Rutas base
        $base_path = 'templates/' . $template_name . '/' . $layout . '/';
        $user_template = get_custom_helper_directory() . "/" . $base_path;
        $core_template = get_plugin_directory() . $base_path;

        $template_path = "";
        if (file_exists($user_template . $layout . '.php')) {
            $template_path = $user_template;
        } elseif (file_exists($core_template . $layout . '.php')) {
            $template_path = $core_template;
        } else {
            trigger_error("Template no encontrado: {$template_name}/{$layout}", E_USER_WARNING);
            return;
        }

        // Extraer variables para el template
        if (!empty($vars) && is_array($vars)) {
            extract($vars, EXTR_SKIP);
        }

        // Cachear assets según layout
        IW_Scripts_Cache::cache_css_files($template_path . "css/");
        IW_Scripts_Cache::cache_js_files($template_path . "js/");

        ob_start();

        // Incluir el archivo PHP del layout
        include $template_path . $layout . '.php';

        return ob_get_clean();
    }
}
