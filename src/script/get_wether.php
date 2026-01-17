<?php

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/actions/weather_report.php';

$lat = 35.6895; // Example latitude (Tokyo)
$lon = 139.6917; // Example longitude (Tokyo)

$weatherReportAction = new WeatherReportAction();
$weatherReport = $weatherReportAction->fetchAndStore($lat, $lon);