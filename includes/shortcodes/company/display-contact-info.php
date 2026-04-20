<?php
$atts = shortcode_atts(array(
    "label" => false,
    "method" => false,
    "template" => "default",
), $atts);

$contactDB = getPluginOptions("company-front-info");
if (empty($contactDB) || !is_array($contactDB)) return '';

if ($atts["method"]) {
	$contactDB = array(
        $atts["method"] => $contactDB[$atts["method"]]
    );
}

//return '<pre>'.print_r($contactDB).'</pre>';

if (!$contactDB) return '';

return iw_load_template("company-info", array(
    "contactDB" => $contactDB,
    "label_tag" => $atts["label"]
), $atts["template"]);