<?php

namespace App\Http\Controllers;

use App\Models\City;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class MonthController extends Controller
{
    public function __invoke(int $cityId) {

        $city = City::with('forecasts.hourForecasts')->find($cityId);

        $today = Carbon::now();

        //оставляем только прогнозы текущего месяца
        $forecasts = $city->forecasts->filter(function ($forecast) use($today) {
            $date = new Carbon($forecast->date);
            return 
                $date->month == $today->month 
                && $date->year == $today->year;
        });

        $forecasts = $forecasts->sortBy("date")->values();

        return View("month", [
            "city" => $city, 
            "forecasts" => $forecasts
        ]);

    }
}
