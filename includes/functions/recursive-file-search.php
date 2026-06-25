<?php
function iw_recursive_file_search($path, callable $action, string $filter = '', $current_element = null) {
    if (is_dir($path)) {
        $elements = scandir($path);
        foreach ($elements as $element) {
            if ($element !== '.' && $element !== '..') {
                iw_recursive_file_search($path . '/' . $element, $action, $filter, $element);
            }
        }
    } elseif (is_file($path)) {
        if (fnmatch($filter, basename($path))) {
            $action($path, $current_element);
        }
    }
}