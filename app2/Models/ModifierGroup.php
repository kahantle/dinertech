<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModifierGroup extends Model
{
    protected $primaryKey = 'modifier_group_id';

    public function modifier_item()
    {
        return $this->hasMany('App\Models\ModifierGroupItem', 'modifier_group_id');
    }
}
