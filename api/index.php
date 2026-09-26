<?php

// Pastikan struktur folder temporary tersedia di environment serverless Vercel (/tmp)
$storageDirs = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($storageDirs as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Teruskan request ke Laravel public/index.php
require __DIR__.'/../public/index.php';
