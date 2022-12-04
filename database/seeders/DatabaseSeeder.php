<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\City;
use App\Models\Forecast;
use App\Models\HourTemperature;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CitySeeder::class,
            ForecastSeeder::class,
            HourForecastSeeder::class
        ]);
    }
}
