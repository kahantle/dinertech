<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CartItem extends Model
{
    protected $table = 'cart_menu_items';

    protected $primaryKey = 'cart_menu_item_id';

    protected $appends = ['image_path','loyalty_enable','point','loyaltyid'];
    /**
     * Get all of the menu groups for the CartItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartMenuGroups()
    {
        return $this->hasMany(CartMenuGroup::class, 'cart_menu_item_id');
    }

    public function getImagePathAttribute(){
        return $menu = $this->image($this->menu_id);
        if($menu){
            if(!$menu->item_img){
                return '';
            }
            return route('display.image', [config("constants.IMAGES.MENU_IMAGE_PATH"), $menu->item_img]);
        }
    }

    public function getLoyaltyEnableAttribute()
    {
        $menuid = $this->menu_id;
        $redeem_status=$this->redeem_status;

        $loyaltyitem=LoyaltyRuleItem::where('menu_id', $menuid)->exists();
        $uid = Auth::id();
        $user = User::where('uid', $uid)->first();
        $userPoint = $user->total_points;

        $cartitems=CartItem::where('menu_id',$menuid)->where('redeem_status',0)->get();

        $cartmenuitems=CartItem::select('cart_menu_items.*')->where('redeem_status',1)->get();


        // $cartmenuitem=CartItem::select('cart_menu_items.*')->join('restaurant_loyalty_rules', 'cart_menu_items.menu_id', '=', 'restaurant_loyalty_rules.rules_id')->get();


        if($cartitems){
            foreach($cartitems as $cartitem)
            {
                if($cartitem->is_loyalty == 1)
                {
                    return 0;
                }
                elseif($cartitem->redeem_status == 1)
                {
                    return 0;
                }
                else{
                    if ($loyaltyitem) {
                        return (int)$cartitem->point<=(int)$userPoint ? 1 : 0;
                    }
                    else{
                        return 0;
                    }
                }
            }
        }
        elseif($cartmenuitems){
            foreach($cartmenuitems as $cartmenuitems)
            {
                return 0;
            }
        }
    }

    public function getPointAttribute()
    {
        $menuid= $this->menu_id;
        $cartitems=CartItem::where('menu_id',$menuid)->get();
        $loyaltyitem=LoyaltyRuleItem::with('loyaltyRule:rules_id,point')->where('menu_id',$menuid)->get();
        foreach($cartitems as $cartitem)
        {
            foreach($loyaltyitem as $loyalty)
            {
                $uid = Auth::id();
                $user=User::where('uid',$uid)->first();
                $point=$user->total_points;
                $loyaltyrule=LoyaltyRule::get();
                foreach($loyaltyrule as $rule)
                {
                    $points=$rule->point;
                    if($cartitem->is_loyalty == 1)
                    {
                        return NULL;
                    }
                    else{
                        if($point > $points)
                        {
                            return $loyalty->loyaltyRule->point;
                        }
                    }
                }
            }
        }

        // $uid = Auth::id();
        // $user=User::where('uid',$uid)->first();
        // $point=$user->total_points;
        // $loyaltyrule=LoyaltyRule::get();
        // foreach($loyaltyrule as $rule)
        // {
        //     $points=$rule->point;
        //     if($point > $points)
        //     {
        //         return $loyaltyitem;
        //     }
        // }
    }

    public function getLoyaltyidAttribute()
    {
        $menuid= $this->menu_id;
        $cartitems=CartItem::where('menu_id',$menuid)->get();
        $loyaltyitem=LoyaltyRuleItem::with('loyaltyRule:rules_id,point')->where('menu_id',$menuid)->get();
        foreach($cartitems as $cartitem)
        {
            foreach($loyaltyitem as $loyalty)
            {
                $uid = Auth::id();
                $user=User::where('uid',$uid)->first();
                $point=$user->total_points;
                $loyaltyrule=LoyaltyRule::get();
                foreach($loyaltyrule as $rule)
                {
                    $points=$rule->point;
                    if($cartitem->is_loyalty == 1)
                    {
                        return NULL;
                    }
                    else{
                        if((int)$point > (int)$points)
                        {
                            return $loyalty->loyaltyRule->rules_id;
                        }
                    }
                }
            }
        }
    }


    /**
     * Get the menu image associated with the CartItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image($id)
    {
        return $this->hasOne(MenuItem::class, 'menu_id')->where('menu_id', $id)->first();
    }

}
