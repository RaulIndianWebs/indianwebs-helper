<?php

$option_slug = 'developer-tools';

function is_maintenance_mode() {
    $options = get_option('maintenance_options');
    if (!empty($options) && isset($options['state']) && $options['state'] == 1) {
        return true;
    }
    return false;
}

$active = getPluginOptions($option_slug)["iw-mail-notification"];

add_action('plugins_loaded', function () use ($active) {
    if ($active && !wp_next_scheduled('daily_maintenance_check_event')) {
        wp_schedule_event(time(), 'daily', 'daily_maintenance_check_event');
    }

    if (!$active) {
        wp_clear_scheduled_hook('daily_maintenance_check_event');
    }

});


add_action('daily_maintenance_check_event', function () {
    if (is_maintenance_mode()) {
        $admin_email = get_option('admin_email');

        $site_title = get_bloginfo('name');
        $site_url   = get_bloginfo('url');

        $subject = 'Sitio en Mantenimiento';

        $message = "¡Atención! El sitio está actualmente en modo mantenimiento.\n\n";
        $message .= "Sitio: " . $site_title . "\n";
        $message .= "URL: " . $site_url . "\n\n";
        $message .= "Por favor, revisa que todo esté bien.";

        wp_mail($admin_email, $subject, $message);
    }
});


register_deactivation_hook(__FILE__, function () {
    $timestamp = wp_next_scheduled('daily_maintenance_check_event');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'daily_maintenance_check_event');
    }
});