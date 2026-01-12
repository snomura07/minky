<?php

require_once __DIR__ . '/../../bootstrap/app.php';
require_once __DIR__ . '/../../vendor/autoload.php';

$migration = require __DIR__ . '/2025_01_01_000001_add.php';

if (isset($argv[1]) && $argv[1] === 'rollback') {
    $migration->down();
} 
else {
    $migration->up();
}

