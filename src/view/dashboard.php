<?php
$chartData = $weather_chart_data ?? [];
$todayStats = $today_weather_stats ?? null;
?>

<style>
    .weather-dashboard {
        --ga-bg: linear-gradient(135deg, #f4f7fe 0%, #e9f1ff 100%);
        --ga-surface: #ffffff;
        --ga-text-primary: #1a2a4a;
        --ga-text-muted: #5a6b8b;
        --ga-line: #2f7dfa;
        --ga-grid: #d7e3fa;
        --ga-border: #dbe6fb;
        font-family: "BIZ UDPGothic", "Yu Gothic UI", "Hiragino Kaku Gothic ProN", sans-serif;
    }

    .weather-dashboard__shell {
        background: var(--ga-bg);
        border: 1px solid var(--ga-border);
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 18px 40px rgba(32, 72, 156, 0.08);
    }

    .weather-dashboard__title {
        color: var(--ga-text-primary);
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .weather-dashboard__subtitle {
        color: var(--ga-text-muted);
        margin-top: 4px;
        font-size: 0.95rem;
    }

    .weather-dashboard__cards {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 20px;
    }

    .weather-card {
        border-radius: 14px;
        background: var(--ga-surface);
        border: 1px solid var(--ga-border);
        padding: 16px;
    }

    .weather-card__label {
        color: var(--ga-text-muted);
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.08em;
    }

    .weather-card__value {
        margin-top: 8px;
        color: var(--ga-text-primary);
        font-size: 2rem;
        font-weight: 700;
    }

    .weather-card--max .weather-card__value {
        color: #ce4b25;
    }

    .weather-card--min .weather-card__value {
        color: #2664d5;
    }

    .weather-dashboard__date {
        margin-top: 8px;
        color: var(--ga-text-muted);
        font-size: 0.85rem;
    }

    .weather-dashboard__chart-panel {
        margin-top: 20px;
        background: var(--ga-surface);
        border: 1px solid var(--ga-border);
        border-radius: 14px;
        padding: 18px;
    }

    .weather-dashboard__chart-title {
        color: var(--ga-text-primary);
        font-size: 1rem;
        font-weight: 700;
    }

    .weather-dashboard__chart-meta {
        margin-top: 6px;
        color: var(--ga-text-muted);
        font-size: 0.85rem;
    }

    .weather-dashboard__canvas-wrap {
        margin-top: 14px;
        height: 280px;
    }

    #fukui-temperature-chart {
        width: 100%;
        height: 100%;
        display: block;
    }

    .weather-dashboard__empty {
        margin-top: 16px;
        color: var(--ga-text-muted);
        font-size: 0.95rem;
    }

    @media (max-width: 640px) {
        .weather-dashboard__shell {
            padding: 18px;
        }

        .weather-dashboard__title {
            font-size: 1.4rem;
        }

        .weather-dashboard__cards {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="weather-dashboard">
    <div class="weather-dashboard__shell">
        <h1 class="weather-dashboard__title">福井気温ダッシュボード</h1>
        <p class="weather-dashboard__subtitle">
            過去1か月の日次平均気温の推移と、当日の最高・最低気温を表示します。
        </p>

        <?php if ($todayStats !== null): ?>
            <div class="weather-dashboard__cards">
                <article class="weather-card weather-card--max">
                    <p class="weather-card__label">当日の最高気温</p>
                    <p class="weather-card__value">
                        <?= $todayStats['max_temperature'] !== null ? htmlspecialchars(number_format($todayStats['max_temperature'], 1), ENT_QUOTES, 'UTF-8') . '℃' : '--' ?>
                    </p>
                </article>
                <article class="weather-card weather-card--min">
                    <p class="weather-card__label">当日の最低気温</p>
                    <p class="weather-card__value">
                        <?= $todayStats['min_temperature'] !== null ? htmlspecialchars(number_format($todayStats['min_temperature'], 1), ENT_QUOTES, 'UTF-8') . '℃' : '--' ?>
                    </p>
                </article>
            </div>
            <p class="weather-dashboard__date">
                対象日: <?= htmlspecialchars($todayStats['date'], ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php else: ?>
            <p class="weather-dashboard__empty">当日気温データが見つかりませんでした。</p>
        <?php endif; ?>

        <section class="weather-dashboard__chart-panel">
            <h2 class="weather-dashboard__chart-title">過去30日の日次平均気温</h2>
            <p class="weather-dashboard__chart-meta">対象地域: 福井（緯度 36.063 / 経度 136.218）</p>
            <div class="weather-dashboard__canvas-wrap">
                <canvas id="fukui-temperature-chart" data-weather-chart='<?= htmlspecialchars(json_encode($chartData, JSON_UNESCAPED_UNICODE), ENT_QUOTES, "UTF-8") ?>'></canvas>
            </div>
            <?php if (count($chartData) === 0): ?>
                <p class="weather-dashboard__empty">過去1か月分の気温データがありません。</p>
            <?php endif; ?>
        </section>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('fukui-temperature-chart');
        if (!canvas) {
            return;
        }

        const raw = canvas.dataset.weatherChart ?? '[]';
        let points;
        try {
            points = JSON.parse(raw);
        } catch (error) {
            points = [];
        }

        if (!Array.isArray(points) || points.length === 0) {
            return;
        }

        const context = canvas.getContext('2d');
        const ratio = window.devicePixelRatio || 1;
        const width = canvas.clientWidth;
        const height = canvas.clientHeight;
        canvas.width = Math.floor(width * ratio);
        canvas.height = Math.floor(height * ratio);
        context.scale(ratio, ratio);

        const padding = { top: 16, right: 16, bottom: 26, left: 38 };
        const chartWidth = width - padding.left - padding.right;
        const chartHeight = height - padding.top - padding.bottom;

        const values = points.map((point) => Number(point.average_temperature)).filter((value) => Number.isFinite(value));
        if (values.length === 0) {
            return;
        }

        const min = Math.min(...values);
        const max = Math.max(...values);
        const range = Math.max(max - min, 1);

        context.clearRect(0, 0, width, height);
        context.font = '12px "BIZ UDPGothic", "Yu Gothic UI", sans-serif';

        for (let i = 0; i <= 4; i += 1) {
            const y = padding.top + (chartHeight / 4) * i;
            context.strokeStyle = '#d7e3fa';
            context.lineWidth = 1;
            context.beginPath();
            context.moveTo(padding.left, y);
            context.lineTo(width - padding.right, y);
            context.stroke();

            const temp = (max - (range / 4) * i).toFixed(1);
            context.fillStyle = '#5a6b8b';
            context.fillText(temp + '℃', 4, y + 4);
        }

        const calcX = (index) => {
            if (points.length === 1) {
                return padding.left + chartWidth / 2;
            }
            return padding.left + (chartWidth * index) / (points.length - 1);
        };
        const calcY = (value) => padding.top + ((max - value) / range) * chartHeight;

        const gradient = context.createLinearGradient(0, padding.top, 0, height - padding.bottom);
        gradient.addColorStop(0, 'rgba(47, 125, 250, 0.32)');
        gradient.addColorStop(1, 'rgba(47, 125, 250, 0.02)');

        context.beginPath();
        points.forEach((point, index) => {
            const x = calcX(index);
            const y = calcY(Number(point.average_temperature));
            if (index === 0) {
                context.moveTo(x, y);
            } else {
                context.lineTo(x, y);
            }
        });
        context.lineTo(calcX(points.length - 1), height - padding.bottom);
        context.lineTo(calcX(0), height - padding.bottom);
        context.closePath();
        context.fillStyle = gradient;
        context.fill();

        context.beginPath();
        points.forEach((point, index) => {
            const x = calcX(index);
            const y = calcY(Number(point.average_temperature));
            if (index === 0) {
                context.moveTo(x, y);
            } else {
                context.lineTo(x, y);
            }
        });
        context.strokeStyle = '#2f7dfa';
        context.lineWidth = 2.5;
        context.stroke();

        context.fillStyle = '#2f7dfa';
        points.forEach((point, index) => {
            const x = calcX(index);
            const y = calcY(Number(point.average_temperature));
            context.beginPath();
            context.arc(x, y, 3, 0, Math.PI * 2);
            context.fill();
        });

        context.fillStyle = '#5a6b8b';
        context.textAlign = 'left';
        context.fillText(points[0].date ?? '', padding.left, height - 8);
        context.textAlign = 'right';
        context.fillText(points[points.length - 1].date ?? '', width - padding.right, height - 8);
    });
</script>
