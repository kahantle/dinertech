<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyRuleItem extends Model
{
    protected $table = 'restaurant_loyalty_rules_items';

    protected $primaryKey = 'rule_item_id';

    /**
     * Get all of the categories for the LoyaltyRuleItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasOne(Category::class, 'category_id', 'category_id');
    }

    /**
     * Get all of the comments for the LoyaltyRuleItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'menu_id');
    }

    
    /**
     * Get the user associated with the LoyaltyRuleItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function loyaltyRule()
    {
        return $this->hasOne(LoyaltyRule::class, 'rules_id', 'loyalty_rule_id');
    }
    

}
