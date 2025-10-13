<h2>Formularios de contacto</h2>
<?php
$forms = new IW_Helper_Favorite_Plugins(Array(
    "Contact Form 7" => "contact-form-7",
    "Ninja Forms" => "ninja-forms",
    "WP Forms" => "wpforms-lite",
));
$forms->render();
?>
<br>
<h2>Logging de contacto</h2>
<?php
$form_logs = new IW_Helper_Favorite_Plugins(Array(
    "CF7DB" => "contact-form-cfdb7",
    "Flamingo" => "flamingo",
));
$form_logs->render();
?>
<br>