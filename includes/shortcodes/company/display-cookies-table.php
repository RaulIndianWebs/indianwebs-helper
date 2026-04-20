<?php
global $wpdb;
$table = $wpdb->prefix . 'iw_cookies_log';

// Opcional: permite filtrar si solo quieres mostrar activas
$atts = shortcode_atts( array(
    'active_only' => 1, // 1 = solo activas, 0 = todas
), $atts, 'cookies_table' );

$where = $atts['active_only'] ? "WHERE active = 1" : "";

$cookies = $wpdb->get_results("SELECT * FROM $table $where ORDER BY created_at DESC");

if (empty($cookies)) {
    return "<p>No hay cookies registradas.</p>";
}

$output = '<table class="cookies-table" style="width:100%;border-collapse:collapse;">';
$output .= '<thead>
    <tr style="background:#f5f5f5;">
        <th style="border:1px solid #ccc;padding:5px;">Cookie Name</th>
        <th style="border:1px solid #ccc;padding:5px;">Expiration</th>
        <th style="border:1px solid #ccc;padding:5px;">Category</th>
        <th style="border:1px solid #ccc;padding:5px;">Description</th>
    </tr>
</thead>';
$output .= '<tbody>';

foreach ($cookies as $cookie) {
    $output .= '<tr>';
    $output .= '<td style="border:1px solid #ccc;padding:5px;">' . esc_html($cookie->public_name) . '</td>';
    $output .= '<td style="border:1px solid #ccc;padding:5px;">' . esc_html($cookie->cookie_expiration) . '</td>';
    $output .= '<td style="border:1px solid #ccc;padding:5px;">' . esc_html($cookie->cookie_category) . '</td>';
    $output .= '<td style="border:1px solid #ccc;padding:5px;">' . esc_html($cookie->cookie_description) . '</td>';
    $output .= '</tr>';
}

$output .= '</tbody></table>';

return $output;
