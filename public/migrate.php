<?php

// PERINGATAN: HAPUS FILE INI SETELAH MIGRASI SELESAI
// ATAU BERI NAMA YANG SANGAT RAHASIA

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

try {
    $exitCode = $kernel->call('migrate', [
        '--force' => true,
    ]);
    echo "DATABASE MIGRATION SUCCESSFUL!";
} catch (Exception $e) {
    echo "MIGRATION FAILED: \n";
    echo $e->getMessage();
}

?>