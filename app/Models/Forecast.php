<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Forecast extends Model
{
    use HasFactory;


    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = [];



    public function city() {
        return $this->belongsTo(City::class);
    }

    public function hourForecasts() {
        return $this->hasMany(HourForecast::class);
    }







    private $cachedTemps = null;

    public function temperatures(): Attribute {
        
        return Attribute::get(function() {

            if (!is_null($this->cachedTemps))
                return $this->cachedTemps;

            //из коллекции почасовых прогнозов создается коллекция температур и сортируется по возрастанию
            $cachedTemps = $this->hourForecasts
                ->map(function ($hourForecast) { return $hourForecast->temperature; })
                ->sort()->values();

            return $cachedTemps;
        });  
    }

    public function minTemperature(): Attribute {
        return Attribute::get(function() {
            return $this->temperatures->min();
        });  
    }

    public function maxTemperature(): Attribute {
        return Attribute::get(function() {
            return $this->temperatures->max();
        });  
    }

    public function avgTemperature(): Attribute {
        return Attribute::get(function() {
            return roundedAverage($this->temperatures); 
        });  
    }

    public function avgTemperatureDay(): Attribute {
        return Attribute::get(function() {
            
            //C 8:00 до конца суток
            $dayTemps = $this->temperatures->slice(8, 16);

            return roundedAverage($dayTemps);
        });  
    }

    public function avgTemperatureNight(): Attribute {
        return Attribute::get(function() {

            //С начала суток до 8:00
            $nightTemps = $this->temperatures->slice(0, 8);

            return roundedAverage($nightTemps);
        });  
    }

    public function feelsLike(): Attribute { 

        return Attribute::get(function() {

            $hour = Carbon::now()->hour;
            return $hour >= 8 ? $this->avgTemperatureDay : $this->avgTemperatureNight;
        
        });

    }



    private $cachedPrecips = null;

    public function precipitations(): Attribute {
        
        return Attribute::get(function() {

            if (!is_null($this->cachedPrecips))
                return $this->cachedPrecips;

            //из коллекции почасовых прогнозов создается коллекция температур
            $cachedPrecips = $this->hourForecasts->map(function ($hourForecast) { return $hourForecast->precipitation; });

            return $cachedPrecips;
        });  
    }

    public function avgPrecipitation(): Attribute {
        return Attribute::get(function() {
            return roundedAverage($this->precipitations);
        });  
    }

}
