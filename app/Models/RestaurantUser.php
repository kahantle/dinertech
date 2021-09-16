<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;

class RestaurantUser extends Model
{
    //
    protected $primaryKey = 'restaurant_user_id';

    protected $fillable = ['uid', 'restaurant_id', 'status'];

    public function users()
    {
        return $this->hasMany(User::class,'uid','uid')->where('role',Config::get('constants.ROLES.CUSTOMER'));
    }


    
}
