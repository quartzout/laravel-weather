<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateForecastRequest extends ForecastRequest
{
    
    public function rules()
    {
        $rules = parent::rules();
        $rules['hour_forecasts.*.hour'] = ["required", "integer", "between:0,23"];

        return $rules;
    }
}
