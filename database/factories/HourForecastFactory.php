<?php

namespace Database\Factories;

use App\Models\Forecast;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HourForecast>
 */
class HourForecastFactory extends Factory
{
 
    public function definition()
    {
        return [
            "temperature" => random_int(-10, 10),
            "precipitation" => random_int(0, 10),
            "forecast_id" => Forecast::inRandomOrder()->first()
        ];
    }
}
