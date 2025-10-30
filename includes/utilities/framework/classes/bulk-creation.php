<?php

namespace IW_Helper\Utilities\Framework\Admin;

class IW_Helper_Bulk_Creation {
    private static array $base_dirs;

    public static function add_dir($dir) {
        self::$base_dirs[] = $dir;
    }

    public static function init() {
        
    }
}