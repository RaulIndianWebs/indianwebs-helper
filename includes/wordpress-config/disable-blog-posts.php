<?php
if (!getPluginOptions("wordpress-config")["disable_blog_posts"]) return;

add_action('admin_menu', function () {
    remove_menu_page('edit.php');
    remove_menu_page('edit-comments.php');
    
    global $pagenow;
    if ($pagenow === 'edit.php' && (!isset($_GET['post_type']) || $_GET['post_type'] === 'post')) {
        wp_redirect(admin_url('index.php'));
        exit;
    }
}, 999);


function disable_feed() {
    wp_redirect(home_url());
    exit;
}
add_action('do_feed', 'disable_feed', 1);
add_action('do_feed_rdf', 'disable_feed', 1);
add_action('do_feed_atom', 'disable_feed', 1);
add_action('do_feed_rss', 'disable_feed', 1);
add_action('do_feed_rss2', 'disable_feed', 1);



add_action('admin_bar_menu', function ($wp_admin_bar) {
    $wp_admin_bar->remove_node('new-post');
}, 999);