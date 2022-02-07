<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Config;

class MenuItem extends Model
{
    protected $primaryKey = 'menu_id';
    protected $appends = ['menu_img', 'category_name'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function modifier()
    {
        return $this->belongsTo('App\Models\MenuModifierItem', 'modifier_id');
    }

    public function modifiers()
    {
        return $this->hasMany('App\Models\MenuModifierItem', 'menu_id');
    }

    public function modifierList()
    {
        return $this->hasManyThrough(
            'App\Models\ModifierGroup',
            'App\Models\MenuModifierItem',
            'menu_id',
            'modifier_group_id',
            'menu_id',
            'modifier_id',
        );
    }

    public function getMenuImgAttribute()
    {
        if ($this->item_img) {
            return route('display.image', [config("constants.IMAGES.MENU_IMAGE_PATH"), $this->item_img]);
        }
    }

    public function getDefaultImage()
    {
        return route('display.image', [config("constants.IMAGES.MENU_IMAGE_PATH"), 'default.jpg']);
    }

    public function getCategoryNameAttribute()
    {
        if ($this->category) {
            return $this->category->category_name;
        } else {
            return '';
        }
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function getLoyaltyStatusAttribute(){
        $restaurant = RestaurantUser::where('uid',Auth::user()->uid)->first();
        $loyaltyPoint = LoyaltyRuleItem::with('loyaltyRule')->where('menu_id',$this->menu_id)->where('restaurant_id',$restaurant->restaurant_id)->first();
        if(Auth::user()->total_points < $loyaltyPoint->loyaltyRule->point){
            return Config::get('constants.LOYALTY_MENU_STATUS.NOT_ELIGIBLE');
        }else{
            return Config::get('constants.LOYALTY_MENU_STATUS.ELIGIBLE');
        }
    }
}
