<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantFcmTokens extends Model
{
    protected $table = 'restaurants_fcm_tokens';

    protected $primaryKey = 'restaurant_fcmtoken_id';

    protected $fillable = ['uid', 'restaurant_id','fcm_id', 'device'];
}
