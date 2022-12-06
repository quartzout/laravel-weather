<?php

use App\Http\Controllers\ForecastByCityAndDateController;
use App\Http\Controllers\ForecastByIdController;
use App\Http\Controllers\ForecastController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::apiResource("forecasts", ForecastController::class);

Route::prefix("forecasts-by-city-date/{cityName}")->group(function () {

    Route::get("/", [ForecastByCityAndDateController::class, "index"])->name("forecasts-by-city-name.index");
    Route::get("{date}", [ForecastByCityAndDateController::class, "show"])->name("forecasts-by-city-name.show");
    Route::delete("{date}", [ForecastByCityAndDateController::class, "destroy"])->name("forecasts-by-city-name.destroy");

});




