<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class MenuItem extends Model
{
    protected $primaryKey = 'menu_id';
    protected $appends = ['menu_img','category_name'];

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
             'modifier_id'
        );
    }

    public function getMenuImgAttribute()
    {
        if($this->item_img){
            return route('display.image',[config("constants.IMAGES.MENU_IMAGE_PATH"),$this->item_img]) ;
        }
    }

    public function getCategoryNameAttribute()
    {
        if($this->category){
            return $this->category->category_name;

        }else{
            return '';
        }
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }

}
