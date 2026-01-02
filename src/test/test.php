<?php

require_once __DIR__ . '/../app/models/db.php'; 
require_once __DIR__ . '/../app/builder/query_builder.php'; 
require_once __DIR__ . '/../app/config/env.php'; 

$qb = new QueryBuilder();
$migrations = $qb 
            ->table("migrations")
            ->select("id", "migrate_name")
            ->andWhere("rev", ">", 3)
            ->get();
print_r($migrations);

class Migrate {
    public static function status() {
        $db = Db::getConnection();
        return $db->query("SELECT id, migrate_name, executed_at, rev FROM migrations")->fetchAll();
    }
}
$migrations = Migrate::status();
echo json_encode($migrations) . "\n";

foreach ($migrations as $migration) {
    echo $migration['id'] . ": " . $migration['migrate_name'] . " (rev " . $migration['rev'] . ")\n";
}

$updateData = [
    "executed_at" => date('Y-m-d H:i:s'),
    "rev" => null,
];
// $qb2 = new QueryBuilder();
// $res = $qb2 
//      ->table("migrations")
//      ->orWhere("rev", 3)
//      ->update($updateData);
// print_r($res);

// $qb->create([
//     "migrate_name" => "create_users_table",
//     "executed_at" => date('Y-m-d H:i:s'),
//     "rev" => 6,
// ]);





