<?php

namespace App\Models;

use Config;
use Illuminate\Database\Eloquent\Model;

class RestaurantPayment extends Model
{
    protected $primaryKey = 'restaurant_payment_id';
    protected $table = "restaurant_payment";

    /**
     * Get the subscription associated with the RestaurantPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'subscription_id', 'subscription_id')->where('subscription_plan', Config::get('constants.SUBSCRIPTION_PLAN.2'));
    }
}
