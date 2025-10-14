<?php
echo '<form method="post">';
wp_nonce_field("iw_save");

$option_slug = 'company-legal-info';
$config = Iw_Helper_DB_Manager::options("get", $option_slug);


if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    check_admin_referer('iw_save')
) {
    $calle     = sanitize_text_field($_POST['legal_direccion_calle'] ?? '');
    $numero    = sanitize_text_field($_POST['legal_direccion_numero'] ?? '');
    $cp        = sanitize_text_field($_POST['legal_direccion_cp'] ?? '');
    $ciudad    = sanitize_text_field($_POST['legal_direccion_ciudad'] ?? '');
    $provincia = sanitize_text_field($_POST['legal_direccion_provincia'] ?? '');
    $pais      = sanitize_text_field($_POST['legal_pais'] ?? '');

    $direccion_formateada = trim("{$calle}, {$numero} - {$cp} {$ciudad} ({$provincia})");

    $config = [
        'site_url'  => sanitize_text_field($_POST['legal_site_url'] ?? ''),
        'site_name' => sanitize_text_field($_POST['legal_site_name'] ?? ''),
        'titular'   => sanitize_text_field($_POST['legal_titular'] ?? ''),
        'nif'       => sanitize_text_field($_POST['legal_nif'] ?? ''),
        'telefono'  => sanitize_text_field($_POST['legal_telefono'] ?? ''),
        'email'     => sanitize_email($_POST['legal_email'] ?? ''),
        'direccion' => $direccion_formateada,
        'direccion_calle'     => $calle,
        'direccion_numero'    => $numero,
        'direccion_cp'        => $cp,
        'direccion_ciudad'    => $ciudad,
        'direccion_provincia' => $provincia,
        'pais'      => $pais,

        // --- NUEVOS CAMPOS SECCIÓN TIENDA ONLINE ---
        'descripcion_productos'   => sanitize_textarea_field($_POST['descripcion_productos'] ?? ''),
        'texto_boton_compra'      => sanitize_text_field($_POST['texto_boton_compra'] ?? ''),
        'envio'                   => sanitize_text_field($_POST['envio'] ?? ''),
        'formulario_devoluciones' => esc_url_raw($_POST['formulario_devoluciones'] ?? ''),
    ];

    Iw_Helper_DB_Manager::options("save", $option_slug, $config);

    echo '<div class="updated"><p>Información de empresa guardada correctamente.</p></div>';
}

// Ahora usamos los datos guardados (o los vacíos si no hay guardado)
$legal = $config ?? [];
echo '<h2>Shortcode</h2>';
echo '<p>Utiliza el shortcode [iw-textos-legales] para mostrar los textos legales.</p>';
echo '<p>El shortcode tiene el atributo "contenido" que permite indicar que texto mostrar</p>';
echo '<ul>';
echo '<li>[iw-textos-legales contenido="aviso-legal"]</li>';
echo '<li>[iw-textos-legales contenido="privacidad"]</li>';
echo '<li>[iw-textos-legales contenido="cookies"]</li>';
echo '<li>[iw-textos-legales contenido="accesibilidad"]</li>';
echo '<li>[iw-textos-legales contenido="condiciones-venta"]</li>';
echo '</ul>';

echo '<h2>Datos Legales</h2>';
echo '<table class="form-table">
    <tr><th scope="row">URL del sitio</th><td><input type="url" name="legal_site_url" value="' . esc_attr($legal['site_url'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">Nombre del sitio</th><td><input type="text" name="legal_site_name" value="' . esc_attr($legal['site_name'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">Titular</th><td><input type="text" name="legal_titular" value="' . esc_attr($legal['titular'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">NIF</th><td><input type="text" name="legal_nif" value="' . esc_attr($legal['nif'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">Teléfono</th><td><input type="text" name="legal_telefono" value="' . esc_attr($legal['telefono'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">Email</th><td><input type="email" name="legal_email" value="' . esc_attr($legal['email'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th colspan="2"><h3 style="margin-top:2em;">Dirección</h3></th></tr>
    <tr><th scope="row">Calle</th><td><input type="text" name="legal_direccion_calle" value="' . esc_attr($legal['direccion_calle'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">Número</th><td><input type="text" name="legal_direccion_numero" value="' . esc_attr($legal['direccion_numero'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">Código Postal</th><td><input type="text" name="legal_direccion_cp" value="' . esc_attr($legal['direccion_cp'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">Ciudad</th><td><input type="text" name="legal_direccion_ciudad" value="' . esc_attr($legal['direccion_ciudad'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">Provincia</th><td><input type="text" name="legal_direccion_provincia" value="' . esc_attr($legal['direccion_provincia'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">País</th><td><input type="text" name="legal_pais" value="' . esc_attr($legal['pais'] ?? '') . '" class="regular-text" /></td></tr>
</table>';

// --- SECCIÓN TIENDA ONLINE ---
echo '<h2>Tienda Online</h2>';
echo '<table class="form-table">
    <tr><th scope="row">Descripción de productos</th><td><textarea name="descripcion_productos" class="large-text" rows="5">' . esc_textarea($legal['descripcion_productos'] ?? '') . '</textarea></td></tr>
    <tr><th scope="row">Texto botón de compra</th><td><input type="text" name="texto_boton_compra" value="' . esc_attr($legal['texto_boton_compra'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">Envío</th><td><input type="text" name="envio" value="' . esc_attr($legal['envio'] ?? '') . '" class="regular-text" /></td></tr>
    <tr><th scope="row">Formulario de devoluciones (URL)</th><td><input type="url" name="formulario_devoluciones" value="' . esc_attr($legal['formulario_devoluciones'] ?? '') . '" class="regular-text" /></td></tr>
</table>';

submit_button('Guardar configuración');
echo '</form>';
