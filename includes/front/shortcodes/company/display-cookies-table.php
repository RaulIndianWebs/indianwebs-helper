<?php
$atts = shortcode_atts([
    'active_only' => 1,
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

ob_start();

iw_load_template("main/shortcodes/cookie_table", array(
    "cookies" => $cookies,
));

return ob_get_clean();