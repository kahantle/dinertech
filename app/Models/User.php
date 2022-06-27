<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $appends = ['full_name', 'image_path'];
    protected $primaryKey = 'uid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email_id', 'mobile_number', 'profile_image', 'fcm_id', 'device', 'status', 'is_verified_at', 'password', 'otp', 'otp_valid_time', 'app_notifications', 'chat_notifications', 'location_tracking', 'total_points'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function address()
    {
        return $this->hasMany('App\Models\CustomerAddress', 'uid')->select(['customer_address_id', 'uid', 'address', 'city', 'zip', 'state']);
    }

    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant', 'uid')->select(['restaurant_id', 'uid', 'restaurant_name', 'restaurant_address', 'restaurant_city', 'restaurant_state', 'restaurant_state','sales_tax']);
    }

    public function restaurant_user()
    {
        return $this->hasMany('App\Models\RestaurantUser', 'uid');
    }

    public function getProfileImagePathAttribute()
    {
        if ($this->profile_image) {
            return route('display.image', [config("constants.IMAGES.RESTAURANT_USER_IMAGE_PATH"), $this->profile_image]);
        }
    }
    public function getImagePathAttribute()
    {
        if ($this->profile_image) {
            return route('display.image', [config("constants.IMAGES.USER_IMAGE_PATH"), $this->profile_image]);
        }
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'uid');
    }

    public function routeNotificationForFcm()
    {
        $fcm_ids = CustomerFcmTokens::where('uid', $this->uid)->pluck('fcm_id')->toArray();
        // return $this->fcm_id;
        return $fcm_ids;
    }

    // public function getMobileNumberAttribute($value)
    // {
    //     return sprintf("%s-%s-%s",substr($value, 2, 3),substr($value, 5, 3),substr($value, 8));
    // }

}
