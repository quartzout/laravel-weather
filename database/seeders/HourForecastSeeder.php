<?php

namespace Database\Seeders;

use App\Models\Forecast;
use App\Models\HourForecast;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HourForecastSeeder extends Seeder
{

    private function precipDistributionByDay(int $day) {
        $magnitude = 0.5;
        $frequency = 0.4;
        $offset = 3;
        return $magnitude*sin($frequency * $day + $offset) + $magnitude * 2;
    }

    private function precipDistributionByHour(int $hour) {
        $magnitude = 0.5;
        $frequency = 0.2;
        $offset = random_int(-2, 2);
        return $magnitude*sin($frequency * $hour + $offset) + $magnitude * 2;
    }


    private function tempDistributionByHour(int $hour) {
        $magnitude = 5;
        $frequency = 0.26;
        $offset = 4;
        return $magnitude*sin($frequency * $hour + $offset);
    }

    private function tempDistributionByDay(int $day) {
        $magnitude = 3;
        $frequency = 0.4;
        $offset = 1;
        return $magnitude*sin($frequency * $day + $offset);
    }


    public function run()
    {

        foreach (Forecast::all() as $forecast) {

            foreach(range(0, 23) as $hour) {
                
                $day = (new Carbon($forecast->date))->day;
                
                $hourForecast = HourForecast::factory()->make();
            
                $hourForecast->hour = $hour;
                
                $hourForecast->temperature =
                    $forecast->city->tempSeed +  
                    $this->tempDistributionByDay($day) + 
                    $this->tempDistributionByHour($hour) + 
                    random_int(-1, 1);

                $hourForecast->precipitation = 
                    $forecast->city->precipSeed *
                    $this->precipDistributionByDay($day) *
                    $this->precipDistributionByHour($hour); 

                $hourForecast->forecast()->associate($forecast);
                $hourForecast->save();

            }
        }
    }
}
