<?php
/*
Page Name: Herramientas de desarrollador
Menu Title: Herramientas de desarrollador
Capability: manage_options
Menu Slug: iw-developer-tools
Parent Slug: iw-helper-main
*/

echo '<div class="wrap">';
echo '<h1>Herramientas de desarrollador</h1>';

$option_slug = 'developer-tools';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {

    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'iw_save_config')) {
        wp_die('Acceso no autorizado');
    }

    $new_config = [
        'wp-debug'           => isset($_POST['wp-debug']) ? 1 : 0,
        'wp-debug-display'   => isset($_POST['wp-debug-display']) ? 1 : 0,
        'wp-debug-log'       => isset($_POST['wp-debug-log']) ? 1 : 0,
    ];

    savePluginOptions($option_slug, $new_config);

    echo '<div class="updated"><p>Configuración guardada correctamente.</p></div>';
}

$config = getPluginOptions($option_slug);
$config = is_array($config) ? $config : [];

?>

<form method="post">
    <?php wp_nonce_field('iw_save_config'); ?>

    <table class="form-table">

        <tr>
            <th scope="row">Activar WP_DEBUG</th>
            <td>
                <label>
                    <input type="checkbox" name="wp-debug" value="1"
                        <?php checked($config['wp-debug'] ?? 0, 1); ?>>
                </label>
            </td>
        </tr>

        <tr>
            <th scope="row">Activar WP_DEBUG_DISPLAY</th>
            <td>
                <label>
                    <input type="checkbox" name="wp-debug-display" value="1"
                        <?php checked($config['wp-debug-display'] ?? 0, 1); ?>>
                    requiere display_errors en algunos casos
                </label>
            </td>
        </tr>

        <tr>
            <th scope="row">Activar WP_DEBUG_LOG</th>
            <td>
                <label>
                    <input type="checkbox" name="wp-debug-log" value="1"
                        <?php checked($config['wp-debug-log'] ?? 0, 1); ?>>
                    El log está en /wp-content/debug.log
                </label>
            </td>
        </tr>
    </table>

    <?php submit_button('Guardar configuración'); ?>
</form>

<?php
echo '</div>';