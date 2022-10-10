<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModifierGroup;

class CartMenuGroup extends Model
{
    protected $table = 'cart_menu_groups';

    protected $primaryKey = 'cart_modifier_group_id';

    /**
     * Get all of the cart menu group items for the CartMenuGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartMenuGroupItems()
    {
        return $this->hasMany(CartMenuGroupItem::class, 'cart_modifier_group_id')->select(['cart_modifier_menu_id','cart_menu_item_id','cart_modifier_group_id','modifier_group_item_name','modifier_group_item_price', 'modifier_item_id','modifier_group_id']);
    }

    public function modifierGroup()
    {
        return $this->hasMany(ModifierGroup::class,"modifier_group_id","modifier_group_id");
    }

}
