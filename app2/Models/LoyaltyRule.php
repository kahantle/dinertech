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


    // public function loyaltyRulesItems()
    // {
    //     return $this->hasMany(LoyaltyRuleItem::class, 'loyalty_rule_id', 'rules_id')->with('menuItems');
    // }

    /**
     * Get all of the comments for the LoyaltyRule
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function menuItems()
    {
        return $this->hasManyThrough(
              'App\Models\MenuItem',
              'App\Models\LoyaltyRuleItem',
              'menu_id',
              'menu_id',
              'rules_id',
              'loyalty_rule_id',
        );
    }

}
