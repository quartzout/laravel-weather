<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Forecast;
use App\Models\HourForecast;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForecastControllerPostUpdateTest extends TestCase
{
    
    use RefreshDatabase;

    public function setUp(): void {

        parent::setUp();
        City::factory()->create(); 

    }

    public function test_store_forecast() {

        $forecastToCreate = [
            "date" => Carbon::today()->format("Y-m-d"),
            "airPressure" => 800,
            "humidityPercent" => 50,
            "wind" => 10,
            "airPressure" => 800,
            "city_id" => City::all()->first()->id,
            "hour_forecasts" => array_map(
                fn ($hour) => [
                    'hour' => $hour,
                    'temperature' => 5,
                    'precipitation' => 5
                ],
                range(0, 23)
            )
        ];

        $this->assertDatabaseMissing("forecasts", [
            "date" => Carbon::today()->format("Y-m-d"),
            "airPressure" => 800,
        ]);

        $response = $this->postJson(route("forecasts.index"), $forecastToCreate);
        $response->assertSuccessful();
        
        $this->assertDatabaseHas("forecasts", [
            "date" => Carbon::today()->format("Y-m-d"),
            "airPressure" => 800,
        ]);

        $this->assertDatabaseHas("hour_forecasts", [
            'temperature' => 5,
            'precipitation' => 5
        ]);

    }

    public function test_update_forecast() {

        $forecastToUpdate = [
            "wind" => 10,
            "airPressure" => 700,
            'hour_forecasts' => 
            [
                [
                    'hour' => 15,
                    'temperature' => 75,
                    'precipitation' => 0,
                ],
                [
                    'hour' => 11,
                    'temperature' => 30,
                    'precipitation' => 10,
                ]
            ] 
        ];


        $createdForecast = Forecast::factory()->has(
            HourForecast::factory()->count(24)->sequence(
                fn ($seq) => ['hour' => $seq->index]
            )
        )->create();

        

        $this->assertDatabaseHas("forecasts", [
            "city_id" => $createdForecast->city_id, 
            "date" => $createdForecast->date
        ]);


        $response = $this->putJson(
            route(
                "forecasts.update", 
                $createdForecast->id
            ), 
            $forecastToUpdate
        );

        $response->assertSuccessful();
        
        $updatedForecast = Forecast::find($createdForecast->id)->with('hourForecasts')->first();
        $this->assertNotNull($updatedForecast->hourForecasts
            ->where('hour', 15)
            ->where('temperature', 75)
            ->where('precipitation', 0)
            ->first()
        );

    }
}
