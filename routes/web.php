<?php

use App\Http\Controllers\DayController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MonthController;
use App\Http\Controllers\WeekController;
use App\Models\City;
use App\Models\Record;
use Illuminate\Support\Facades\Route;
use Barryvdh\Debugbar\Facades\Debugbar;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Переадресация на главную страницу первого имеющегося в бд города 
Route::get("/", function () {

    $city = City::all()->firstOrFail();
    return redirect("/{$city->id}");
});

Route::get("/{cityId:int}", MainController::class);
Route::get("/{cityId:int}/day/", DayController::class);
Route::get("/{cityId:int}/week/", WeekController::class);
Route::get("/{cityId:int}/month/", MonthController::class);