<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{   
    protected $primaryKey = 'restaurant_id';

    public function restaurant_user()
    {
        return $this->hasOne('App\Models\RestaurantUser', 'restaurant_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order','restaurant_id');
    }

    public function OnlineOrders()
    {
        return $this->hasMany('App\Models\Order','restaurant_id')->where('isCash',1);
    }

}
