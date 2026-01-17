<?php
use Illuminate\Database\Eloquent\Model;

class WeatherReports extends Model
{
    protected $table   = 'weather_reports';
    public $timestamps = false;

    protected $fillable = [
        'latitude',
        'longitude',
        'measured_time',
        'temperature',
        'humidity',
        'wind_speed',
        'precipitation',
    ];
}
