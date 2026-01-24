<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('daily_weather_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('latitude')->comment('緯度');
            $table->float('longitude')->comment('経度');
            $table->string('measured_time')->comment('観測日時');
            $table->float('average_temperature')->comment('平均気温[℃]');
            $table->float('average_humidity')->comment('平均湿度[%]');
            $table->float('average_wind_speed')->comment('平均風速[m/s]');
            $table->float('average_precipitation')->comment('平均降水量[mm]');
            $table->float('max_temperature')->comment('最高気温[℃]');
            $table->float('min_temperature')->comment('最低気温[℃]');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('daily_weather_stats');
    }
};