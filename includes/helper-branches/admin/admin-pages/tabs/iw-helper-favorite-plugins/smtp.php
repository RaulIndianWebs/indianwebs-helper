<?php
$maintenance = new IW_Helper_Favorite_Plugins(Array(
    "Paloma" => "wp-mail-smtp",
    "Easy SMTP" => "easy-wp-smtp",
));
$maintenance->render();