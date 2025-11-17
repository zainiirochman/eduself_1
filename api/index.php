<?php
// robust loader: cari public/index.php di beberapa lokasi relatif
$candidates = [
    __DIR__ . '/../public/index.php',
    __DIR__ . '/public/index.php',
    __DIR__ . '/../../public/index.php',
    __DIR__ . '/../../../public/index.php',
    __DIR__ . '/../index.php',
    __DIR__ . '/index.php',
];

$found = null;
foreach ($candidates as $p) {
    if (file_exists($p)) {
        $found = $p;
        break;
    }
}

if ($found) {
    require $found;
    return;
}

// jika tidak ditemukan, tampilkan pesan yang jelas agar mudah debug di Vercel
http_response_code(500);
header('Content-Type: text/plain; charset=utf-8');
echo "Server misconfiguration: public/index.php not found.\n";
echo "Checked the following paths:\n";
foreach ($candidates as $p) {
    echo " - $p\n";
}
echo "\nPlease ensure the public/ folder (and public/index.php) is included in the deployment or adjust your vercel build script to copy it into the package.\n";
exit(1);