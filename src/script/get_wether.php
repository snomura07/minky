<?php

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/actions/weather_report.php';
require_once __DIR__ . '/../app/actions/discode_action.php';

$lat = 36.063;  // Fukui
$lon = 136.218; // Fukui

$weatherReportAction = new WeatherReportAction();
$weatherReport = $weatherReportAction->fetchAndStore($lat, $lon);

$discodeMsg = sprintf(
    "Weather Report for (%.3f, %.3f):\nTime: %s\nTemperature: %.1f °C\nHumidity: %.1f %%\nWind Speed: %.1f m/s\nPrecipitation: %.1f mm",
    $weatherReport->latitude,
    $weatherReport->longitude,
    $weatherReport->measured_time,
    $weatherReport->temperature,
    $weatherReport->humidity,
    $weatherReport->wind_speed,
    $weatherReport->precipitation
);
$discodeAction = new DiscodeAction();
$discodeAction->sendMessage($discodeMsg);