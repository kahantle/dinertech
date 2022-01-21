<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderMenuItem extends Model
{
    protected $primaryKey = 'order_menu_item_id';
    protected $table = 'order_menu_item';

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        $menu = $this->image($this->menu_id);
        if ($menu) {
            if (!$menu->image) {
                return '';
            }
            return route('display.image', [config("constants.IMAGES.MENU_IMAGE_PATH"), $menu->image]);
        }
    }

    // public function orderModifierItems()
    // {
    //     return $this->hasMany('App\Models\OrderMenuGroupItem', 'menu_id');
    // }

    public function orderModifierItems()
    {
        return $this->hasMany('App\Models\OrderMenuGroupItem', 'order_menu_item_id');
    }

    public function image($id)
    {
        return $this->hasOne('App\Models\MenuItem', 'menu_id')->where('menu_id', $id)->first();
    }

    public function modifier()
    {
        return $this->hasMany('App\Models\OrderMenuGroup', 'order_menu_item_id');
    }

    public function modifier_group()
    {
        return $this->hasOne('App\Models\OrderMenuGroup', 'order_menu_item_id');
    }

    public function menuItems()
    {
        return $this->hasMany('App\Models\MenuItem', 'menu_id', 'menu_id');
    }
}
