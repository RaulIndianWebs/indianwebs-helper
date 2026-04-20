<?php
/**
	Back Features
*/
// Load Cookie Manager
include_php_files(get_plugin_directory() . 'includes/cookies-manager/');



/**
	Front Features
*/
add_action('wp_head', function() {

    // Detectar si Divi está activo
    if (defined('ET_BUILDER_VERSION')) {
        $divi_options = get_option('et_divi');

        $primary   = isset($divi_options['accent_color']) ? sanitize_hex_color($divi_options['accent_color']) : '#003e91';
        $secondary = isset($divi_options['secondary_accent_color']) ? sanitize_hex_color($divi_options['secondary_accent_color']) : '#ccc';
        $featured  = isset($divi_options['accent_color']) ? sanitize_hex_color($divi_options['accent_color']) : '#003e91';
    } else {
        $primary   = '#003e91';
        $secondary = '#ccc';
        $featured  = '#003e91';
    }

    // Botones: esquema Primary / Blanco
    $btn_text       = '#ffffff';
    $btn_bg         = $primary;
    $btn_border     = $primary;
    $btn_text_hover = $primary;
    $btn_bg_hover   = '#ffffff';
    $btn_border_hover = $primary;

    // Crear CSS de variables
    echo "<style>
    :root {
        /* Colores generales */
        --iw-general-color-primary: {$primary};
        --iw-general-color-secondary: {$secondary};
        --iw-general-color-featured: {$featured};

        /* Botones */
        --iw-button-text: {$btn_text};
        --iw-button-bg: {$btn_bg};
        --iw-button-border: {$btn_border};
        --iw-button-text-hover: {$btn_text_hover};
        --iw-button-bg-hover: {$btn_bg_hover};
        --iw-button-border-hover: {$btn_border_hover};
    }
    </style>";
});






// Load off-canva-menu
include_php_files(get_plugin_directory() . 'includes/off-canva-menu/');

// Load to top link
include_php_files(get_plugin_directory() . 'includes/to-top-link/');

// Load loading page
include_php_files(get_plugin_directory() . 'includes/loading-page/');

// Add plugin shortcodes
load_custom_shortcodes(get_plugin_directory() . 'includes/shortcodes/');

// Load admin pages
include_php_files(get_plugin_directory() . 'includes/admin/admin-pages-loader.php');

// Load CSS Variables
IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/css-variables.css');

// Load overrides
IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/divi-overides/');
IW_Scripts_Cache::cache_js_files(get_plugin_directory() . 'assets/js/divi-overides/');
IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/overides/');
IW_Scripts_Cache::cache_js_files(get_plugin_directory() . 'assets/js/overides/');

// Load CSS presets
IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/presets/');
IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/divi-presets/');


// Load developer tools
include_php_files(get_plugin_directory() . 'includes/developer-tools/');



