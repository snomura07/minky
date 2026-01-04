<?php

require __DIR__ . '/../../bootstrap/app.php';
require __DIR__ . '/../models/migrations.php';


$id = 1;
$res = Migrations::find($id);
print($res);

$res = Migrations::where('rev', 2)->get();
print($res);

$latest = Migrations::orderBy('rev', 'desc')->first();
print($latest)."\n";
