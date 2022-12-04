<?php

namespace App\Http\Controllers;

use App\Models\City;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function __invoke(int $cityId) {

        $city = City::with('forecasts.hourForecasts')->find($cityId);

        $todaysForecast = $city->forecasts->where('date', Carbon::now()->format("Y-m-d"))->firstOrFail();
        $thisHourShifted = Carbon::now()->addHours($city->timezoneShift)->hour;
        $thisHoursForecast = $todaysForecast->hourForecasts->where('hour', $thisHourShifted)->firstOrFail();
        
        $allCities = City::all();

        return View("main", [
            'city' => $city, 
            'allCities' => $allCities,
            'forecast' => $todaysForecast,
            'hourForecast' => $thisHoursForecast
        ]);
    }

}
