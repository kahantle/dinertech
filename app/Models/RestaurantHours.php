<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RestaurantHours extends Model
{
    protected $primaryKey = 'restaurant_hour_id';

    /**
     * Get all of the times for the RestaurantHours
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allTimes()
    {
        return $this->hasMany(RestaurantHoursTimes::class, 'restaurant_hour_id', 'restaurant_hour_id');
        // return $this->hasMany(RestaurantHoursTimes::class, 'restaurant_hour_id', 'restaurant_hour_id')->groupBy('hours_group_id')->groupBy('opening_time')->groupBy('closing_time');
        // return $this->hasOne(RestaurantHoursTimes::class, 'restaurant_hour_id');
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }

}
