<?php

$envFile = dirname(__DIR__, 2) . '/.env';

if (!file_exists($envFile)) {
    return;
}

foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    // コメント行はスキップ
    if (strpos(trim($line), '#') === 0) {
        continue;
    }

    if (strpos($line, '=') !== false) {
        list($key, $value) = explode('=', $line, 2);
        putenv("$key=$value");
    }
}
