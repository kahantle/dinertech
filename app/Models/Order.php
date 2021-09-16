<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    protected $primaryKey = 'order_id';
    protected $appends = ['user_name'];


    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderMenuItem', 'order_id');
    }

 

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'uid');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\CustomerAddress', 'address_id');
    }


    public function getUserNameAttribute()
    {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }

}
