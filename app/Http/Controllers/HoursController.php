<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HourRequest;
use App\Models\User;
use App\Models\RestaurantHours;
use App\Models\RestaurantHoursTimes;
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
      $hoursdata = RestaurantHours::select("restaurant_hour_id","hours_group_id","opening_time","closing_time",DB::raw("GROUP_CONCAT(day) as `groupDays`"))
      ->with('allTimes')
      ->groupBy('hours_group_id')
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
        // foreach(json_decode($request->groupOfTime) as $timevalue){
        //     dd($timevalue);
        // }

      $uid = Auth::user()->uid;
      $restaurant = Restaurant::where('uid', $uid)->first();
        try {
          if($request->post('day') ){
              $countRestaurantHours = RestaurantHours::where('restaurant_id',$restaurant->restaurant_id)
                ->orderBy('hours_group_id','desc')
                ->get();
                $groupId = ($countRestaurantHours)?$countRestaurantHours->count()+1:1;
                foreach ($request->post('day') as $key => $value) {
                  $hour = new RestaurantHours;
                  $hour->restaurant_id = $restaurant->restaurant_id;
                  $hour->hours_group_id = $groupId;
                  $hour->day            = strtolower($value);
                  $hour->save();

                    foreach(json_decode($request->groupOfTime) as $timevalue){

                        $hour_time = new RestaurantHoursTimes;
                        $hour_time->restaurant_hour_id = $hour->restaurant_hour_id;
                        $hour_time->hours_group_id = $groupId;
                        $hour_time->restaurant_id = $restaurant->restaurant_id;
                        $hour_time->opening_time = $timevalue->start;
                        $hour_time->closing_time = $timevalue->end;
                        $hour_time->hour_type = $timevalue->type;
                        // $hour_time->opening_time = date("g:i A", strtotime($timeValue));
                        // $hour_time->closing_time = date("g:i A", strtotime($request->post('closing_hours')[$timeKey]));
                        $hour_time->save();
                    }

                    //   foreach($request->post('opening_hours') as $timeKey => $timeValue){
                    //       $hour_time = new RestaurantHoursTimes;
                    //       $hour_time->restaurant_hour_id = $hour->restaurant_hour_id;
                    //       $hour_time->hours_group_id = $groupId;
                    //       $hour_time->restaurant_id = $restaurant->restaurant_id;
                    //       $hour_time->opening_time = date("g:i A", strtotime($timeValue));
                    //       $hour_time->closing_time = date("g:i A", strtotime($request->post('closing_hours')[$timeKey]));
                    //       $hour_time->save();
                    //   }
                }

                Toastr::success('Hours added successfully.','', Config::get('constants.toster'));
                return redirect()->route('hours');
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
    $hoursdata = RestaurantHours::select("restaurant_hour_id","hours_group_id","opening_time","closing_time")
    ->with("allTimes")
    ->groupBy('hours_group_id')
    ->where('hours_group_id', $id)
    ->where('restaurant_id', $restaurant->restaurant_id)
    ->get();
    foreach($hoursdata as $hour){
      $hoursdata = $hour->allTimes;
    }
    $hours_group_id = $id;
    $days = RestaurantHours::where('hours_group_id', $id)
    ->where('restaurant_id', $restaurant->restaurant_id)
    ->pluck('day')->toArray();

    $restaurantHours = RestaurantHours::where('hours_group_id','!=', $id)
    ->where('restaurant_id',$restaurant->restaurant_id)->pluck('day')->toArray();

    return view('hours.edit',compact('days','hoursdata','restaurantHours','hours_group_id'));
  }

  public function update(HourRequest $request)
  {
    $uid = Auth::user()->uid;
    $restaurant = Restaurant::where('uid', $uid)->first();
    $hourdata = RestaurantHours::where('hours_group_id', $request->hidden_id)->where('restaurant_id', $restaurant->restaurant_id)->delete();
    $hourTimedata = RestaurantHoursTimes::where('hours_group_id', $request->hidden_id)->where('restaurant_id', $restaurant->restaurant_id)->delete();
    try {
         $days='';
         $groupId = $request->hidden_id;
         foreach ($request->post('day') as $key => $value) {
          $hour = new RestaurantHours;
          $hour->restaurant_id = $restaurant->restaurant_id;
          $hour->hours_group_id = $groupId;
          $hour->day = strtolower($value);
          $hour->save();

          foreach($request->post('opening_hours') as $timeKey => $timeValue){
              $hour_time = new RestaurantHoursTimes;
              $hour_time->restaurant_hour_id = $hour->restaurant_hour_id;
              $hour_time->hours_group_id = $groupId;
              $hour_time->restaurant_id = $restaurant->restaurant_id;
              $hour_time->opening_time = $timeValue;
              $hour_time->closing_time = $request->post('closing_hours')[$timeKey];
              $hour_time->save();
          }
        }
        Toastr::success('Hours updated successfully.','', Config::get('constants.toster'));
        return redirect()->route('hours');

    } catch (\Throwable $th) {
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
          RestaurantHoursTimes::where('hours_group_id', $id)->delete();
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

  public function delete_time($id){
    try {
        $message = "Time does not delete successfully.";
        $hour_time = RestaurantHoursTimes::where('restaurant_time_id', $id);
        if($hour_time){
          $hour_time->delete();
          $message = "Time delete successfully.";
        }
        Toastr::success($message,'', Config::get('constants.toster'));
        return redirect()->back();
      } catch (\Throwable $th) {
        Toastr::error('Time not delete successfully.','', Config::get('constants.toster'));
        return redirect()->back();
      }
  }
}

