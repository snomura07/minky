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

    public function getMonthlyTemperatureTrend(
        float $latitude,
        float $longitude,
        string $startDate,
        string $endDate
    ) {
        return $this->dailyWeatherStatsRepository->getMonthlyTemperatureTrend(
            $latitude,
            $longitude,
            $startDate,
            $endDate
        );
    }

    public function getDailyExtremesByDate(
        float $latitude,
        float $longitude,
        string $date
    ): ?DailyWeatherStats {
        return $this->dailyWeatherStatsRepository->getDailyExtremesByDate(
            $latitude,
            $longitude,
            $date
        );
    }

    public function getLatestDailyExtremes(
        float $latitude,
        float $longitude
    ): ?DailyWeatherStats {
        return $this->dailyWeatherStatsRepository->getLatestDailyExtremes(
            $latitude,
            $longitude
        );
    }
}
