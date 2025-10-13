<?php
echo '<form method="post">';
wp_nonce_field("iw_save");

$config = getHelperOptions('helper-config');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_admin_referer("iw_save")) {
    $new_config = [
        'features-options' => [
            'off-canva-options' => [
                'active' => isset($_POST['off_canva_active']),
                'secondary-menu' => isset($_POST['off_canva_secondary_menu']),
                'fast-actions' => isset($_POST['off_canva_fast_actions']),
            ],
            'to-top-link' => [
                'active' => isset($_POST['to_top_link_active']),
            ]
        ]
    ];
    saveHelperOptions('helper-config', $new_config);
    $config = $new_config;
    echo '<div class="updated"><p>Configuración guardada correctamente.</p></div>';
}

$off_canva = $config['features-options']['off-canva-options'] ?? [];
$to_top = $config['features-options']['to-top-link'] ?? [];

echo '<h2>Opciones Off Canva</h2>';
echo '<table class="form-table">
    <tr>
        <th scope="row">Activar Off Canva</th>
        <td><input type="checkbox" name="off_canva_active" ' . checked($off_canva['active'] ?? false, true, false) . ' /></td>
        <td rowspan="3" class="off-canva-aside">
            <strong>Clases CSS:</strong><br>
            .iw-offcanvas-menu-close<br>
            .iw-offcanvas-menu-open<br>
            .iw-offcanvas-menu-toggle
        </td>
    </tr>
    <tr>
        <th scope="row">Mostrar Menú Secundario</th>
        <td><input type="checkbox" name="off_canva_secondary_menu" ' . checked($off_canva['secondary-menu'] ?? false, true, false) . ' /></td>
    </tr>
    <tr>
        <th scope="row">Acciones Rápidas</th>
        <td><input type="checkbox" name="off_canva_fast_actions" ' . checked($off_canva['fast-actions'] ?? false, true, false) . ' /></td>
    </tr>
</table>

<style>
    .form-table {
        width: 90%;
    }
    .off-canva-aside {
        background: #f5f5f5; /* gris claro */
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 12px 16px;
        font-size: 13px;
        line-height: 1.5;
        color: #333;
        width: 220px; /* más estrecho */
        vertical-align: top;
        text-align: left;
    }
    .off-canva-aside strong {
        display: block;
        margin-bottom: 6px;
        color: #111;
    }
</style>';


echo '<h2>Enlace "Volver arriba"</h2>';
echo '<table class="form-table">
    <tr><th scope="row">Activar Enlace</th><td><input type="checkbox" name="to_top_link_active" ' . checked($to_top['active'] ?? false, true, false) . ' /></td></tr>
</table>';

submit_button('Guardar configuración');
echo '</form>';