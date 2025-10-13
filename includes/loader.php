<?php
foreach (array(
        "config",
        "utilities",
        "setup",
        "admin",
        "front",
        "integrations",
    ) as $plugin_branch) {
        $file = __DIR__."/".$plugin_branch."/manager.php";
        if (file_exists($file)): require_once $file; endif;
}



// Configuración
do_action("Iw_Helper_Load_Config");

// Utilidades
do_action("Iw_Helper_Load_Utilities");

// Setup
do_action("Iw_Helper_Load_Setup");

// Admin
do_action("Iw_Helper_Load_Admin");

// Frontend
do_action("Iw_Helper_Load_Frontend");

// Integraciones
do_action("Iw_Helper_Load_Integrations");