<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourForecast extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at', 'id', "forecast_id"];

    public function forecast() {
        return $this->belongsTo(Forecast::class);
    }
}