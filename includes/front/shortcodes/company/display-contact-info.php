<?php
$atts = shortcode_atts(array(
    "label" => false,
    "layout" => null,
), $atts);

$contactDB = Iw_Helper_DB_Manager::options("get", "company-front-info");
if (empty($contactDB) || !is_array($contactDB)) return '';

ob_start();

iw_load_template("contact-info", array(
    "contact_info" => $contactDB,
    "label" => $atts["label"],
), $atts["layout"]);

return ob_get_clean();