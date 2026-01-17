<?php

require_once __DIR__ . '/../repositories/weather_reports.php';

class WeatherReportAction
{
    protected WeatherReportsRepository $weatherReportsRepository;

    public function __construct()
    {
        $this->weatherReportsRepository = new WeatherReportsRepository();
    }

    public function fetchAndStore(float $lat, float $lon): WeatherReports
    {
        $url = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current=temperature_2m,relative_humidity_2m,wind_speed_10m,precipitation&timezone=Asia%2FTokyo";

        $json = file_get_contents($url);
        $data = json_decode($json, true);

        $obs = $data["current"];

        $weatherData = [
            'latitude' => $lat,
            'longitude' => $lon,
            'measured_time' => $obs['time'],
            'temperature' => $obs['temperature_2m'],
            'humidity' => $obs['relative_humidity_2m'],
            'wind_speed' => $obs['wind_speed_10m'],
            'precipitation' => $obs['precipitation'],
        ];

        return $this->weatherReportsRepository->create($weatherData);
    }
    
}