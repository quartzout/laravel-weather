<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Forecast;
use Illuminate\Http\Request;

class ForecastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forecasts = Forecast::with('hourForecasts')->get();
        
        return response($forecasts);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Forecast  $forecast
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, int $id)
    {
        $forecast = Forecast::with('hourForecasts')->findOrFail($id);
        return response($forecast);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forecast  $forecast
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Forecast::findOrFail($id);
        Forecast::destroy($id);
        return response("");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "city_id" => 'required|exists:cities,id',
            "date" => 'date'
        ]);

        $forecast = Forecast::create($request->all());
        return response($forecast);
        
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forecast  $forecast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
    

        $forecast = Forecast::findOrFail($id);

        $request->validate([
            "city_id" => 'required|exists:cities,id',
            "date" => 'date'
        ]);

        $forecast->update($request->all());
        $forecast->save();
        return response($forecast);
     
    }
}
