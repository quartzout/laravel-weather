<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Forecast;
use App\Models\HourTemperature;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForecastSeeder extends Seeder
{

    public function run()
    {
        $MONTHS = [Carbon::NOVEMBER, Carbon::DECEMBER];

        foreach(City::all() as $city) {

            foreach ($MONTHS as $month) {

                $days = Carbon::createFromDate(month: $month)->daysInMonth;

                foreach (range(1, $days) as $day) {
                    $forecast = Forecast::factory()->make();

                    $date = Carbon::createFromDate(month: $month, day: $day);
                    $forecast->date = $date->format("Y-m-d");

                    $forecast->city()->associate($city);
                    $forecast->save();
                    

                }
            }
        }
    }
}
