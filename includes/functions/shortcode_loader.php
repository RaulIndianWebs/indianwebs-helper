<?php
function load_custom_shortcodes($dir) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $file_path = $file->getRealPath();
            $file_name = $file->getBasename('.php');

            add_shortcode('iw-' . $file_name, function($atts = [], $content = null) use ($file_path) {
                return include $file_path;
            });
            IW_Scripts_Cache::cache_css_files(get_plugin_directory() . "assets/css/shortcodes/".$file_name.".css");
            IW_Scripts_Cache::cache_js_files(get_plugin_directory() . "assets/js/shortcodes/".$file_name.".js");
        }
    }
}
