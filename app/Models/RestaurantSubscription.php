<?php

namespace App\Models;

use Config;
use Illuminate\Database\Eloquent\Model;

class RestaurantSubscription extends Model
{
    protected $table = 'restaurant_subscriptions';

    protected $primaryKey = 'restaurant_subscription_id';

    /**
     * Get the subscription associated with the RestaurantPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription()
    {
        // return $this->hasOne(Subscription::class, 'subscription_id', 'subscription_id')->where('subscription_plan', Config::get('constants.SUBSCRIPTION_PLAN.2'));
        return $this->hasOne(Subscription::class, 'subscription_id', 'subscription_id')->where('subscription_plan', Config::get('constants.SUBSCRIPTION_PLAN.2'))->OrWhere('subscription_plan', Config::get('constants.SUBSCRIPTION_PLAN.3'));
    }

    /**
     * Get the user associated with the RestaurantSubscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(RestaurantPayment::class, 'id', 'restaurant_payment_id');
    }
}
