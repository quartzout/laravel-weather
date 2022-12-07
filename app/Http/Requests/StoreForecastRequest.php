<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreForecastRequest extends ForecastRequest
{

    public function rules()
    {
        $rules = parent::rules();
        $rules['hour_forecasts'][] = 'size:24';

        return array_map(function ($attr_rules) {
            $attr_rules[] = "required";
            return $attr_rules;
        }, $rules);
    }
}
