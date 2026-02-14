<?php

require __DIR__ . '/../../bootstrap/app.php';
require __DIR__ . '/../../app/repositories/cities.php';

$cities = (new CitiesRepository())->getAll();

echo "count: " . $cities->count() . PHP_EOL;

foreach ($cities as $city) {
    print_r($city->toArray());
}

