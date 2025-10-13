<?php
class IW_Helper_Loader {
    public static function init() {
        self::require_simpletons();

        // Configuración
        IW_Helper_Config_Manager::init();

        // Utilidades
        IW_Helper_Utilities_Manager::init();

        // Setup
        IW_Helper_Setup_Manager::init();

        // Form
        IW_Helper_Form_Manager::init();

        // Admin
        IW_Helper_Admin_Manager::init();

        // Frontend
        IW_Helper_Front_Manager::init();

        // Integraciones
        IW_Helper_Integrations_Manager::init();
    }

    public static function require_simpletons() {
        $simpletons_names = [
            "config",
            "utilities",
            "setup",
            "form",
            "admin",
            "front",
            "integrations",
        ];

        foreach ($simpletons_names as $simpleton_name) {
            $file = __DIR__."/".$simpleton_name."/class-iw_".$simpleton_name."-manager.php";
            if (file_exists($file)): require_once $file; endif;
        }
    }
}
