<?php
namespace IW_Helper\Admin;

/**
 * Loader genérico para páginas de administración
 * Permite usarse desde cualquier ubicación (plugin, mu-plugin o theme)
 *
 * Ejemplos:
 *   new IW_Helper_Admin_Pages_Loader(); // Usa rutas por defecto del plugin
 *   new IW_Helper_Admin_Pages_Loader(WP_CONTENT_DIR . '/iw-helper/admin/'); // Ruta personalizada
 *   new IW_Helper_Admin_Pages_Loader(get_stylesheet_directory() . '/admin/'); // Desde un tema hijo
 */

class IW_Helper_Custom_Admin_Pages_Loader {

    private static array $base_dir;

    public static function add_dir($base_dir) {
        self::$base_dir[] = rtrim($base_dir, '/') . '/';
    }

    /**
     * Constructor flexible
     * @param string|null $base_dir Ruta base opcional (debe contener subcarpetas pages/, child-pages/, tabs/)
     */
    public static function init() {
        add_action('admin_menu', [self::class, 'register_pages']);
    }

    /**
     * Registra todas las páginas principales y subpáginas
     */
    public static function register_pages() {
        foreach (self::$base_dir as $dir) {
            // Configurar directorios internos
            $pages_dir       = $dir . 'pages/';
            $child_pages_dir = $dir . 'child-pages/';
            $tabs_dir        = $dir . 'tabs/';


            // 1️⃣ Páginas principales
            foreach (self::get_php_files($pages_dir) as $file) {
                self::register_page($file, true, $tabs_dir);
            }

            // 2️⃣ Subpáginas
            foreach (self::get_php_files($child_pages_dir) as $file) {
                self::register_page($file, false, $tabs_dir);
            }
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
    private static function register_page($file, $is_main, $tabs_dir) {
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
            self::render_tabs($headers, $tabs_dir);
        };

        // Menú principal
        if ($is_main && empty($headers['Parent Slug'])) {
            $position = $headers['Position'] ?: null;

            \Iw_Admin_Page_Manager::add_page(
                $headers['Page Name'],
                $headers['Menu Title'] ?? $headers['Page Name'],
                $headers['Capability'] ?? 'manage_options',
                $headers['Menu Slug'],
                $callback,
                $headers['Icon'] ?? '',
                $position
            );

            \Iw_Admin_Page_Manager::add_subpage(
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
            \Iw_Admin_Page_Manager::add_subpage(
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
    private static function render_tabs($headers, $tabs_dir) {
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
        $tab_file = $tabs_dir . $headers['Menu Slug'] . '/' . $current_tab . '.php';
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