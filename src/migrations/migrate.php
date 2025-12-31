<?php

require_once __DIR__ . '/../app/config/env.php'; 
require_once __DIR__ . '/../app/models/db.php'; 

class Migrate {
    public static function status() {
        $db = Db::getConnection();
        return $db->query("SELECT id, migrate_name, executed_at, rev FROM migrations")->fetchAll();
    }
}

$status = Migrate::status();
var_dump($status);
