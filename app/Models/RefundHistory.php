<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RefundHistory extends Model
{
    protected $primaryKey = 'refund_history_id';
    protected $table = 'refund_history';
    protected $fillable = [
        'restaurant_id', 'order_id', 'stripe_refund_id', 'is_partial_refund', 'stripe_refund_amount', 'refund_amount', 'refund_details_object', 'refund_object', 'is_active', 'is_delete'
    ];
}