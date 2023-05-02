<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ModifierGroup extends Model
{
    protected $primaryKey = 'modifier_group_id';

    public function modifier_item()
    {
        return $this->hasMany('App\Models\ModifierGroupItem', 'modifier_group_id');
    }

    public function modifier_item_custome()
    {
        return $this->hasMany('App\Models\ModifierGroupItem', 'modifier_group_id')->orderBy(DB::raw('ISNULL(sequence), sequence'), 'ASC');
    }
}
