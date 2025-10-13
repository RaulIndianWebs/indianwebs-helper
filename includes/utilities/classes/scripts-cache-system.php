<?php
class IW_Scripts_Cache {
    private static $transients = [
        "css" => [],
        "js"  => [],
    ];

    /**
     * Cachea archivos CSS desde una ruta (archivo o carpeta).
     *
     * @param string $path
     */
    public static function cache_css_files($path) {
        add_action('init', function() use ($path) {
            self::cache_files($path, 'css');
        });
    }

    /**
     * Cachea archivos JS desde una ruta (archivo o carpeta).
     *
     * @param string $path
     */
    public static function cache_js_files($path) {
        add_action('init', function() use ($path) {
            self::cache_files($path, 'js');
        });
    }

    public static function print_cached_css() {
        self::print_cached_files('css');
    }

    public static function print_cached_js() {
        self::print_cached_files('js');
    }

    /* ================== PRIVADOS ================== */

    private static function cache_files($path, $type) {
        $is_admin = (function_exists('current_user_can') && current_user_can('manage_options'));

        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    self::cache_files($path . '/' . $file, $type);
                }
            }
        } elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === $type) {
            $file_url = content_url(str_replace(WP_CONTENT_DIR, '', $path));
            $file_content = file_get_contents($path);
            $file_hash = md5($file_content);
            $transient_name = 'iw-cache-' . $type . '_' . md5($file_url);

            $cached = get_transient($transient_name);

            // Solo el admin fuerza comprobación del hash
            if (!$cached || ($is_admin && (!isset($cached['hash']) || $cached['hash'] !== $file_hash))) {
                set_transient($transient_name, [
                    'content' => $file_content,
                    'hash'    => $file_hash
                ], 7 * DAY_IN_SECONDS);
            }

            if (!in_array($transient_name, self::$transients[$type], true)) {
                self::$transients[$type][] = $transient_name;
            }
        }
    }

    private static function print_cached_files($type) {
        $transients = self::$transients[$type];

        if (!empty($transients)) {
            if ($type == 'css') {
                echo "<style>\n";
            } elseif ($type == 'js') {
                echo "<script>\n";
            }

            foreach ($transients as $transient_name) {
                $cached = get_transient($transient_name);
                if ($cached && isset($cached['content'])) {
                    echo $cached['content'] . "\n";
                }
            }

            if ($type == 'css') {
                echo "</style>\n";
            } elseif ($type == 'js') {
                echo "</script>\n";
            }
        }
    }
}
