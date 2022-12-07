<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Forecast;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class ForecastByCityAndDateController extends Controller
{

    public function index(City $city)
    {
        return response($city->forecasts);
    }


    public function show(City $city, Forecast $forecast) 
    {
        return response($forecast);
    }


    
    public function destroy(City $city, Forecast $forecast)
    {
        Forecast::destroy($forecast->id);
        return response(status: 204);
    }
}
