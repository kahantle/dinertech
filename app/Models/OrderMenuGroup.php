<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OrderMenuGroup extends Model
{
    protected $primaryKey = 'order_modifier_group_id';
    protected $table = 'order_menu_modifier_group';

    public function orderMenuGroupItem()
    {
        return $this->hasMany('App\Models\OrderMenuGroupItem', 'order_modifier_group_id');
    }

}
