<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $primaryKey = 'subscription_id';
    protected $fillable = ['subscription_plan', 'stripe_plan_id', 'price', 'subscribers', 'subscription_type'];

}
