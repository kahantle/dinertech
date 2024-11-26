<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyCategory extends Model
{
    protected $table = 'restaurant_loyalties_categories';

    protected $primaryKey = 'loyalty_category_id';
}
