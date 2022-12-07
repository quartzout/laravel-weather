<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Forecast;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForecastControllerTest extends TestCase
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


}
