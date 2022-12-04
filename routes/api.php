<?php

use App\Http\Controllers\ForecastByCityAndDateController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\RecordsController;
use App\Models\Record;
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource("forecasts", ForecastController::class);

Route::prefix("forecastsByCity/{cityName}")->group(function () {

    Route::get("/", [ForecastByCityAndDateController::class, "index"]);
    Route::get("{date}", [ForecastByCityAndDateController::class, "show"]);
    Route::delete("{date}", [ForecastByCityAndDateController::class, "destroy"]);

});




