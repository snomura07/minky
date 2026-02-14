<?php

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/actions/weather_report.php';
require_once __DIR__ . '/../app/actions/city_action.php';
require_once __DIR__ . '/../app/actions/discode_action.php';

$cities  = (new CityAction())->getAll();

foreach ($cities as $city) {
    $cityId = $city->id;
    $lat    = $city->latitude;
    $lon    = $city->longitude;

    $weatherReportAction = new WeatherReportAction();
    $weatherReport = $weatherReportAction->fetchAndStore($cityId, $lat, $lon);

    $discodeMsg = sprintf(
        "Weather Report for %s:\nTime: %s\nTemperature: %.1f °C\nHumidity: %.1f %%\nWind Speed: %.1f m/s\nPrecipitation: %.1f mm\n",
        $city->city_name,
        $weatherReport->measured_time,
        $weatherReport->temperature,
        $weatherReport->humidity,
        $weatherReport->wind_speed,
        $weatherReport->precipitation
    );
    $discodeAction = new DiscodeAction();
    $discodeAction->sendMessage($discodeMsg);

}
