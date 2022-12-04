<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hour_forecasts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer("temperature");
            $table->integer("hour");
            $table->integer("precipitation");
            $table->foreignId("forecast_id")->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hour_forecasts');
    }
};
