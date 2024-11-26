<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyRule;
use App\Models\LoyaltyCategory;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loyalty;
use App\Models\Category;
use Config;
use Toastr;

class LoyaltiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::find($user_id);
        if ($user->loyalty_subscription == Config::get('constants.SUBSCRIPTION.ACTIVE')) {
            $uid = $user->uid;
            $restaurant = Restaurant::with(['subscriptions' => function($subscription){
                $subscription->with('subscription')->where('subscription_plan',Config::get('constants.SUBSCRIPTION_PLAN.3'))->first();
            }])->where('uid', $uid)->first();
            // dd($restaurant);
            $data['subscription'] = array();
            foreach($restaurant->subscriptions as $subscription){
                $data['subscription']['stripe_subscription_id'] = $subscription->stripe_subscription_id;
                $data['subscription']['price'] = $subscription->subscription->price;
                $data['subscription']['type'] = $subscription->subscription->subscription_type;
                if($subscription->status == Config::get('constants.STATUS.SCHEDULE')){
                    $data['subscription']['start_date'] = \Carbon\Carbon::parse($subscription->start_date)->subMonths()->format('M d Y');
                    $data['subscription']['end_date'] = \Carbon\Carbon::parse($subscription->start_date)->format('M d Y');
                }else{
                    $data['subscription']['start_date'] = \Carbon\Carbon::parse($subscription->start_date)->format('M d Y');
                    $data['subscription']['end_date'] = \Carbon\Carbon::parse($subscription->end_date)->format('M d Y');
                }
            }
            $data['categories'] = Category::with('category_item')->where('restaurant_id', $restaurant->restaurant_id)->get();
            $data['loyalties'] = Loyalty::where('restaurant_id',$restaurant->restaurant_id)->get();
            $loyaltyRules = LoyaltyRule::with('rulesItems')->where('restaurant_id', $restaurant->restaurant_id)->get();
            // dd($loyaltyRules);
            foreach($loyaltyRules as $loyaltyItems)
            {
                foreach($loyaltyItems->rulesItems as $items)
                {
                    foreach ($items->menuItems as $menu)
                    {
                        if($items->category_id == $menu->category_id)
                        {
                            $menus[$items->loyalty_rule_id][$items->categories->category_name][] = $menu->item_name;
                            $menuItems = $menus;
                        }
                    }
                }
            }
            // dd($menuItems);
            $data['loyaltyRules'] = $loyaltyRules;
            $data['user_id'] = $user_id;
            $data['rulesItems'] = (isset($menuItems)) ? $menuItems : [] ;
            return view('loyalty.mobile_view.list',$data);
        } else {
            echo "Please purchase loyalty subscription !";
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {
        try {

            $user = User::find($user_id);
            $uid = $user->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();

            if($request->post('loyaltyId') != null){
                $loyalty = Loyalty::where('loyalty_id',$request->post('loyaltyId'))->where('restaurant_id',$restaurant->restaurant_id)->first();
                $loyalty->point = $request->post('point');
                $message = 'Loyalty update successfully.';

                if($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.NO_OF_ORDERS')){
                    $loyalty->no_of_orders = $request->post('no_of_order');
                    $loyalty->save();
                    Toastr::success($message, '', Config::get('constants.toster'));
                }

                if($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.AMOUNT_SPENT')){
                    $loyalty->amount = $request->post('amount');
                    $loyalty->save();
                    Toastr::success($message, '', Config::get('constants.toster'));
                }

                if($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED')){
                    $loyalty->point = $request->post('point');
                    $loyalty->save();
                    $categories = $request->post('categories');
                    LoyaltyCategory::where('loyalty_id',$request->post('loyaltyId'))->delete();
                    foreach ($categories as $key => $value) {
                        $loyaltyCategory = new LoyaltyCategory;
                        $loyaltyCategory->restaurant_id = $restaurant->restaurant_id;
                        $loyaltyCategory->uid = $uid;
                        $loyaltyCategory->loyalty_id = $request->post('loyaltyId');
                        $loyaltyCategory->category_id = $value;
                        $loyaltyCategory->save();
                    }
                    Toastr::success($message, '', Config::get('constants.toster'));
                }
            }else{
                $loyalty = new Loyalty;
                $loyalty->restaurant_id = $restaurant->restaurant_id;
                $loyalty->uid = $uid;
                $loyalty->status = Config::get('constants.STATUS.INACTIVE');
                $loyalty->point = $request->post('point');
                $message = 'Loyalty add successfully.';
                if($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.NO_OF_ORDERS')){
                    $loyalty->loyalty_type = Config::get('constants.LOYALTY_TYPE.NO_OF_ORDERS');
                    $loyalty->no_of_orders = $request->post('no_of_order');
                    $loyalty->save();
                    Toastr::success($message, '', Config::get('constants.toster'));
                }

                if ($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.AMOUNT_SPENT')) {
                    $loyalty->loyalty_type = Config::get('constants.LOYALTY_TYPE.AMOUNT_SPENT');
                    $loyalty->amount = $request->post('amount');
                    $loyalty->save();
                    Toastr::success($message, '', Config::get('constants.toster'));
                }

                if ($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED')) {
                    $loyalty->loyalty_type = Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED');
                    $loyalty->save();

                    $categories = $request->post('categories');
                    foreach ($categories as $key => $value) {
                        $loyaltyCategory = new LoyaltyCategory;
                        $loyaltyCategory->restaurant_id = $restaurant->restaurant_id;
                        $loyaltyCategory->uid = $uid;
                        $loyaltyCategory->loyalty_id = $loyalty->loyalty_id;
                        $loyaltyCategory->category_id = $value;
                        $loyaltyCategory->save();
                    }
                }
            }
            return redirect()->route('mobile_view.loyalties.list', $user_id);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id, Request $request)
    {
        $uid = User::find($user_id)->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();

        $loyaltyId = $request->post('loyaltyId');
        $loyaltyType = $request->post('loyaltyType');
        $loyalty = Loyalty::where('loyalty_id',$loyaltyId)->where('loyalty_type',$loyaltyType)->where('restaurant_id',$restaurant->restaurant_id);
        if($loyaltyType == Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED')){
            $loyalty = $loyalty->with('categories')->first();
        }else{
            $loyalty = $loyalty->first();
        }
        $data = ['success' => true,'loyalty' => $loyalty];
        return response()->json($data, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $user_id)
    {
        try {
            $loyaltyId = $request->post('loyaltyId');
            $loyalty = Loyalty::where('loyalty_id',$loyaltyId)->first();
            if($loyalty->status == Config::get('constants.STATUS.ACTIVE')){
                return "This loyalty program is active.Please inactive first !";
            }else{
                if($loyalty->loyalty_type == Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED')){
                    if($loyalty->delete()){
                        $message = 'Loyalty delete successfully.';
                        LoyaltyCategory::where('loyalty_id',$loyaltyId)->delete();
                    }
                }else{
                    if($loyalty->delete()){
                        $message = 'Loyalty delete successfully.';
                    }
                }
            }
            return redirect()->route('mobile_view.loyalties.list', $user_id);
        } catch (\Throwable $th) {
            Toastr::error('Some error in loyalty delete.', '', Config::get('constants.toster'));
            echo "Some error in loyalty delete";
        }
    }

    public function changeStatus(Request $request, $user_id)
    {
        $loyaltyId = $request->post('loyaltyId');
        $uid = $user_id;
        $restaurant = Restaurant::where('uid', $uid)->first();
        $loyalty = Loyalty::where('loyalty_id',$loyaltyId)->where('restaurant_id',$restaurant->restaurant_id)->first();
        $loyalty->status == 'ACTIVE' ? $loyalty->update(['status' => Config::get('constants.STATUS.INACTIVE')]) : $loyalty->update(['status' => Config::get('constants.STATUS.ACTIVE')]);
        // Loyalty::where('loyalty_id',$loyaltyId)->where('restaurant_id',$restaurant->restaurant_id)->update(['status' => Config::get('constants.STATUS.ACTIVE')]);
        return response()->json(['success' => true,'message' => 'Status Change Successfully.'],200);

    }
}
