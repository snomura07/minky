<?php

require_once __DIR__ . '/../../bootstrap/app.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/actions/migration.php'; 

$migrationDir = __DIR__;
$migration    = new Migration($migrationDir);

if (!isset($argv[1])) {
    $migration->up($migrationDir);
} 
else {
    if($argv[1] === 'rollback') {
        $migration->rollback($migrationDir);
    }
    else if($argv[1] === 'status') {
        $migration->status($migrationDir);
    }    
}