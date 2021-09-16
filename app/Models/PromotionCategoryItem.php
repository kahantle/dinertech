<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionCategoryItem extends Model
{
    protected $primaryKey = 'promotion_category_item_id';
    protected $table = "promotion_category_items";

    // public function category_item()
    // {
    //     return $this->hasMany('App\Models\MenuItem','menu_id' ,'item_id');
    // }

    public function category_item()
    {
        return $this->hasMany('App\Models\MenuItem','menu_id' ,'item_id')->select('menu_id','restaurant_id','category_id','item_img','item_name','item_details','item_price');
    }
    
}
