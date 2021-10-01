<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModifierGroupItem extends Model
{
    protected $primaryKey = 'modifier_item_id';
    protected $table = "modifier_groups_items";
    protected $appends = ['modifier_group_name'];

    public function modifierGroup()
    {
        return $this->belongsTo('App\Models\ModifierGroup','modifier_group_id');
    }

    public function getModifierGroupNameAttribute()
    {
        $modifier = ModifierGroupItem::with('modifierGroup')->where('modifier_item_id',$this->modifier_item_id)->first();
        return $modifier->modifierGroup->modifier_group_name;
    }
}
