<?php

require __DIR__ . '/../models/weather_reports.php';

class WeatherReportsRepository
{
    public function create(array $data): WeatherReports
    {
        return WeatherReports::create($data);
    }

    public function getDailyWeatherStats() {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        return WeatherReports::whereBetween('measured_time', [$today, $tomorrow])
            ->selectRaw('
                AVG(temperature) as avg_temperature,
                AVG(humidity) as  avg_humidity,
                AVG(wind_speed) as avg_wind_speed,
                AVG(precipitation) as avg_precipitation,
                MAX(temperature) as max_temperature,
                MIN(temperature) as min_temperature,
                VARIANCE(temperature) as variance_temperature
            ')
            ->where('measured_time', '>=', $today .    ' 00:00:00')
            ->where('measured_time', '<' , $tomorrow . ' 00:00:00')
            ->first();
    }

    public function getDailyWeatherStatsByCityId(int $cityId) {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        return WeatherReports::whereBetween('measured_time', [$today, $tomorrow])
            ->selectRaw('
                AVG(temperature) as avg_temperature,
                AVG(humidity) as  avg_humidity,
                AVG(wind_speed) as avg_wind_speed,
                AVG(precipitation) as avg_precipitation,
                MAX(temperature) as max_temperature,
                MIN(temperature) as min_temperature,
                VARIANCE(temperature) as variance_temperature
            ')
            ->where('measured_time', '>=', $today .    ' 00:00:00')
            ->where('measured_time', '<' , $tomorrow . ' 00:00:00')
            ->where('city_id', $cityId)
            ->first();
    }

}
