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

        //Find city by provided id
        $city = City::find($request->safe()->only("city_id"))->first();

        //create forecast and associate it with city
        $forecast = new Forecast($request->safe()->except(["hour_forecasts"]));
        $city->forecasts()->save($forecast);
    
        //create 24 hour forecasts using provided hour_forecast attribute
        $hourForecasts = collect()->range(0, 23)->map(function ($hour) use($request, $forecast) {

            $values = $request->safe()->collect()->get("hour_forecasts")[$hour];

            $hour_forecast = new HourForecast($values);
            $hour_forecast->hour = $hour;
            return $hour_forecast;
        });


        $forecast->hourForecasts()->saveMany($hourForecasts);

        $forecastWithRelations = $forecast->load('hourForecasts');

        return $forecastWithRelations;
        
    }


    public function update(UpdateForecastRequest $request, Forecast $forecast)
    {
    
        //update forecast 
        $forecast->update($request->safe()->except(["hour_forecasts"]));
        $forecast->save();


        //update hour forecasts (if given)
        if ($request->safe()->collect()->has("hour_forecasts"))
            foreach ($request->safe()->collect()->get("hour_forecasts") as $hour_forecast_data) {
                $hourForecast = HourForecast::whereBelongsTo($forecast)->where('hour', $hour_forecast_data["hour"])->first();
                $hourForecast->update($hour_forecast_data);
                $hourForecast->save();
            }

        $forecastWithRelations =  $forecast->load('hourForecasts');
        return $forecastWithRelations;
     
    }
}
