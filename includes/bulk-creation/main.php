<?php
add_action('admin_menu', function () {
    add_menu_page(
        'Bulk Creation',
        'Bulk Creation',
        'manage_options',
        'bulk-creation',
        'bulk_creation_page',
        'dashicons-edit',
        20
    );
});
function bulk_creation_page() {
    echo '<div class="wrap">';
    echo '<h1>Bulk Creation</h1>';
    echo '<p>Bienvenido a la sección de creación masiva.</p>';
    echo '</div>';
}



// Llamada a los codigos de cada post type
iw_recursive_file_search(get_plugin_directory().'includes/bulk-creation/post-type', function($ruta, $archivo) {
    if (!is_file(get_custom_helper_directory().'/includes/bulk-creation/post-type/'.$archivo)) {
        require_once $ruta;
    }
}, "*.php");

include_php_files(get_custom_helper_directory() . '/includes/bulk-creation/post-type/');