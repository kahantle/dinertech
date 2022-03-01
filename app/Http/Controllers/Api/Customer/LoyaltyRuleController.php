<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyRule;
use App\Models\LoyaltyRuleItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Config;
use Validator;
use Auth;

class LoyaltyRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $totalPoints = Auth::user()->total_points;
            $loyalties = LoyaltyRule::where('restaurant_id',$request->post('restaurant_id'))->get(['rules_id','restaurant_id','point']);
            if($loyalties->count() != 0){
                foreach($loyalties as $loyaltyKey =>$loyalty){
                    $results[$loyaltyKey] = $loyalty;
                    $items = LoyaltyRuleItem::with('menuItems')->where('loyalty_rule_id',$loyalty->rules_id)->get();
                    foreach($items as $key => $menuItems){
                        foreach($menuItems->menuItems as $menu => $item){
                            if($loyalty->point > $totalPoints){
                                $item['loyalty_status'] = Config::get('constants.LOYALTY_MENU_STATUS.NOT_ELIGIBLE');
                            }else {
                                $item['loyalty_status'] = Config::get('constants.LOYALTY_MENU_STATUS.ELIGIBLE');
                            }
                            $menus[$menu] = $item;
                        }
                        $results[$loyaltyKey]['menuItems'] = $menus;
                    }
                }
            }else{
                $results = [];
            }
            return response()->json(['total_points' => $totalPoints,'loyalties' => $results, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
