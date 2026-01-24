<?php

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/actions/weather_report.php';
require_once __DIR__ . '/../app/actions/daily_weather_stat_action.php';

$weatherReportAction    = new WeatherReportAction();
$dailyWeatherStat       = $weatherReportAction->getDailyStats();
$dailyWeatherStatAction = new DailyWeatherStatAction();

$saveData = [
    'latitude'               => 35.6895,
    'longitude'              => 139.6917,
    'measured_time'          => date('Y-m-d'),
    'average_temperature'    => $dailyWeatherStat['avg_temperature'],
    'average_humidity'       => $dailyWeatherStat['avg_humidity'],
    'average_wind_speed'     => $dailyWeatherStat['avg_wind_speed'],
    'average_precipitation'  => $dailyWeatherStat['avg_precipitation'],
    'max_temperature'        => $dailyWeatherStat['max_temperature'],
    'min_temperature'        => $dailyWeatherStat['min_temperature'],
];
$dailyWeatherStatAction->store($saveData);
