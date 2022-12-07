<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreForecastRequest;
use App\Http\Requests\UpdateForecastRequest;
use App\Models\City;
use App\Models\Forecast;
use App\Models\HourForecast;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ForecastController extends Controller
{

    public function index()
    {
        $forecasts = Forecast::with('hourForecasts')->get();
        
        return response($forecasts);
    }


    public function show(Forecast $forecast)
    {
        return response($forecast);
    }



    public function destroy(Forecast $forecast)
    {
        $forecast->delete();
        return response(status: 204);
    }



    public function store(StoreForecastRequest $request)
    {
        $request->validate([
            "city_id" => 'required|exists:cities,id',
            "date" => 'date'
        ]);

        $forecast = Forecast::create($request->all());
        return $forecast;
        
    }


    public function update(UpdateForecastRequest $request, Forecast $forecast)
    {
    

        $forecast = Forecast::findOrFail($id);

        $request->validate([
            "city_id" => 'exists:cities,id',
            "date" => 'date'
        ]);

        $forecast->update($request->all());
        $forecast->save();
        return $forecast;
     
    }
}
