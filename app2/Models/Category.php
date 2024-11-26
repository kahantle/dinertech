<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    protected $appends = ['image_path'];
    public function getImagePathAttribute()
    {
        if (($this->image) && ($this->image != null)) {
            return route('display.image', [config("constants.IMAGES.CATEGORY_IMAGE_PATH"), $this->image]);
        }
    }

    public function getDefaultImage()
    {
        return route('display.image', [config("constants.IMAGES.CATEGORY_IMAGE_PATH"), 'default.png']);
    }

    public function category_item()
    {
        return $this->hasMany('App\Models\MenuItem', 'category_id');
    }
}
