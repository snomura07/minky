<?php

require __DIR__ . '/../models/daily_weather_stats.php';

class DailyWeatherStatsRepository
{
    public function create(array $data): DailyWeatherStats
    {
        return DailyWeatherStats::create($data);
    }
}
