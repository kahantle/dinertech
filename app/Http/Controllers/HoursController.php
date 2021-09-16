<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HourRequest;
use App\Models\User;
use App\Models\RestaurantHours;
use App\Models\Restaurant;
use Config;
use Auth;
use Toastr;
use DB;

class HoursController extends Controller
{
    public function index()
    {
      $uid = Auth::user()->uid;
      $restaurant = Restaurant::where('uid', $uid)->first();
      $hoursdata = RestaurantHours::select("hours_group_id","opening_time","closing_time",DB::raw("GROUP_CONCAT(day) as `groupDays`"))
      ->groupBy('hours_group_id')
      ->groupBy('opening_time')
      ->groupBy('closing_time')
      ->where('restaurant_id', $restaurant->restaurant_id)
      ->get();
      return view('hours.index',compact('hoursdata'));
    }

    public function add()
    {
      $uid = Auth::user()->uid;
      $restaurant = Restaurant::where('uid', $uid)->first();
      $restaurantHours = RestaurantHours::where('restaurant_id',$restaurant->restaurant_id)->pluck('day')->toArray();
      return view('hours.add',compact('restaurantHours'));
    }

    public function store(HourRequest $request)
    {
      $uid = Auth::user()->uid;
      $restaurant = Restaurant::where('uid', $uid)->first();
        try {
          if($request->post('day') ){
            $countRestaurantHours = RestaurantHours::where('restaurant_id',$restaurant->restaurant_id)
                ->orderBy('hours_group_id','desc')
                ->get();

                $groupId = ($countRestaurantHours)?$countRestaurantHours->count()+1:1;
                $data=array();
                foreach ($request->post('day') as $key => $value) {
                  $data[$key]['restaurant_id'] = $restaurant->restaurant_id;
                  $data[$key]['hours_group_id'] = $groupId;
                  $data[$key]['day'] =  strtolower($value);
                  $data[$key]['opening_time'] = $request->post('opening_hours');
                  $data[$key]['closing_time'] = $request->post('closing_hours');
                }
                $hour = new RestaurantHours;
                if($hour->insert($data)){
                  Toastr::success('Hours added successfully.','', Config::get('constants.toster'));
                  return redirect()->route('hours');
                }
          }else{
            Toastr::error('Please select at least one day.','', Config::get('constants.toster'));
            return redirect()->route('add.hour.post');
          }
        } catch (\Throwable $th) {
          Toastr::error('Hours not added successfully.','', Config::get('constants.toster'));
          return redirect()->route('hours');
        }
    }

  public function edit($id)
  {
    $uid = Auth::user()->uid;
    $restaurant = Restaurant::where('uid', $uid)->first();
    $hoursdata = RestaurantHours::select("hours_group_id","opening_time","closing_time")
    ->groupBy('hours_group_id')
    ->groupBy('opening_time')
    ->groupBy('closing_time')
    ->where('hours_group_id', $id)
    ->where('restaurant_id', $restaurant->restaurant_id)
    ->get();
    $days = RestaurantHours::where('hours_group_id', $id)
    ->where('restaurant_id', $restaurant->restaurant_id)
    ->pluck('day')->toArray();

    $restaurantHours = RestaurantHours::where('hours_group_id','!=', $id)
    ->where('restaurant_id',$restaurant->restaurant_id)->pluck('day')->toArray();
  
    return view('hours.edit',compact('days','hoursdata','restaurantHours'));
  }

  public function update(HourRequest $request)
  {
    $uid = Auth::user()->uid;
    $restaurant = Restaurant::where('uid', $uid)->first();
    $hourdata = RestaurantHours::where('hours_group_id', $request->hidden_id)->where('restaurant_id', $restaurant->restaurant_id)->delete();
    try {
         $days='';
         $groupId = $request->hidden_id;
         $data=array();
         foreach ($request->post('day') as $key => $value) {
          $data[$key]['restaurant_id'] = $restaurant->restaurant_id;
          $data[$key]['hours_group_id'] =$request->hidden_id;
          $data[$key]['day'] =  strtolower($value);
          $data[$key]['opening_time'] = $request->post('opening_hours');
          $data[$key]['closing_time'] = $request->post('closing_hours');
        }
        $hour = new RestaurantHours;
        if($hour->insert($data)){
          Toastr::success('Hours updated successfully.','', Config::get('constants.toster'));
          return redirect()->route('hours');
        }
    } catch (\Throwable $th) {
      dd($th);
        $errors['success'] = false;
        $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
        if ($request->debug_mode == 'ON') {
          $errors['debug'] = $th->getMessage();
        }
        Toastr::error('Hours not updated successfully.','', Config::get('constants.toster'));
        return redirect()->route('hours');
      }   
  }

  public function delete($id)
  {
      try {
        $alert =['Hours does not delete successfully','', Config::get('constants.toster')];
        $category = RestaurantHours::where('hours_group_id', $id);
        if($category){
          $category->delete();
          $alert =['Hours delete successfully','', Config::get('constants.toster')];
        }
        return response()->json(['route'=>route('hours'),'alert'=>$alert,'success' => true], 200);
      } catch (\Throwable $th) {
        $errors['success'] = false;
        $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
        return response()->json($errors, 401);
      }
    }
}

