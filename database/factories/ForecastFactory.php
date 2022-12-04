<?php

namespace Database\Factories;

use App\Models\City;
use DateTime;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Forecast>
 */
class ForecastFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "humidityPercent" => random_int(70, 99),
            "airPressure" => random_int(740, 780),
            "wind" => random_int(0, 10),

            "date" => $this->faker->date(),
            "city_id" => City::inRandomOrder()->first()
        ];
    }
}
