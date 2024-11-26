<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionCategory extends Model
{
    protected $primaryKey = 'promotion_category_id';
    protected $table = "promotion_category";

    public function category_item()
    {
        return $this->hasMany('App\Models\Category', 'category_id');
    }


    public function category_item_list()
    {
        return $this->hasMany('App\Models\PromotionCategoryItem', 'promotion_category_id');
    }
}
