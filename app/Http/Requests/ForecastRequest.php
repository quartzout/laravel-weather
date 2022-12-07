<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class ForecastRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {

        $date_rules = [
            'date_format:Y-m-d',
            Rule::unique('forecasts')->where(
                fn ($query) => $query->where('city_id', $this->city_id)
            )   
        ];

        $forecast_rules = [
            'city_id' => ['exists:cities,id'],
            'date' => $date_rules,
            'humidityPercent' => ['integer','between:0,100'],
            'wind' => ['integer','between:0,20'],
            'airPressure' => ['integer','between:600,900'],
            'hour_forecasts' => ['array']
        ];

        $hour_forecast_rules = [
            'hour_forecasts.*.temperature' => ['required', 'integer','between:-80,80'],
            'hour_forecasts.*.precipitation' => ['required', 'integer','between:0,40'],
        ];

        return array_merge($forecast_rules, $hour_forecast_rules);
    }
}
