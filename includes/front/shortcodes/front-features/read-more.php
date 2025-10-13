<?php
IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/shortcodes/read-more.css');
IW_Scripts_Cache::cache_js_files(get_plugin_directory() . 'assets/js/shortcodes/read-more.js');

return '<div class="iw-read-more-text">' . do_shortcode($content) . '</div>';






/*
add_shortcode('iw-read-more', function($atts, $content = null) {
    
});
*/