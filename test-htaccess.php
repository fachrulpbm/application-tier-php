<?php
header("Content-Type: application/json");

$info = [
    'htaccess_test' => 'WORKING',
    'request_uri' => $_SERVER['REQUEST_URI'],
    'script_name' => $_SERVER['SCRIPT_NAME'],
    'query_string' => $_SERVER['QUERY_STRING'] ?? 'empty',
    'get_params' => $_GET,
    'mod_rewrite' => function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules()) ? 'ENABLED' : 'UNKNOWN'
];

echo json_encode($info, JSON_PRETTY_PRINT);