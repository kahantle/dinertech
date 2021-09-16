<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionType extends Model
{
    protected $primaryKey = 'promotion_type_id';

    public function getPromotionNameAttribute($value)
    {
        if($value)
        {
            return str_replace(array("\n\r", "\n", "\r"),'',$value);
        }
    }

    public function getPromotionDetailsAttribute($value)
    {
        if($value)
        {
            return str_replace(array("\n\r", "\n", "\r"),'',$value);
        }
    }
}
