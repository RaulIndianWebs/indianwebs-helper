<?php
if (!defined('ABSPATH')) exit;

add_action('plugins_loaded', function() {
    global $wpdb;
    $table = $wpdb->prefix . 'iw_cookies_log';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
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
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
});

add_action('init', function() {
    if (empty($_COOKIE)) return;

    global $wpdb;
    $table = $wpdb->prefix.'iw_cookies_log';

    foreach ($_COOKIE as $name => $value) {
        $cookie_expiration = null;

        $existe = $wpdb->get_var(
            $wpdb->prepare("SELECT COUNT(*) FROM $table WHERE cookie_name = %s", $name)
        );

        if (!$existe) {
            $wpdb->insert(
                $table,
                array(
                    'cookie_name'       => sanitize_text_field($name),
                    'cookie_expiration' => $cookie_expiration,
                    'cookie_category'   => null,
                    'cookie_description'=> null,
                    'created_at'        => current_time('mysql'),
                ),
                array('%s', '%s', '%s', '%s', '%s')
            );
        }
    }
});
