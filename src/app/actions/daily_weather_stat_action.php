<?php

require_once __DIR__ . '/../repositories/daily_weather_stats.php';

class DailyWeatherStatAction
{
    protected DailyWeatherStatsRepository $dailyWeatherStatsRepository;
    public function __construct()
    {
        $this->dailyWeatherStatsRepository = new DailyWeatherStatsRepository();
    }

    public function store(array $data): DailyWeatherStats
    {
        return $this->dailyWeatherStatsRepository->create($data);
    } 
}