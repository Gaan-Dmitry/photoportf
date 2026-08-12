<?php
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
if (strpos($path, '/data/') === 0 || strpos($path, '/.') === 0) {
    http_response_code(403);
    die("Forbidden");
}
return false;
