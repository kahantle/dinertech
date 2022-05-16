<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'cart_id';

    protected $appends = ['menu_with_out_total','menu_with_total'];
    
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


    public function getMenuWithOutTotalAttribute(){
        return $this->cartMenuItems->sum('menu_price');
    }

    public function getMenuWithTotalAttribute(){
        return $this->cartMenuItems->sum('menu_total');
    }
}
