<?php

require __DIR__ . '/../models/weather_reports.php';

class WeatherReportsRepository
{
    public function create(array $data): WeatherReports
    {
        return WeatherReports::create($data);
    }
}
