<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Forecast;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForecastByCityAndDateControllerTest extends TestCase
{
    
    use RefreshDatabase;

    public function setUp(): void {

        parent::setUp();

        City::factory(["name" => "Москва"])
        ->has(
            Forecast::factory(["airPressure" => 700])
            ->sequence(fn ($sequence) => ['date' => Carbon::today()->addDays($sequence->index)->format("Y-m-d")])
            ->count(3))
        ->create();

    }


    
    public function test_list_all_forecasts_in_city()
    {
        $response = $this->getJson(route("forecasts-by-city-name.index", ["Москва"]));

        $response->assertOk();
        $response->assertJsonCount(3);
        $response->assertJsonFragment(["airPressure"=>700]);
    }

    public function test_show_forecast_in_city() {

        $response = $this->getJson(
            route(
                "forecasts-by-city-name.show", 
                [
                    "Москва", 
                    Carbon::today()->format("Y-m-d")
                ]
            )
        );

        $response->assertOk();
        $response->assertJsonFragment(['airPressure' => 700]);
    }

    public function test_destroy_forecast_in_city() {
        
        $this->assertDatabaseHas("forecasts", ["date" => Carbon::today()->format("Y-m-d")]);

        $response = $this->delete(
            route(
                "forecasts-by-city-name.show", 
                [
                    "Москва", 
                    Carbon::today()->format("Y-m-d")
                ]
            )
        );

        $response->assertSuccessful();

        $this->assertDatabaseMissing("forecasts", ["date" => Carbon::today()->format("Y-m-d")]);
    }
}
