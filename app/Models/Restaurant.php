<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Restaurant extends Model
{
    use Notifiable;
    protected $primaryKey = 'restaurant_id';

    public function restaurant_user()
    {
        return $this->hasOne('App\Models\RestaurantUser', 'restaurant_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'restaurant_id');
    }

    public function OnlineOrders()
    {
        return $this->hasMany('App\Models\Order', 'restaurant_id')->where('isCash', 1);
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'restaurant_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'uid');
    }

    public function routeNotificationForFcm()
    {
        $fcm_ids = RestaurantFcmTokens::where('uid', $this->user->uid)->pluck('fcm_id')->toArray();
        return $fcm_ids;
        // return $this->user->fcm_id;
    }

    /**
     * Get all of the subscribers for the Restaurant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscribers()
    {
        return $this->hasMany(RestaurantSubscribers::class, 'restaurant_id', 'restaurant_id');
    }

    /**
     * Get all of the subscriptions for the Restaurant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(RestaurantSubscription::class, 'restaurant_id', 'restaurant_id');
    }
}
