<?php

namespace App\Exports;

use App\Models\User;
use App\Models\RestaurantUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $restaurantId;

    public function __construct(int $restaurantId)
    {
        $this->restaurantId = $restaurantId;
    }

    public function headings() : array
    {
        return ['Full Name','Email','Mobile Number'];
    }

    public function collection()
    {
        $restaurantId = $this->restaurantId;
        $restaurantUsers = RestaurantUser::with('users')->where('restaurant_id',$restaurantId)->get();
        $collection = array();
        if(!empty($restaurantUsers))
        {
            foreach($restaurantUsers as $users)
            {
                foreach($users->users as $user)
                {
                    $collection[] = ['full_name' => $user->full_name,'email' => $user->email_id,'mobile_number' => $user->mobile_number];
                }
            }
        }
        return  collect($collection);
    }
}
