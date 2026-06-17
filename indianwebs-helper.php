<?php
/*
Plugin Name: IndianWebs Helper
Plugin URI: https://www.indianwebs.com/
Description: Plugin para la implementación adicional de la página.
Version: 6.2
Author: IndianWebs L'Hospitalet
Author URI: https://www.indianwebs.com/
Text Domain: iw-helper
Domain Path: /languages
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/



define('IW_HELPER_DIR', plugin_dir_path(__FILE__));
define('IW_HELPER_URL', plugin_dir_url(__FILE__));

require_once IW_HELPER_DIR.'/includes/file-management.php';
include_php_files(IW_HELPER_DIR . '/includes/functions/');
include_php_files(IW_HELPER_DIR . '/includes/classes/');



/* Require features */
require_once plugin_dir_path(__FILE__) . 'loader.php';




add_action('wp_footer', ['IW_Scripts_Cache', 'print_cached_css'], 999999);
add_action('wp_footer', ['IW_Scripts_Cache', 'print_cached_js'], 999999);





/**
 * Actualizaciones automáticas desde GitHub
 */
add_filter( 'pre_set_site_transient_update_plugins', 'iw_check_for_update' );

function iw_check_for_update( $transient ) {
    if ( empty( $transient->checked ) ) {
        return $transient;
    }

    $plugin_slug = 'indianwebs-helper/indianwebs-helper.php'; // Ajusta si es diferente
    $json_url    = 'https://raw.githubusercontent.com/RaulIndianWebs/indianwebs-helper/main/plugin.json';

    $response = wp_remote_get( $json_url, [ 'timeout' => 10 ] );

    if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
        return $transient;
    }

    $plugin_info = json_decode( wp_remote_retrieve_body( $response ) );

    if ( ! $plugin_info ) {
        return $transient;
    }

    $current_version = $transient->checked[ $plugin_slug ] ?? '0';

    if ( version_compare( $plugin_info->version, $current_version, '>' ) ) {
        $transient->response[ $plugin_slug ] = (object) [
            'slug'        => 'indianwebs-helper',
            'plugin'      => $plugin_slug,
            'new_version' => $plugin_info->version,
            'url'         => $plugin_info->homepage,
            'package'     => $plugin_info->download_url,
        ];
    }

    return $transient;
}

/**
 * Información del plugin en el modal de detalles
 */
add_filter( 'plugins_api', 'iw_plugin_info', 20, 3 );

function iw_plugin_info( $res, $action, $args ) {
    if ( $action !== 'plugin_information' || $args->slug !== 'indianwebs-helper' ) {
        return $res;
    }

    $json_url = 'https://raw.githubusercontent.com/RaulIndianWebs/indianwebs-helper/main/plugin.json';
    $response = wp_remote_get( $json_url, [ 'timeout' => 10 ] );

    if ( is_wp_error( $response ) ) {
        return $res;
    }

    $plugin_info = json_decode( wp_remote_retrieve_body( $response ) );

    $res = (object) [
        'name'          => $plugin_info->name,
        'slug'          => 'indianwebs-helper',
        'version'       => $plugin_info->version,
        'author'        => '<a href="' . $plugin_info->author_homepage . '">' . $plugin_info->author . '</a>',
        'homepage'      => $plugin_info->homepage,
        'requires'      => $plugin_info->requires,
        'tested'        => $plugin_info->tested,
        'last_updated'  => $plugin_info->last_updated,
        'download_link' => $plugin_info->download_url,
        'sections'      => [
            'description'    => 'Plugin de desarrollo para IndianWebs.',
            'upgrade_notice' => $plugin_info->upgrade_notice,
        ],
    ];

    return $res;
}
