<?php
// Shortcode handler
function iw_cookies_table_shortcode($atts) {
    // Opcional: filtrar solo activas
    $atts = shortcode_atts([
        'active_only' => 1, // 1 = solo activas, 0 = todas
    ], $atts, 'cookies_table');

    // Preparar condición
    $where = [];
    if ($atts['active_only']) {
        $where['active'] = 1;
    }

    // Obtener cookies usando la clase
    $cookies = Iw_Helper_DB_Manager::rows('get', 'cookies_log', ['fields' => '*'], $where);

    if (empty($cookies)) {
        return "<p>No hay cookies registradas.</p>";
    }

    // Generar tabla HTML
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
        $output .= '<td style="border:1px solid #ccc;padding:5px;">' . esc_html($cookie['public_name']) . '</td>';
        $output .= '<td style="border:1px solid #ccc;padding:5px;">' . esc_html($cookie['cookie_expiration']) . '</td>';
        $output .= '<td style="border:1px solid #ccc;padding:5px;">' . esc_html($cookie['cookie_category']) . '</td>';
        $output .= '<td style="border:1px solid #ccc;padding:5px;">' . esc_html($cookie['cookie_description']) . '</td>';
        $output .= '</tr>';
    }

    $output .= '</tbody></table>';

    return $output;
}

add_shortcode('cookies_table', 'iw_cookies_table_shortcode');
