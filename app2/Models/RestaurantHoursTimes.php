<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantHoursTimes extends Model
{
    protected $primaryKey = 'restaurant_time_id';
    protected $table = 'restaurant_hours_times';
    

    public function getOpeningTimeAttribute($value){
        return date("h:i A",strtotime($value));
    }

    public function getClosingTimeAttribute($value){
        return date("h:i A",strtotime($value));
    }
}
