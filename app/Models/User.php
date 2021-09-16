<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    // use HasApiTokens, Notifiable;
    use HasApiTokens,Notifiable;
    protected $appends = ['full_name','image_path'];
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'name', 'email', 'password',
        'email_id',
        'password',
        'first_name',
        'last_name',
        'role',
        'mobile_number',
        'profile_image',
        'fcm_id',
        'status',
        'is_verified_at',
        'otp',
        'otp_valid_time'
    ];

    protected $primaryKey = 'uid';
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
        return $this->hasOne('App\Models\Restaurant', 'uid')->select(['restaurant_id', 'uid', 'restaurant_name', 'restaurant_address', 'restaurant_city', 'restaurant_state', 'restaurant_state']);
    }

    public function restaurant_user()
    {
        return $this->hasMany('App\Models\RestaurantUser', 'uid');
    }

    public function getProfileImagePathAttribute()
    {
        if($this->profile_image){
            return route('display.image',[config("constants.IMAGES.RESTAURANT_USER_IMAGE_PATH"),$this->profile_image]);
        }
    }
    public function getImagePathAttribute()
    {
        if($this->profile_image){
            return route('display.image',[config("constants.IMAGES.USER_IMAGE_PATH"),$this->profile_image]) ;
        }
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'uid');
    }

}
