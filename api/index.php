<?php
$public = realpath(__DIR__ . '/../public/index.php');
if ($public && file_exists($public)) {
    require $public;
    return;
}
http_response_code(500);
echo "Server misconfigured: public/index.php not found. Expected at: " . (__DIR__ . '/../public/index.php');
exit(1);