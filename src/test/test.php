<?php

require_once __DIR__ . '/../app/builder/query_builder.php'; 
require_once __DIR__ . '/../app/config/env.php'; 

$qb = new QueryBuilder();

$migrations = $qb 
            ->table("migrations")
            ->select("id", "migrate_name")
            ->andWhere("rev", ">", 3)
            ->get()
;

print_r($migrations);

// class Migrate {
//     public static function status() {
//         $db = Db::getConnection();
//         return $db->query("SELECT id, migrate_name, executed_at, rev FROM migrations")->fetchAll();
//     }
// }
