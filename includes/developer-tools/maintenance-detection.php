<?php

$option_slug = 'developer-tools';

function is_maintenance_mode() {
    $options = get_option('maintenance_options');
    return !empty($options['state']) && (int) $options['state'] === 1;
}

function iw_maybe_send_maintenance_notice() {
    if (!getPluginOptions($option_slug)['iw-mail-notification']) {
        return;
    }

    $last_check = get_transient('iw_maintenance_last_check');
    $one_day    = DAY_IN_SECONDS;

    if ($last_check !== false && (time() - $last_check) < $one_day) {
        return;
    }

    set_transient('iw_maintenance_last_check', time(), $one_day * 2);

    if (!is_maintenance_mode()) {
        return;
    }

    $admin_email = get_option('admin_email');
    $site_title  = get_bloginfo('name');
    $site_url    = get_bloginfo('url');

    $subject = 'Sitio en Mantenimiento';
    $message = "¡Atención! El sitio está actualmente en modo mantenimiento.\n\n"
             . "Sitio: {$site_title}\n"
             . "URL: {$site_url}\n\n"
             . "Por favor, revisa que todo esté bien.";

    wp_mail($admin_email, $subject, $message);
}

// Se dispara en cada visita del front-end
add_action('wp', function () {
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return;
    }
    iw_maybe_send_maintenance_notice();
});