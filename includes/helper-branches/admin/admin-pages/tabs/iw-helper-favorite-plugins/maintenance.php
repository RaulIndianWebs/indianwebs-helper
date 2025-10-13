<?php
$maintenance = new IW_Helper_Favorite_Plugins(Array(
    "Maintenance" => "maintenance",
    "Plugin CHecker" => "plugin-compatibility-checker",
    "Core Rollback" => "core-rollback",
    "Better Search and Replace" => "better-search-replace",
    "Accessibility Tools" => "tool-for-ada-section-508-and-seo",
));
$maintenance->render();
