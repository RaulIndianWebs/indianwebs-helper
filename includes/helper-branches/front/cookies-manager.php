<?php
if (!defined('ABSPATH')) exit;

add_action('plugins_loaded', function() {
    Iw_Helper_DB_Manager::tables('save', 'cookies_log', [
        'columns' => "
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            cookie_name VARCHAR(191) NOT NULL,
            public_name VARCHAR(255) NOT NULL,
            cookie_expiration VARCHAR(100) DEFAULT NULL,
            cookie_category VARCHAR(255) DEFAULT NULL,
            cookie_description TEXT DEFAULT NULL,
            active TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_cookie (cookie_name)
        ",
        'definition' => [
            'description' => 'Tabla para almacenar cookies detectadas',
            'version' => '1.0'
        ]
    ]);
});

add_action('init', function() {
    if (empty($_COOKIE)) return;

    foreach ($_COOKIE as $name => $value) {
        $cookie_data = [
            'cookie_name'        => sanitize_text_field($name),
            'cookie_expiration'  => null,
            'cookie_category'    => null,
            'cookie_description' => null,
            'created_at'         => current_time('mysql'),
        ];

        // Comprobar si ya existe la fila
        $exists = Iw_Helper_DB_Manager::rows('get', 'cookies_log', ['fields' => 'id'], ['cookie_name' => $name]);

        if (empty($exists)) {
            // Insertar fila usando rows()
            Iw_Helper_DB_Manager::rows('save', 'cookies_log', $cookie_data);
        }
    }
});
