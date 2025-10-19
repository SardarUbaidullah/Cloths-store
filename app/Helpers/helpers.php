<?php

if (!function_exists('formatFieldValue')) {
    function formatFieldValue($value) {
        if (is_array($value)) {
            $flattened = [];
            array_walk_recursive($value, function($v) use (&$flattened) {
                $flattened[] = $v;
            });
            return implode(', ', $flattened);
        }
        return $value;
    }
}
