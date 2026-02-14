<?php

require __DIR__ . '/../models/daily_weather_stats.php';

class DailyWeatherStatsRepository
{
    private const LOCATION_TOLERANCE = 0.01;

    public function create(array $data): DailyWeatherStats
    {
        return DailyWeatherStats::create($data);
    }

    public function getMonthlyTemperatureTrend(
        float $latitude,
        float $longitude,
        string $startDate,
        string $endDate
    ) {
        return DailyWeatherStats::query()
            ->whereBetween('latitude', [
                $latitude - self::LOCATION_TOLERANCE,
                $latitude + self::LOCATION_TOLERANCE,
            ])
            ->whereBetween('longitude', [
                $longitude - self::LOCATION_TOLERANCE,
                $longitude + self::LOCATION_TOLERANCE,
            ])
            ->whereBetween('measured_time', [$startDate, $endDate])
            ->orderBy('measured_time', 'asc')
            ->get([
                'measured_time',
                'average_temperature',
            ]);
    }

    public function getDailyExtremesByDate(
        float $latitude,
        float $longitude,
        string $date
    ): ?DailyWeatherStats {
        return DailyWeatherStats::query()
            ->whereBetween('latitude', [
                $latitude - self::LOCATION_TOLERANCE,
                $latitude + self::LOCATION_TOLERANCE,
            ])
            ->whereBetween('longitude', [
                $longitude - self::LOCATION_TOLERANCE,
                $longitude + self::LOCATION_TOLERANCE,
            ])
            ->where('measured_time', $date)
            ->orderBy('id', 'desc')
            ->first([
                'measured_time',
                'max_temperature',
                'min_temperature',
            ]);
    }

    public function getLatestDailyExtremes(
        float $latitude,
        float $longitude
    ): ?DailyWeatherStats {
        return DailyWeatherStats::query()
            ->whereBetween('latitude', [
                $latitude - self::LOCATION_TOLERANCE,
                $latitude + self::LOCATION_TOLERANCE,
            ])
            ->whereBetween('longitude', [
                $longitude - self::LOCATION_TOLERANCE,
                $longitude + self::LOCATION_TOLERANCE,
            ])
            ->orderBy('measured_time', 'desc')
            ->orderBy('id', 'desc')
            ->first([
                'measured_time',
                'max_temperature',
                'min_temperature',
            ]);
    }
}
