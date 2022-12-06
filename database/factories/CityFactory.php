<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->city(),
            "backgroundGifFilename" => random_int(0, 5),
            "timezoneShift" => random_int(0, 24),
            "tempSeed" => random_int(-10, 10),
            "precipSeed" => random_int(0, 10)
        ];
    }
}
