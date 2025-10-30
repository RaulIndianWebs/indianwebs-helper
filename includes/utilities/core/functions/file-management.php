<?php
if (!function_exists("enqueue_css_files")) {
    /**
     * Encola archivos CSS desde cualquier ruta del sistema, incluyendo subdirectorios.
     *
     * @param string $path Ruta absoluta al archivo o carpeta.
     */
    function enqueue_css_files($path) {
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    enqueue_css_files($path . '/' . $file);
                }
            }
        } 
        elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'css') {
            $handle = 'custom-css-' . md5($path);
            $version = filemtime($path);

            $css_url = content_url(str_replace(WP_CONTENT_DIR, '', $path));
            wp_enqueue_style($handle, $css_url, array(), $version);
        }
    }

}


if (!function_exists("enqueue_js_files")) {
    /**
     * Encola archivos JS desde cualquier ruta del sistema, incluyendo subdirectorios.
     *
     * @param string $path Ruta absoluta al archivo o carpeta.
     */
    function enqueue_js_files($path) {
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    enqueue_js_files($path . '/' . $file);
                }
            }
        }
        elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'js') {
            $handle = 'custom-js-' . md5($path);
            $version = filemtime($path);

            $js_url = content_url(str_replace(WP_CONTENT_DIR, '', $path));
            wp_enqueue_script($handle, $js_url, array(), $version, true);
        }
    }
}



if (!function_exists("include_php_files")) {
    /**
     * Incluye todos los archivos PHP de una carpeta (y sus subcarpetas).
     *
     * @param string $path Ruta absoluta al archivo o carpeta.
     */
    function include_php_files($path) {
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    include_php_files($path . '/' . $file);
                }
            }
        }
        elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            include_once $path;
        }
    }
}

