<?php
$atts = shortcode_atts(array(
    "label" => false,
), $atts);

$contactDB = Iw_Helper_DB_Manager::options("get", "company-front-info");
if (empty($contactDB) || !is_array($contactDB)) return '';


return iw_load_template("contact-info", array(
    "contact_info" => $contactDB,
    "label" => $atts["label"],
));