<?php

namespace App\Controller;

require_once __DIR__ . '/../actions/daily_weather_stat_action.php';

class DashboardController
{
    private const FUKUI_LAT = 36.063;
    private const FUKUI_LON = 136.218;

    public function __invoke()
    {
        session_start();

        // CSRFトークン生成
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $dailyWeatherStatAction = new \DailyWeatherStatAction();
        $dashboardData = $this->buildDashboardData($dailyWeatherStatAction);

        $this->render(__DIR__ . '/../../view/layout.php', [
            'title'      => 'ダッシュボード',
            'view'       => 'dashboard',
            'csrf_token' => $_SESSION['csrf_token'],
            'weather_chart_data' => $dashboardData['weather_chart_data'],
            'today_weather_stats' => $dashboardData['today_weather_stats'],
        ]);
    }

    private function buildDashboardData(\DailyWeatherStatAction $dailyWeatherStatAction): array
    {
        $today = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-29 days'));

        $trendRows = $dailyWeatherStatAction->getMonthlyTemperatureTrend(
            self::FUKUI_LAT,
            self::FUKUI_LON,
            $startDate,
            $today
        );

        $chartData = [];
        foreach ($trendRows as $row) {
            $avgTemperature = $row->average_temperature;
            if ($avgTemperature === null) {
                continue;
            }

            $chartData[] = [
                'date' => substr((string)$row->measured_time, 0, 10),
                'average_temperature' => round((float)$avgTemperature, 1),
            ];
        }

        $todayStats = $dailyWeatherStatAction->getDailyExtremesByDate(
            self::FUKUI_LAT,
            self::FUKUI_LON,
            $today
        );
        if ($todayStats === null) {
            $todayStats = $dailyWeatherStatAction->getLatestDailyExtremes(
                self::FUKUI_LAT,
                self::FUKUI_LON
            );
        }

        return [
            'weather_chart_data' => $chartData,
            'today_weather_stats' => $this->formatTodayWeatherStats($todayStats),
        ];
    }

    private function formatTodayWeatherStats(?\DailyWeatherStats $todayStats): ?array
    {
        if ($todayStats === null) {
            return null;
        }

        return [
            'date' => substr((string)$todayStats->measured_time, 0, 10),
            'max_temperature' => $todayStats->max_temperature !== null
                ? round((float)$todayStats->max_temperature, 1)
                : null,
            'min_temperature' => $todayStats->min_temperature !== null
                ? round((float)$todayStats->min_temperature, 1)
                : null,
        ];
    }

    private function render(string $template, array $data = [])
    {
        extract($data, EXTR_SKIP);
        include $template;
    }
}
