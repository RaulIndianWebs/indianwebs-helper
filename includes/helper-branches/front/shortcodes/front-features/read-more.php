<?php
$atts = shortcodes_atts(array(
    'content' => '',
    'template' => null,
), $atts);

ob_start();

iw_load_template("main/shortcodes/read-more", array(
    'content' => $atts["content"],
));

return ob_get_clean();