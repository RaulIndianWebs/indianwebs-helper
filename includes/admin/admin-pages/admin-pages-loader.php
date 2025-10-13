<?php
/**
 * Loader mejorado para páginas de administración del plugin IW Helper
 */

class IW_Helper_Admin_Pages_Loader {

    private $pages_dir;
    private $child_pages_dir;
    private $tabs_dir;

    public function __construct() {
        $this->pages_dir       = plugin_dir_path(__FILE__) . 'pages/';
        $this->child_pages_dir = plugin_dir_path(__FILE__) . 'child-pages/';
        $this->tabs_dir        = plugin_dir_path(__FILE__) . 'tabs/';
        add_action('admin_menu', [$this, 'register_pages']);
    }

    /**
     * Registra todas las páginas principales y luego los submenús
     */
    public function register_pages() {

        // 1️⃣ Registrar menús principales (desde plugin)
        foreach (glob($this->pages_dir . '*.php') as $file) {
            $this->register_page($file, true);
        }

        // 2️⃣ Registrar subpáginas (desde plugin)
        foreach (glob($this->child_pages_dir . '*.php') as $file) {
            $this->register_page($file, false);
        }

        // 3️⃣ Registrar menús principales (desde theme/child-theme)
        foreach (glob(get_stylesheet_directory() . '/iw-helper/admin/pages/*.php') as $file) {
            $this->register_page($file, true);
        }

        // 4️⃣ Registrar subpáginas (desde theme/child-theme)
        foreach (glob(get_stylesheet_directory() . '/iw-helper/admin/child-pages/*.php') as $file) {
            $this->register_page($file, false);
        }
    }

    /**
     * Registro de página o subpágina
     */
    private function register_page($file, $is_main) {

        // Ignorar archivos sample
        if (strpos(basename($file), 'sample') !== false) {
            return;
        }

        $headers = $this->get_file_headers($file);

        // Deben tener Page Name y Menu Slug
        if (empty($headers['Page Name']) || empty($headers['Menu Slug'])) {
            return;
        }

        // Callback que incluye primero contenido principal y luego tabs si existen
        $callback = function() use ($file, $headers) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                array_walk_recursive($_POST, function(&$item, $key) {
                    if (is_string($item)) {
                        $item = stripslashes($item);
                    }
                });
            }
            // 1️⃣ Incluir contenido principal de la página
            include $file;

            // 2️⃣ Procesar tabs si existen
            $tabs = [];
            if (!empty($headers['Tabs'])) {
                foreach (explode('|', $headers['Tabs']) as $tab_def) {
                    [$slug, $title] = explode('=', $tab_def);
                    $tabs[trim($slug)] = trim($title);
                }
            }

            if ($tabs) {
                $current_tab = $_GET['tab'] ?? key($tabs);

                // Mostrar barra de tabs
                echo '<h2 class="nav-tab-wrapper">';
                foreach ($tabs as $slug => $title) {
                    $active = $current_tab === $slug ? ' nav-tab-active' : '';
                    $url = add_query_arg(['page' => $headers['Menu Slug'], 'tab' => $slug], admin_url('admin.php'));
                    echo '<a href="' . esc_url($url) . '" class="nav-tab' . $active . '">' . esc_html($title) . '</a>';
                }
                echo '</h2>';

                // 🔥 Nueva forma de localizar el archivo de la tab
                $tab_file = $this->tabs_dir . $headers['Menu Slug'] . '/' . $current_tab . '.php';

                if (file_exists($tab_file)) {
                    include $tab_file;
                } else {
                    echo '<p><em>No existe el archivo de la pestaña: ' . esc_html($current_tab) . '</em></p>';
                }
            }
        };


        if ($is_main && empty($headers['Parent Slug'])) {
            $position = 0;
            if (isset($headers['Position']) && $headers['Position'] != "") {
                $position = $headers['Position'];
            }
            else {
                $position = null;
            }

            // Menú principal
            add_menu_page(
                $headers['Page Name'],
                $headers['Menu Title'] ?? $headers['Page Name'],
                $headers['Capability'] ?? 'manage_options',
                $headers['Menu Slug'],
                $callback,
                $headers['Icon'] ?? '',
                $position
            );

            // Submenú obligatorio para evitar redirección automática de WP
            add_submenu_page(
                $headers['Menu Slug'],
                $headers['Page Name'],
                '',
                $headers['Capability'] ?? 'manage_options',
                $headers['Menu Slug'],
                $callback
            );

            // Redirección automática si se indica en headers
            if (!empty($headers['Redirect'])) {
                add_action('load-toplevel_page_' . $headers['Menu Slug'], function() use ($headers) {
                    wp_redirect(admin_url('admin.php?page=' . $headers['Redirect']));
                    exit;
                });
            }

        } else {
            // Subpágina normal
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
     * Extrae cabeceras personalizadas de cada archivo
     */
    private function get_file_headers($file) {
        $default_headers = [
            'Page Name'   => 'Page Name',
            'Menu Title'  => 'Menu Title',
            'Capability'  => 'Capability',
            'Menu Slug'   => 'Menu Slug',
            'Parent Slug' => 'Parent Slug',
            'Position'    => 'Position',
            'Icon'        => 'Icon',
            'Redirect'    => 'Redirect',
            'Tabs'        => 'Tabs', // cabecera de tabs
        ];  

        return get_file_data($file, $default_headers);
    }
}




// Inicializar loader del plugin IW Helper
new IW_Helper_Admin_Pages_Loader();

