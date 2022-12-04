<?php

use App\Models\City;
use App\Models\Forecast;
use App\Models\HourForecast;
use Carbon\Carbon;
use Illuminate\Support\Collection;


function capitalize($word) {
    return  mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
}

function GetMonthString() {
    return capitalize(Carbon::now()->translatedFormat("F"));
}

function GetDateString(int $timezoneShift) {
    
    $date = Carbon::now()->addHours($timezoneShift);
    return capitalize($date->isoFormat("dddd - HH:mm, D MMMM"));
}


function GetDateStringFromDay(int $day) {
    $date = Carbon::createFromDate(day: $day);
    return capitalize($date->isoFormat("D MMMM"));
}

function GetBackgroundGifUrl(City $city) {
    return url("background_gifs/{$city->backgroundGifFilename}.gif");
}


function GetIconForHourForecast(HourForecast $hourForecast) {
    
    switch ([  $hourForecast->temperature > 0, $hourForecast->precipitation > 7 ]) {
        case [ false, false ]:
            return asset("/images/hour-icons/холодно.png");
        case [ false, true]:
            return asset("/images/hour-icons/снег.png");
        case [ true, false]:
            return asset("/images/hour-icons/тепло.png");
        case [ true, true]:
            return asset("/images/hour-icons/дождь.png");
    }
}

function GetIconForDayForecast(Forecast $forecast) {
    
    switch ([  $forecast->avgTemperature > 0, $forecast->avgPrecipitation > 5 ]) {
        case [ false, false ]:
            return asset("/images/day-icons/cold.png");
        case [ false, true]:
            return asset("/images/day-icons/snow.png");
        case [ true, false]:
            return asset("/images/day-icons/warm.png");
        case [ true, true]:
            return asset("/images/day-icons/rain.png");
    }
}


function FormatDate(string $dateString) {
    $date = new Carbon($dateString);
    return  $date->format("d.m.Y");
}

function GetWeekDay(string $dateString) {
    $date = new Carbon($dateString);
    return capitalize($date->isoFormat("dddd"));
}

function roundedAverage(Collection $collection) {
    return round($collection->sum() / $collection->count(), 0);
}