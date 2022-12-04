<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Forecast;
use App\Models\HourForecast;
use App\Models\HourTemperature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $cities = [
            [
                "name" => "Москва",
                "timezoneShift" => 3,
                "backgroundGifFilename" => "1",
                "tempSeed" => 0,
                "precipSeed" => 5,
            ],
            [
                "name" => "Санкт-Петербург",
                "timezoneShift" => 3,
                "backgroundGifFilename" => "2",
                "tempSeed" => -5,
                "precipSeed" => 7,
            ],
            [
                "name" => "Сочи",
                "timezoneShift" => 3,
                "backgroundGifFilename" => "3",
                "tempSeed" => 10,
                "precipSeed" => 3.5,
            ],
            [
                "name" => "Новосибирск",
                "timezoneShift" => 7,
                "backgroundGifFilename" => "1",
                "tempSeed" => -20,
                "precipSeed" => 5
            ],
            [
                "name" => "Казань",
                "timezoneShift" => 3,
                "backgroundGifFilename" => "2",
                "tempSeed" => -10,
                "precipSeed" => 1,
            ]
        ];

        foreach ($cities as $city) 
            City::create($city);

        
    }
}
