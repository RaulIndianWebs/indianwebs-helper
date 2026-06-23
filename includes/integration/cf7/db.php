<?php
add_action('admin_menu', function () {

    remove_menu_page('cfdb7-list.php');

}, 9999);

add_action('admin_menu', function () {

    add_submenu_page(
        'wpcf7',
        'Submissions',
        'Submissions',
        'manage_options',
        'cfdb7-list.php'
    );

}, 10000);