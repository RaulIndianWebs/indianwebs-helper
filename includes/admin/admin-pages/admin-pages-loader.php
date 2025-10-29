<?php
/**
 * Loader genérico para páginas de administración
 * Permite usarse desde cualquier ubicación (plugin, mu-plugin o theme)
 *
 * Ejemplos:
 *   new IW_Helper_Admin_Pages_Loader(); // Usa rutas por defecto del plugin
 *   new IW_Helper_Admin_Pages_Loader(WP_CONTENT_DIR . '/iw-helper/admin/'); // Ruta personalizada
 *   new IW_Helper_Admin_Pages_Loader(get_stylesheet_directory() . '/admin/'); // Desde un tema hijo
 */

class IW_Helper_Admin_Pages_Loader {

    private $base_dir;
    private $pages_dir;
    private $child_pages_dir;
    private $tabs_dir;

    /**
     * Constructor flexible
     * @param string|null $base_dir Ruta base opcional (debe contener subcarpetas pages/, child-pages/, tabs/)
     */
    public static function init($base_dir = null) {
        // Si no se pasa ruta, usar la del propio plugin
        self::$base_dir = rtrim($base_dir ?: get_plugin_dir(), '/') . '/';

        // Configurar directorios internos
        self::$pages_dir       = self::$base_dir . 'pages/';
        self::$child_pages_dir = self::$base_dir . 'child-pages/';
        self::$tabs_dir        = self::$base_dir . 'tabs/';

        // Enganchar registro de páginas
        add_action('admin_menu', [self, 'register_pages']);
    }

    /**
     * Registra todas las páginas principales y subpáginas
     */
    public static function register_pages() {
        // 1️⃣ Páginas principales
        foreach (self::get_php_files(self::$pages_dir) as $file) {
            self::register_page($file, true);
        }

        // 2️⃣ Subpáginas
        foreach (self::get_php_files(self::$child_pages_dir) as $file) {
            self::register_page($file, false);
        }
    }

    /**
     * Obtiene todos los archivos PHP de un directorio
     */
    private static function get_php_files($dir) {
        if (!is_dir($dir)) return [];
        return glob(trailingslashit($dir) . '*.php') ?: [];
    }

    /**
     * Registra una página o subpágina
     */
    private static function register_page($file, $is_main) {
        if (strpos(basename($file), 'sample') !== false) {
            return; // ignorar archivos de ejemplo
        }

        $headers = self::get_file_headers($file);

        if (empty($headers['Page Name']) || empty($headers['Menu Slug'])) {
            return;
        }

        // Callback del contenido
        $callback = static function() use ($file, $headers) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                array_walk_recursive($_POST, static function(&$item) {
                    if (is_string($item)) $item = stripslashes($item);
                });
            }

            // 1️⃣ Contenido principal
            include $file;

            // 2️⃣ Tabs (si existen)
            self::render_tabs($headers);
        };

        // Menú principal
        if ($is_main && empty($headers['Parent Slug'])) {
            $position = $headers['Position'] ?: null;

            add_menu_page(
                $headers['Page Name'],
                $headers['Menu Title'] ?? $headers['Page Name'],
                $headers['Capability'] ?? 'manage_options',
                $headers['Menu Slug'],
                $callback,
                $headers['Icon'] ?? '',
                $position
            );

            add_submenu_page(
                $headers['Menu Slug'],
                $headers['Page Name'],
                '',
                $headers['Capability'] ?? 'manage_options',
                $headers['Menu Slug'],
                $callback
            );

            if (!empty($headers['Redirect'])) {
                add_action('load-toplevel_page_' . $headers['Menu Slug'], static function() use ($headers) {
                    wp_redirect(admin_url('admin.php?page=' . $headers['Redirect']));
                    exit;
                });
            }
        } else {
            // Subpágina
            add_submenu_page(
                $headers['Parent Slug'],
                $headers['Page Name'],
                $headers['Menu Title'] ?? $headers['Page Name'],
                $headers['Capability'] ?? 'manage_options',
                $headers['Menu Slug'],
                $callback
            );
        }
    }

    /**
     * Renderiza las tabs si existen
     */
    private static function render_tabs($headers) {
        if (empty($headers['Tabs'])) return;

        $tabs = [];
        foreach (explode('|', $headers['Tabs']) as $tab_def) {
            [$slug, $title] = explode('=', $tab_def);
            $tabs[trim($slug)] = trim($title);
        }

        $current_tab = $_GET['tab'] ?? key($tabs);

        echo '<h2 class="nav-tab-wrapper">';
        foreach ($tabs as $slug => $title) {
            $active = $current_tab === $slug ? ' nav-tab-active' : '';
            $url = add_query_arg(['page' => $headers['Menu Slug'], 'tab' => $slug], admin_url('admin.php'));
            echo '<a href="' . esc_url($url) . '" class="nav-tab' . $active . '">' . esc_html($title) . '</a>';
        }
        echo '</h2>';

        // Archivo de la pestaña
        $tab_file = self::tabs_dir . $headers['Menu Slug'] . '/' . $current_tab . '.php';
        if (file_exists($tab_file)) {
            include $tab_file;
        } else {
            echo '<p><em>No existe el archivo de la pestaña: ' . esc_html($current_tab) . '</em></p>';
        }
    }

    /**
     * Extrae cabeceras personalizadas de cada archivo
     */
    private static function get_file_headers($file) {
        $default_headers = [
            'Page Name'   => 'Page Name',
            'Menu Title'  => 'Menu Title',
            'Capability'  => 'Capability',
            'Menu Slug'   => 'Menu Slug',
            'Parent Slug' => 'Parent Slug',
            'Position'    => 'Position',
            'Icon'        => 'Icon',
            'Redirect'    => 'Redirect',
            'Tabs'        => 'Tabs',
        ];
        return get_file_data($file, $default_headers);
    }
}

new IW_Helper_Admin_Pages_Loader();