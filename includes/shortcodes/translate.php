<?php

$atts = shortcode_atts(array(
	"lang" => null,
), $atts);

$current_lang = apply_filters('wpml_post_language_details', null, get_the_ID())["language_code"] ?? get_locale();

if ($atts["lang"] == $current_lang) return $content;
else return "";