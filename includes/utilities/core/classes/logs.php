<?php
if (!class_exists("Iw_Log")) {
    class Iw_Log {
        public static function error(string $message, bool $console) {
            return self::log($message, "error", $console);
        }
        
        
        public static function notification(string $message, bool $console) {
            return self::log($message, "notification", $console);
        }
        
        
        public static function success(string $message, bool $console) {
            return self::log($message, "success", $console);
        }
        

        protected static function log($message, $type, $console=false) {       
            $output = json_encode("IW $type: $message");

            if (WP_DEBUG && WP_DEBUG_LOG) {
                error_log($output);
            }

            if ($console) {
                $estilos = "padding: 5px;font-weight: bold;";
                switch ($type) {
                    case 'error':
                        $estilos .= "background-color: rgba(255, 0, 0, ,3);";
                    break;
                    case 'notification':
                        $estilos .= "background-color: rgba(0, 0, 255, ,3);";
                    break;
                    case 'success':
                        $estilos .= "background-color: rgba(0, 255, 0, ,3);";
                    break;
                }
                echo '<script>console.log('. $output .');</script>';
            }

            return true;
        }
    }
}