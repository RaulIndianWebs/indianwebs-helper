<?php
global $wpdb;
$table = $wpdb->prefix . 'iw_cookies_log';

// Procesar POST
if ( isset($_POST['save_cookies']) && check_admin_referer("iw_save") ) {
    if ( ! empty($_POST['cookies']) && is_array($_POST['cookies']) ) {
        foreach ($_POST['cookies'] as $id => $data) {
            $wpdb->update(
                $table,
                array(
                    'public_name'       => sanitize_text_field($data['public_name'] ?? ''),
                    'cookie_expiration' => sanitize_text_field($data['cookie_expiration'] ?? ''),
                    'cookie_category'   => sanitize_text_field($data['cookie_category'] ?? ''),
                    'cookie_description'=> sanitize_textarea_field($data['cookie_description'] ?? ''),
                    'active'            => !empty($data['active']) ? 1 : 0,
                ),
                array('id' => intval($id)),
                array('%s','%s','%s','%s','%d'),
                array('%d')
            );
        }
        echo '<div class="notice notice-success"><p>Cookies guardadas correctamente.</p></div>';
    }
}

// Ahora obtenemos los datos **después de procesar el POST**
$cookies = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");

echo '<form method="post">';
wp_nonce_field("iw_save");
?>

<table class="widefat fixed" cellspacing="0">
    <thead>
        <tr>
            <th>Cookie Name</th>
            <th>Public Name</th>
            <th>Expiration</th>
            <th>Category</th>
            <th>Description</th>
            <th>Active</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($cookies)) : ?>
            <?php foreach ($cookies as $cookie) : ?>
                <tr>
                    <td><?php echo esc_html($cookie->cookie_name); ?></td>
                    <td>
                        <input type="text" name="cookies[<?php echo esc_attr($cookie->id); ?>][public_name]" 
                               value="<?php echo esc_attr($cookie->public_name); ?>" />
                    </td>
                    <td>
                        <input type="text" name="cookies[<?php echo esc_attr($cookie->id); ?>][cookie_expiration]" 
                               value="<?php echo esc_attr($cookie->cookie_expiration); ?>" />
                    </td>
                    <td>
                        <select name="cookies[<?php echo esc_attr($cookie->id); ?>][cookie_category]">
                            <?php 
                            $categories = array('Necesarias', 'Estadisticas', 'Experiencia', 'Marketing');
                            foreach ($categories as $category_option) :
                            ?>
                                <option value="<?php echo esc_attr($category_option); ?>" 
                                    <?php selected($cookie->cookie_category, $category_option); ?>>
                                    <?php echo esc_html($category_option); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>

                    <td>
                        <textarea name="cookies[<?php echo esc_attr($cookie->id); ?>][cookie_description]"><?php 
                            echo esc_textarea($cookie->cookie_description); ?></textarea>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" name="cookies[<?php echo esc_attr($cookie->id); ?>][active]" value="1"
                            <?php checked($cookie->active, 1); ?> />
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr><td colspan="6">No cookies registered yet.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
submit_button('Guardar configuración', 'primary', 'save_cookies');
echo '</form>';
