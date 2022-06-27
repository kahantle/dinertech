<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;

class Promotion extends Model
{
    protected $primaryKey = 'promotion_id';

    public function promotion_type()
    {
        return $this->belongsTo('App\Models\PromotionType', 'promotion_type_id');
    }

    public function promotion_item()
    {
        return $this->hasMany('App\Models\PromotionEligibleItem', 'promotion_id');
    }

    public function eligible_items()
    {

        return $this->hasManyThrough(
            'App\Models\PromotionEligibleItem',
            'App\Models\MenuItem',
            'menu_id',
            'eligible_item_id'
        );
    }

 

    public function promotion_category()
    {

        return $this->hasManyThrough(
            'App\Models\PromotionCategory',
            'App\Models\Category',
            'category_id',
            'promotion_id',
            'promotion_category_id',
            'category_id',
        );
    }

    public function getSelectedPaymentStatusAttribute($value)
    {
        if($value == 0)
        {
            return "Cash";
        }
        elseif($value == 1)
        {
            return "Card to delivery person or at pickup counter";
        }
        else
        {
            return "Cash & Card to delivery person or at pickup counter";
        }
    }

    public function getOnlyOncePerClientAttribute($value)
    {
        if($value == 0)
        {
            return "true";
        }
        else
        {
            return "false";
        }
    }

    protected $casts = [
        'created_at' => 'datetime:d-m-Y h:s A',
    ];

    // public function getPromotionFunctionAttribute($value)
    // {
    //     foreach(Config::get('constants.PROMOTION_FUNCTION') as $key => $function)
    //     {
    //         if($value == $key)
    //         {
    //             return $function;
    //         }
    //     }
    // }

    // public function getAvailabilityAttribute($value){
    //     foreach(Config::get('constants.AVAILABILITY') as $key => $availability){
    //         if($value == $key){
    //             return $availability;
    //         }
    //     }
    // }
}
