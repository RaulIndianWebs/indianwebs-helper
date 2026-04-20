<?php
$dev_tools = getPluginOptions("developer-tools");
$dev_tools = is_array($dev_tools) ? $dev_tools : [];

if (!empty($dev_tools['wp-debug'])) {
    error_reporting(E_ALL);
}

if (!empty($dev_tools['wp-debug-display'])) {
    @ini_set('display_errors', 1);
} else {
    @ini_set('display_errors', 0);
}

if (!empty($dev_tools['wp-debug-log'])) {
    @ini_set('log_errors', 1);
    if (defined('WP_CONTENT_DIR')) {
        @ini_set('error_log', WP_CONTENT_DIR . '/debug.log');
    }
} else {
    @ini_set('log_errors', 0);
}









add_action('admin_post_toggle_dev_tool', function() {

    // Solo admins
    if (!current_user_can('manage_options')) {
        wp_die('No tienes permisos');
    }

    // Verificar nonce
    if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'iw_toggle_dev_tool')) {
        wp_die('Acceso no autorizado');
    }

    $tool = $_GET['tool'] ?? '';
    $valid_tools = ['wp-debug', 'wp-debug-display', 'wp-debug-log'];
    if (!in_array($tool, $valid_tools, true)) {
        wp_die('Herramienta inválida');
    }

    // Cargar configuración actual
    $dev_tools = getPluginOptions('developer-tools');
    $dev_tools = is_array($dev_tools) ? $dev_tools : [];

    // Alternar valor
    $dev_tools[$tool] = !empty($dev_tools[$tool]) ? 0 : 1;

    // Guardar
    savePluginOptions('developer-tools', $dev_tools);

    // Redirigir de vuelta al admin
    $redirect = wp_get_referer() ?: admin_url();
    wp_safe_redirect($redirect);
    exit;
});









add_action('admin_bar_menu', function($wp_admin_bar) {

    if (!current_user_can('manage_options')) {
        return;
    }

    $dev_tools = getPluginOptions('developer-tools');
    $dev_tools = is_array($dev_tools) ? $dev_tools : [];

    // Menú padre
    $wp_admin_bar->add_node([
        'id'    => 'iw-dev-tools',
        'title' => 'Developer Tools',
        'href'  => false,
        'meta'  => ['class' => 'iw-dev-tools']
    ]);

    $options = [
        'wp-debug'         => 'WP_DEBUG',
        'wp-debug-display' => 'WP_DEBUG_DISPLAY',
        'wp-debug-log'     => 'WP_DEBUG_LOG',
    ];

    foreach ($options as $key => $label) {

        $is_on = !empty($dev_tools[$key]);
        $status_text = $is_on ? 'ON' : 'OFF';
        $color = $is_on ? 'green' : 'red';

        $url = admin_url('admin-post.php?action=toggle_dev_tool&tool=' . $key . '&_wpnonce=' . wp_create_nonce('iw_toggle_dev_tool'));

        // Se permite HTML en title
        $wp_admin_bar->add_node([
            'id'     => 'iw-dev-tools-' . $key,
            'parent' => 'iw-dev-tools',
            'title'  => "{$label}: <span style='color: {$color}; font-weight: bold;'>{$status_text}</span>",
            'href'   => $url,
        ]);
    }

}, 100);