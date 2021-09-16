<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    //
    protected $primaryKey = 'customer_address_id';

    protected $fillable = ['uid', 'address', 'state', 'city', 'zip', 'lat', 'long', 'type'];

    public function getTypeAttribute($value)
    {
        return ucfirst($value);
    }
}
