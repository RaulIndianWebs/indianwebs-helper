<?php
echo '<form method="post">';
wp_nonce_field("iw_save");

$option_slug = 'integration-config';

// Obtener configuración completa actual
$current_config = getPluginOptions($option_slug) ?: [];

// Guardar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_admin_referer("iw_save")) {
    if (isset($_POST['woocommerce']) && is_array($_POST['woocommerce'])) {
        $new_woocommerce = [];

        foreach ($_POST['woocommerce'] as $section => $section_data) {
            $new_woocommerce[$section] = [];

            foreach ($section_data as $subsection => $subdata) {
                $new_woocommerce[$section][$subsection] = [];

                foreach ($subdata as $key => $value) {
                    // Sanitizar según tipo
                    if (in_array($key, ['paginate', 'add-to-cart'])) {
                        $new_woocommerce[$section][$subsection][$key] = isset($value) && $value === '1' ? true : false;
                    } elseif ($key === 'limit') {
                        $new_woocommerce[$section][$subsection][$key] = intval($value);
                    } else {
                        $new_woocommerce[$section][$subsection][$key] = sanitize_text_field($value);
                    }
                }
            }
        }

        // Mantener lo que ya existía en otras secciones
        $current_config['woocommerce'] = $new_woocommerce;

        savePluginOptions($option_slug, $current_config);
        echo '<div class="updated"><p>Configuración guardada correctamente.</p></div>';
    }
}

// Obtener configuración actual de WooCommerce
$config = $current_config['woocommerce'] ?? [];

?>
<table class="form-table">
<?php foreach ($config['shortcodes-options'] ?? [] as $shortcode => $data): ?>
    <tr>
        <th colspan="2"><h4><?php echo esc_html(ucwords(str_replace('-', ' ', $shortcode))); ?></h4></th>
    </tr>
    <tr>
        <th scope="row"><label>Template</label></th>
        <td>
            <input type="text" name="woocommerce[shortcodes-options][<?php echo esc_attr($shortcode); ?>][template]"
                   value="<?php echo esc_attr($data['template'] ?? ''); ?>" class="regular-text" />
        </td>
    </tr>
    <?php if (isset($data['add-to-cart'])): ?>
    <tr>
        <th scope="row"><label>Add to Cart</label></th>
        <td>
            <input type="checkbox" name="woocommerce[shortcodes-options][<?php echo esc_attr($shortcode); ?>][add-to-cart]"
                   value="1" <?php checked($data['add-to-cart'] ?? false, true); ?> />
        </td>
    </tr>
    <?php endif; ?>
    <tr>
        <th scope="row"><label>Limit</label></th>
        <td>
            <input type="number" name="woocommerce[shortcodes-options][<?php echo esc_attr($shortcode); ?>][limit]"
                   value="<?php echo esc_attr($data['limit'] ?? ''); ?>" class="small-text" />
        </td>
    </tr>
    <tr>
        <th scope="row"><label>Paginate</label></th>
        <td>
            <input type="checkbox" name="woocommerce[shortcodes-options][<?php echo esc_attr($shortcode); ?>][paginate]"
                   value="1" <?php checked($data['paginate'] ?? false, true); ?> />
        </td>
    </tr>
<?php endforeach; ?>
</table>
<?php

submit_button('Guardar configuración');
echo '</form>';
