<?php
// cek cepat lokasi public/index.php yang diharapkan
$public = realpath(__DIR__ . '/../public/index.php');

if (!$public || !is_file($public)) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Server misconfiguration: public/index.php not found.\n";
    echo "Expected at: " . (__DIR__ . '/../public/index.php') . "\n";
    error_log('public/index.php not found in deployment package: ' . (__DIR__ . '/../public/index.php'));
    exit(1);
}

// require secepat mungkin (pastikan vendor sudah ter-install saat build)
require $public;