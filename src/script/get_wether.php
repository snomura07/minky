<?php

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/actions/weather_report.php';

$lat = 35.6895;  // Fukui
$lon = 139.6917; // Fukui

$weatherReportAction = new WeatherReportAction();
$weatherReport = $weatherReportAction->fetchAndStore($lat, $lon);