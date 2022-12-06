<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Forecast;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForecastByIdTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void {

        parent::setUp();

        City::factory()->create();
        $forecasts = Forecast::factory(["airPressure" => 700])->count(3)->create();
        $this->firstForecast= $forecasts[0];

    }


    public function test_list_all_forecasts()
    {
        $response = $this->getJson(route("forecasts.index"));
        $response->assertOk();
        $response->assertJsonCount(3);
        $response->assertJsonFragment(["airPressure" => 700]);
    }


    public function test_show_forecast_by_id()
    {
        $response = $this->getJson(route("forecasts.index", $this->firstForecast->id));
        $response->assertOk();
        $response->assertJsonFragment(["airPressure" => 700]);
    }


    public function test_delete_forecast_by_id() {

        $this->assertDatabaseHas("forecasts", ["id" => $this->firstForecast->id]);

        $response = $this->delete(route("forecasts.destroy", $this->firstForecast->id));
        $response->assertSuccessful();

        $this->assertDatabaseMissing("forecasts", ["id" => $this->firstForecast->id]);
    }


    public function test_store_forecast() {

        $ForecastDate = Carbon::today()->addDays(7)->format("Y-m-d");

        $this->assertDatabaseMissing("forecasts", ["date" => $ForecastDate, "airPressure" => 800]);

        $model = [
            "date" => $ForecastDate,
            "humidityPercent" => 50,
            "wind" => 10,
            "airPressure" => 800,
            "city_id" => City::all()->first()->id
        ];

        $response = $this->postJson(route("forecasts.index"), $model);
        $response->assertSuccessful();
        
        $this->assertDatabaseHas("forecasts", ["date" => $ForecastDate, "airPressure" => 800]);

    }

    public function test_update_forecast() {


        $this->assertDatabaseHas("forecasts", ["id" => $this->firstForecast->id, "airPressure" => 700]);


        $response = $this->putJson(
            route(
                "forecasts.update", 
                $this->firstForecast->id
            ), 
            ["airPressure" => 800]
        );
        $response->assertSuccessful();
        
        $this->assertDatabaseHas("forecasts", ["id" => $this->firstForecast->id, "airPressure" => 800]);

    }


}
