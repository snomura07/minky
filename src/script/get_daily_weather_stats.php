<?php

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/actions/weather_report.php';
require_once __DIR__ . '/../app/actions/daily_weather_stat_action.php';
require_once __DIR__ . '/../app/actions/discode_action.php';

$weatherReportAction    = new WeatherReportAction();
$dailyWeatherStat       = $weatherReportAction->getDailyStats();
$dailyWeatherStatAction = new DailyWeatherStatAction();

$lat = 36.063;  // Fukui
$lon = 136.218; // Fukui
$saveData = [
    'latitude'               => $lat,
    'longitude'              => $lon,
    'measured_time'          => date('Y-m-d'),
    'average_temperature'    => $dailyWeatherStat['avg_temperature'],
    'average_humidity'       => $dailyWeatherStat['avg_humidity'],
    'average_wind_speed'     => $dailyWeatherStat['avg_wind_speed'],
    'average_precipitation'  => $dailyWeatherStat['avg_precipitation'],
    'max_temperature'        => $dailyWeatherStat['max_temperature'],
    'min_temperature'        => $dailyWeatherStat['min_temperature'],
];
$dailyWeatherStatAction->store($saveData);

$discodeMsg = sprintf(
    "Daily Weather Stats for (%.3f, %.3f) on %s:\nAvg Temperature: %.1f °C\nAvg Humidity: %.1f %%\nAvg Wind Speed: %.1f m/s\nAvg Precipitation: %.1f mm\nMax Temperature: %.1f °C\nMin Temperature: %.1f °C",
    $lat,
    $lon,
    date('Y-m-d'),
    $dailyWeatherStat['avg_temperature'],
    $dailyWeatherStat['avg_humidity'],
    $dailyWeatherStat['avg_wind_speed'],
    $dailyWeatherStat['avg_precipitation'],
    $dailyWeatherStat['max_temperature'],
    $dailyWeatherStat['min_temperature']
);
$discodeAction = new DiscodeAction();
$discodeAction->sendMessage($discodeMsg);