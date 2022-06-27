<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_menu_items';

    protected $primaryKey = 'cart_menu_item_id';

    protected $appends = ['image_path'];
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
        $menu = $this->image($this->menu_id);
        if($menu){
            if(!$menu->item_img){
                return '';
            }
            return route('display.image', [config("constants.IMAGES.MENU_IMAGE_PATH"), $menu->item_img]);
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
