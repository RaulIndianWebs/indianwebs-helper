<?php
function iw_recursive_file_search($path, callable $action, string $filter = '') {
    if (is_dir($path)) {
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                traverse_php_files($path . '/' . $file, $action, $filter);
            }
        }
    } elseif (is_file($path)) {
        if (fnmatch($filter, basename($path))) {
            $action($path);
        }
    }
}
