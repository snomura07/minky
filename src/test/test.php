<?php

require_once __DIR__ . '/../app/builder/query_builder.php'; 

$qb = new QueryBuilder();
$qb ->table("migrations")
    ->select("id", "name", "date")
    ->orWhere("id", 0)
    ->orWhere("date", ">", "2025/09/11")
;


