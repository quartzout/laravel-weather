<?php

namespace App\Http\Controllers;

use App\Models\City;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use DateTime;
use DateTimeImmutable;
use Illuminate\Http\Request;

class WeekController extends Controller
{
    public function __invoke(int $cityId) {

        $city = City::with('forecasts.hourForecasts')->find($cityId);

        $monday = CarbonImmutable::now()->startOfWeek(Carbon::MONDAY);

        //Массив прогнозов на неделю
        $forecasts = collect()->range(0, 6)->map(function (int $weekOffset) use($monday, $city) {
            $date = $monday->addDays($weekOffset);
            return $city->forecasts->where('date', $date->format("Y-m-d"))->firstOrFail();
        });

        return View("week", [
            "city" => $city,
            "forecasts" => $forecasts
        ]);

    }
}
