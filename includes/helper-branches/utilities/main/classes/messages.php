<?php
if (!class_exists("Iw_Message")) {
    class Iw_Message {
        public static function dev_error($message) {
            return self::message($message, "error", true, true);
        }
        
        
        public static function dev_notification($message) {
            return self::message($message, "notification", true, true);
        }
        
        
        public static function dev_success($message) {
            return self::message($message, "success", true, true);
        }
        
        
        public static function front_error($message) {
            return self::message($message, "error", false);
        }
        
        
        public static function front_notification($message) {
            return self::message($message, "notification", false);
        }
        
        
        public static function front_success($message) {
            return self::message($message, "success", false);
        }
        

        private static function message($message, $type, $debug, $console_log=false) {
            iw_load_template("framework/message", array(
                "message" => $message,
                "type" => $type,
            ));
            
            if ($debug == true) {
                error_log("IW ".$type.": ".$message.".");
                echo '<script>console.log('.json_encode("IW $type: $message").');</script>';
            }

            return true;
        }
    }
}