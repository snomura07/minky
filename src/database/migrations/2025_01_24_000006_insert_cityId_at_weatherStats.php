<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->table('daily_weather_stats', function (Blueprint $table) {
            $table->integer('city_id')->nullable()->comment('都市ID')->after('id');
        });
    }

    public function down(): void
    {
        Capsule::schema()->table('daily_weather_stats', function (Blueprint $table) {
            $table->dropColumn('city_id');
        });
    }
};