<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Forecast;
use Illuminate\Http\Request;

class ForecastByCityAndDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $cityName)
    {
        $city = City::where("name", $cityName)->with("forecasts.hourForecasts")->firstOrFail();
        $forecasts = $city->forecasts;

        return response($forecasts);
    }

    /**
     * Display the specified resource.
     *
     * @param string $city
     * @param string $date
     * @return \Illuminate\Http\Response
     */
    public function show(string $cityName, string $date) 
    {
        $city = City::where("name", $cityName)->with("forecasts.hourForecasts")->firstOrFail();

        $forecast = $city->forecasts
            ->where("date", $date)
            ->firstOrFail();

        return response($forecast);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param string $city
     * @param string $date
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $cityName, string $date)
    {
        $city = City::where("name", $cityName)->firstOrFail();
        
        $forecast = $city->forecasts
            ->where("date", $date)
            ->firstOrFail();
        
        Forecast::destroy($forecast->id);
        return response("");
    }
}
