<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Authorization, Origin');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$requested = __DIR__ . '/public' . $uri;

if ($uri !== '/' && file_exists($requested)) {
    return false;
}

require_once __DIR__ . '/public/index.php';

?>