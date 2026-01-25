<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('prefecture_name')->comment('県名');
            $table->string('city_name')->comment('市名');
            $table->float('latitude')->comment('緯度');
            $table->float('longitude')->comment('経度');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('cities');
    }
};