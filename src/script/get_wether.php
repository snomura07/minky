<?php

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/actions/weather_report.php';

$lat = 36.063;  // Fukui
$lon = 136.218; // Fukui

$weatherReportAction = new WeatherReportAction();
$weatherReport = $weatherReportAction->fetchAndStore($lat, $lon);