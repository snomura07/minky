<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('weather_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('latitude')->comment('緯度');
            $table->float('longitude')->comment('経度');
            $table->string('measured_time')->comment('観測時刻');
            $table->float('temperature')->comment('気温[℃]');
            $table->float('humidity')->comment('湿度[%]');
            $table->float('wind_speed')->comment('風速[m/s]');
            $table->float('precipitation')->comment('降水量[mm]');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('weather_reports');
    }
};