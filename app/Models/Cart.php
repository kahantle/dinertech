<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'cart_id';

    protected $appends = ['modifier_with_out_menu_total','modifier_with_menu_total'];

    /**
     * Get all of the menu items for the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartMenuItems()
    {
        return $this->hasMany(CartItem::class,  'cart_id'); 
    }

    public function cartMenuModifierItems(){
        return $this->hasMany(CartMenuGroupItem::class,  'cart_id');
    }

    public function promotion()
    {
        return $this->hasOne(Promotion::class,'promotion_id','promotion_id');
    }

    public function getModifierWithOutMenuTotalAttribute(){
        // return $this->cartMenuItems->where('modifier_total',0.00)->sum('menu_price');
        return $this->cartMenuItems->sum('menu_price');
    }

    public function getModifierWithMenuTotalAttribute(){
        // return $this->cartMenuItems->where('modifier_total',0.00)->sum('menu_total');
        return $this->cartMenuItems->sum('menu_total');
    }
}
