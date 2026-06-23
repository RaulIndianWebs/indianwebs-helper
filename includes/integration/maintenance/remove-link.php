<?php
add_action('admin_menu', function () {
    remove_menu_page('maintenance');
}, 9999);