<?php
$atts = shortcode_atts(array(
	"template" => "default",
), $atts);

$computed_content = do_shortcode($content);

return iw_load_template("read-more", array(
	"content" => $computed_content,
), $atts["template"]);