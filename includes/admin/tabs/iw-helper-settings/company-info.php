<?php
echo '<form method="post">';
wp_nonce_field("iw_save");

$option_slug = 'company-front-info';

// Guardar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_admin_referer("iw_save")) {
    if (isset($_POST['company_info']) && is_array($_POST['company_info'])) {
        $new_config = [];

        foreach ($_POST['company_info'] as $section => $data) {
            $section_label = sanitize_text_field($data['label'] ?? '');
            $new_config[$section]['label'] = $section_label;
            $new_config[$section]['content'] = [];

            if (isset($data['content']) && is_array($data['content'])) {
                foreach ($data['content'] as $content_item) {
                    $label = trim($content_item['label'] ?? '');
                    if ($label === '') continue; // Ignorar items vacíos

                    $new_config[$section]['content'][] = [
                        'label' => $label,
                        'href' => sanitize_text_field($content_item['href'] ?? ''),
                        'icon-class' => sanitize_text_field($content_item['icon-class'] ?? ''),
                    ];
                }
            }

            // Si no hay contenido válido, no guardar esta sección
            if (empty($new_config[$section]['content'])) {
                unset($new_config[$section]);
            }
        }

        savePluginOptions($option_slug, $new_config);
        echo '<div class="updated"><p>Configuración guardada correctamente.</p></div>';
    }
}

echo '<h3>Shortcode</h3>';
echo '<p>Para mostrar esta información en el front end se puede utilizar el shortcode [iw-display-contact-info].</p><br>';

$config = getPluginOptions($option_slug);
$sections = [
    'email'   => 'Correo electrónico',
    'phone'   => 'Teléfono',
    'address' => 'Dirección',
];

foreach ($sections as $key => $section_label) {
    $section_data = $config[$key] ?? [];
    $section_data['label'] = $section_data['label'] ?? $section_label;

    $content = $section_data['content'] ?? [];
    if (!is_array($content)) $content = [];

    // Añadir campo vacío adicional solo para el formulario
    $content[] = ['label' => '', 'href' => '', 'icon-class' => ''];

    echo '<h2>' . esc_html($section_label) . '</h2>';
    ?>
    <table class="form-table">
        <tr>
            <th scope="row"><label>Etiqueta</label></th>
            <td>
                <input type="text" name="company_info[<?php echo esc_attr($key); ?>][label]"
                       value="<?php echo esc_attr($section_data['label']); ?>" class="regular-text" />
            </td>
        </tr>
        <?php foreach ($content as $i => $item): ?>
            <tr>
                <th scope="row">Contenido #<?php echo $i + 1; ?></th>
                <td>
                    <label>Label:<br>
                        <input type="text" name="company_info[<?php echo esc_attr($key); ?>][content][<?php echo $i; ?>][label]"
                               value="<?php echo esc_attr($item['label'] ?? ''); ?>" class="regular-text" />
                    </label><br><br>
                    <label>Href:<br>
                        <input type="text" name="company_info[<?php echo esc_attr($key); ?>][content][<?php echo $i; ?>][href]"
                               value="<?php echo esc_attr($item['href'] ?? ''); ?>" class="regular-text" />
                    </label><br><br>
                    <label>Icon class:<br>
                        <input type="text" name="company_info[<?php echo esc_attr($key); ?>][content][<?php echo $i; ?>][icon-class]"
                               value="<?php echo esc_attr($item['icon-class'] ?? ''); ?>" class="regular-text" />
                    </label>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <hr>
<?php }

submit_button('Guardar configuración');
echo '</form>';
