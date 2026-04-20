<?php
/*
Page Name: Configurar WordPress
Menu Title: Configurar WordPress
Capability: manage_options
Menu Slug: iw-wordpress-config
Parent Slug: iw-helper-main
*/

echo '<div class="wrap">';
echo '<h1>Configurar WordPress</h1>';

$option_slug = 'wordpress-config';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'iw_save_config')) {
        wp_die('Acceso no autorizado');
    }

    $new_config = [
        'disable_comments'        => isset($_POST['disable_comments']) ? 1 : 0,
        'disable_divi_cpt'        => isset($_POST['disable_divi_cpt']) ? 1 : 0,
        'enable_image_meta'       => isset($_POST['enable_image_meta']) ? 1 : 0,
        'disable_core_updates'    => isset($_POST['disable_core_updates']) ? 1 : 0,
        'disable_plugin_updates'  => isset($_POST['disable_plugin_updates']) ? 1 : 0,
        'disable_theme_updates'   => isset($_POST['disable_theme_updates']) ? 1 : 0,
        'disable_default_themes'  => isset($_POST['disable_default_themes']) ? 1 : 0,
        'disable_security_options'  => isset($_POST['disable_security_options']) ? 1 : 0,
        'disable_translation_updates'  => isset($_POST['disable_translation_updates']) ? 1 : 0,
    ];

    savePluginOptions($option_slug, $new_config);

    echo '<div class="updated"><p>Configuración guardada correctamente.</p></div>';
}

$config = getPluginOptions($option_slug);
$config = is_array($config) ? $config : [];

wp_nonce_field('iw_save_config');
?>

<form method="post">
    <?php wp_nonce_field('iw_save_config'); ?>

    <table class="form-table">

        <tr>
            <th scope="row">Desactivar comentarios</th>
            <td>
                <label>
                    <input type="checkbox" name="disable_comments" value="1"
                        <?php checked($config['disable_comments'] ?? 0, 1); ?>>
                    Deshabilitar completamente los comentarios en el sitio
                </label>
            </td>
        </tr>

        <tr>
            <th scope="row">Desactivar CPT de Divi</th>
            <td>
                <label>
                    <input type="checkbox" name="disable_divi_cpt" value="1"
                        <?php checked($config['disable_divi_cpt'] ?? 0, 1); ?>>
                    Eliminar Custom Post Types creados por Divi
                </label>
            </td>
        </tr>

        <tr>
            <th scope="row">Compatibilidad meta en imágenes</th>
            <td>
                <label>
                    <input type="checkbox" name="enable_image_meta" value="1"
                        <?php checked($config['enable_image_meta'] ?? 0, 1); ?>>
                    Habilitar campos meta personalizados para imágenes
                </label>
            </td>
        </tr>

        <tr>
            <th scope="row"><strong>Actualizaciones</strong></th>
            <td>
                <label>
                    <input type="checkbox" name="disable_core_updates" value="1"
                        <?php checked($config['disable_core_updates'] ?? 0, 1); ?>>
                    Desactivar actualizaciones del core
                </label>
                <br><br>

                <label>
                    <input type="checkbox" name="disable_plugin_updates" value="1"
                        <?php checked($config['disable_plugin_updates'] ?? 0, 1); ?>>
                    Desactivar actualizaciones de plugins
                </label>
                <br><br>

                <label>
                    <input type="checkbox" name="disable_theme_updates" value="1"
                        <?php checked($config['disable_theme_updates'] ?? 0, 1); ?>>
                    Desactivar actualizaciones de temas
                </label>
                <br><br>

                <label>
                    <input type="checkbox" name="disable_default_themes" value="1"
                        <?php checked($config['disable_default_themes'] ?? 0, 1); ?>>
                    Bloquear descarga automática de themes por defecto
                </label>
                <br><br>

                <label>
                    <input type="checkbox" name="disable_security_options" value="1"
                        <?php checked($config['disable_security_options'] ?? 0, 1); ?>>
                    Bloquear descarga automática de actualizaciones críticas
                </label>
                <br><br>

                <label>
                    <input type="checkbox" name="disable_security_options" value="1"
                        <?php checked($config['disable_security_options'] ?? 0, 1); ?>>
                    Bloquear descarga automática de traducciones
                </label>
            </td>
        </tr>

    </table>

    <?php submit_button('Guardar configuración'); ?>
</form>

<?php
echo '</div>';