<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerFcmTokens extends Model
{
    protected $table = 'customer_fcm_tokens';

    protected $primaryKey = 'customer_fcmtoken_id';

    protected $fillable = ['uid', 'fcm_id', 'device'];
}
