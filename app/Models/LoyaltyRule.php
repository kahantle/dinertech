<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyRule extends Model
{
    protected $table = 'restaurant_loyalty_rules';

    protected $primaryKey = 'rules_id';

    /**
     * Get all of the items for the LoyaltyRule
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rulesItems()
    {
        return $this->hasMany(LoyaltyRuleItem::class, 'loyalty_rule_id', 'rules_id')->with(['categories', 'menuItems']);
    }

    // /**
    //  * Get all of the comments for the LoyaltyRule
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
    //  */
    // public function rulesItems()
    // {
    //     return $this->hasManyThrough(LoyaltyRuleItem::class, Category::class, 'category_id', 'loyalty_rule_id', 'rules_id');
    // }

}
