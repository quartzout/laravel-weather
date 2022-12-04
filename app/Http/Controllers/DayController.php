<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class DayController extends Controller
{
    public function __invoke(int $cityId) {

        $city = City::with('forecasts.hourForecasts')->find($cityId);

        $today_date = date("Y-m-d");
        $todaysForecast = $city->forecasts->where('date', $today_date)->firstOrFail();
        
        return View("day", [
            'city' => $city, 
            'forecast' => $todaysForecast,
        ]);

    }
}
