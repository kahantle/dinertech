<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loyalty extends Model
{
    protected $table = 'restaurant_loyalties';

    protected $primaryKey = 'loyalty_id';

    /**
     * Get all of the categories for the Loyalty
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(LoyaltyCategory::class, 'loyalty_id', 'loyalty_id');
    }
}
