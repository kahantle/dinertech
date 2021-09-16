<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionEligibleItem extends Model
{
    protected $primaryKey = 'promotion_eligible_item_id';
    protected $table = "promotion_eligible_items";

     public function promotion_item()
    {
        return $this->hasMany('App\Models\MenuItem','menu_id' ,'eligible_item_id');
    }

    public function promotion_category()
    {
        return $this->hasMany('App\Models\PromotionCategory','promotion_eligible_item_id');
    }
}
