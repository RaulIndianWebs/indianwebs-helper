<?php
if (!class_exists("Iw_Message")) {
    class Iw_Message extends Iw_Log {
        public static function error(string $message, bool $console) {
            return self::message($message, "error", false);
        }
        
        
        public static function front_notification(string $message, bool $console) {
            return self::message($message, "notification", false);
        }
        
        
        public static function front_success(string $message, bool $console) {
            return self::message($message, "success", false);
        }
        

        private static function message($message, $type, $console=false) {
            iw_load_template("framework/message", array(
                "message" => $message,
                "type" => $type,
            ));

            parent::log($message, $type, $console);

            return true;
        }
    }
}
