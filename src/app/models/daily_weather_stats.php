<?php
use Illuminate\Database\Eloquent\Model;

class DailyWeatherStats extends Model
{
    protected $table   = 'daily_weather_stats';
    public $timestamps = false;

    protected $fillable = [
        'latitude',
        'longitude',
        'measured_time',
        'average_temperature',
        'average_humidity',
        'average_wind_speed',
        'average_precipitation',
        'max_temperature',
        'min_temperature',
    ];
}
