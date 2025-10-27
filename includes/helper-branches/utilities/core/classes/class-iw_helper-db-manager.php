<?php
class Iw_Helper_DB_Manager {
    static $option_prefix = "iw-";
    static $table_prefix  = "iw_helper_";

    static $all_data = [
        "options" => [],
        "tables"  => [],
    ];

    public static function options($action, $options_slug, $options_array = null) {
        $options_slug = self::$option_prefix . $options_slug;

        if (!is_string($options_slug) || empty($options_slug)) {
            return false;
        }

        switch ($action) {
            case "save":
            case "update":
                if (!in_array($options_slug, self::$all_data["options"])) {
                    self::$all_data["options"][] = $options_slug;
                }
                return update_option($options_slug, $options_array);

            case "get":
                return get_option($options_slug, []);

            case "delete":
                delete_option($options_slug);
                $key = array_search($options_slug, self::$all_data["options"]);
                if ($key !== false) {
                    unset(self::$all_data["options"][$key]);
                }
                return true;

            default:
                return false;
        }
    }

    public static function tables($action, $table_name, $data = null) {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $table = $wpdb->prefix . self::$table_prefix . $table_name;

        switch ($action) {
            case "save":
            case "update":
                if (!isset($data['columns']) || empty($data['columns'])) {
                    return false;
                }

                $charset_collate = $wpdb->get_charset_collate();
                $sql = "CREATE TABLE {$table} (
                    {$data['columns']}
                ) {$charset_collate};";

                dbDelta($sql);

                if (!in_array($table_name, self::$all_data["tables"])) {
                    self::$all_data["tables"][] = $table_name;
                }

                if (isset($data['definition'])) {
                    $definition_key = self::$table_prefix . "definition_" . $table_name;
                    self::options("save", $definition_key, $data['definition']);
                }

                return true;

            case "get":
                $definition_key = self::$table_prefix . "definition_" . $table_name;
                $definition = self::options("get", $definition_key);

                if (empty($definition)) {
                    $definition = $wpdb->get_results("DESCRIBE {$table}", ARRAY_A);
                }

                return $definition;

            case "delete":
                $wpdb->query("DROP TABLE IF EXISTS {$table}");

                $definition_key = self::$table_prefix . "definition_" . $table_name;
                self::options("delete", $definition_key);

                $key = array_search($table_name, self::$all_data["tables"]);
                if ($key !== false) {
                    unset(self::$all_data["tables"][$key]);
                }

                return true;

            default:
                return false;
        }
    }

    public static function rows($action, $table_name, $data = null, $where = []) {
        global $wpdb;
        $table = $wpdb->prefix . self::$table_prefix . $table_name;

        switch ($action) {
            case "save":
            case "update":
                if (empty($data)) {
                    return false;
                }

                if (empty($where)) {
                    return $wpdb->insert($table, $data);
                }
                return $wpdb->update($table, $data, $where);

            case "get":
                $fields = isset($data['fields']) ? $data['fields'] : "*";
                $where_sql = "";
                if (!empty($where)) {
                    $conditions = [];
                    foreach ($where as $key => $value) {
                        $conditions[] = $wpdb->prepare("{$key} = %s", $value);
                    }
                    $where_sql = "WHERE " . implode(" AND ", $conditions);
                }
                $query = "SELECT {$fields} FROM {$table} {$where_sql}";
                return $wpdb->get_results($query, ARRAY_A);

            case "delete":
                if (empty($where)) {
                    return false;
                }
                return $wpdb->delete($table, $where);

            default:
                return false;
        }
    }

    public static function resetAll() {
        if (!empty(self::$all_data['options'])) {
            foreach (self::$all_data['options'] as $opt) {
                self::options("delete", str_replace(self::$option_prefix, "", $opt));
            }
        }

        if (!empty(self::$all_data['tables'])) {
            foreach (self::$all_data['tables'] as $tbl) {
                self::tables("delete", $tbl);
            }
        }

        self::$all_data['options'] = [];
        self::$all_data['tables']  = [];

        return true;
    }
}
