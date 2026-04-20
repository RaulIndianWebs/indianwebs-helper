<?php
function is_maintenance_mode() {
    $options = get_option('maintenance_options');
    if (!empty($options) && isset($options['state']) && $options['state'] == 1) {
        return true;
    }
    return false;
}


add_action('plugins_loaded', function () {
    if (!wp_next_scheduled('daily_maintenance_check_event')) {
        wp_schedule_event(time(), 'daily', 'daily_maintenance_check_event');
    }
});


add_action('daily_maintenance_check_event', function () {
    if (is_maintenance_mode()) {
        $admin_email = get_option('admin_email');
        $subject = 'Sitio en Mantenimiento';
        $message = '¡Atención! El sitio está actualmente en modo mantenimiento según la opción "maintenance_options". Por favor, revisa que todo esté bien.';
        wp_mail($admin_email, $subject, $message);
    }
});


register_deactivation_hook(__FILE__, function () {
    $timestamp = wp_next_scheduled('daily_maintenance_check_event');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'daily_maintenance_check_event');
    }
});