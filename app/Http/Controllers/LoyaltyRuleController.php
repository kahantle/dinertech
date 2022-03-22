<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\LoyaltyRule;
use App\Models\LoyaltyRuleItem;
use App\Models\Restaurant;
use Auth;
use Config;
use DB;
use Illuminate\Http\Request;
use Toastr;

class LoyaltyRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            $data['categories'] = Category::with('category_item')->where('restaurant_id', $restaurant->restaurant_id)->get();
            $data['loyaltyRules'] = LoyaltyRule::with('rulesItems')->where('restaurant_id', $restaurant->restaurant_id)->get();
            // $data['loyaltyRules'] = $rules;
            // $data['ruleItems'] = $rules->pluck('rulesItems');
            return view('loyalty.rules', $data);

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
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
    public function store(Request $request)
    {
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();

            $categories = json_decode($request->post('categoryIds'));
            $items = json_decode($request->post('items'));
            DB::beginTransaction();

            $loyaltyRule = new LoyaltyRule;
            $loyaltyRule->restaurant_id = $restaurant->restaurant_id;
            $loyaltyRule->uid = $uid;
            $loyaltyRule->point = $request->post('point');
            $loyaltyRule->save();

            $lastRuleId = LoyaltyRule::where('restaurant_id', $restaurant->restaurant_id)->where('uid', $uid)->orderBy('rules_id', 'desc')->first();

            foreach ($categories as $category) {
                foreach ($items as $item) {
                    $rule_item = new LoyaltyRuleItem;
                    $rule_item->restaurant_id = $restaurant->restaurant_id;
                    $rule_item->loyalty_rule_id = $lastRuleId->rules_id;
                    $rule_item->category_id = $category;
                    $rule_item->menu_id = $item;
                    $rule_item->save();
                }
            }
            DB::commit();
            Toastr::success('Loyalty Rule add successfully.', '', Config::get('constants.toster'));
            return redirect()->route('loyalty.rules');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LoyaltyRule  $loyaltyRule
     * @return \Illuminate\Http\Response
     */
    public function show(LoyaltyRule $loyaltyRule)
    {
        //
    }

    public function edit($ruleId)
    {
        try {

            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            $data['categories'] = Category::with('category_item')->where('restaurant_id', $restaurant->restaurant_id)->get();
            $items = LoyaltyRuleItem::select('category_id', 'menu_id')->where('loyalty_rule_id', $ruleId)->get();
            $data['categoryIds'] = array_unique($items->pluck('category_id')->toArray());
            $data['itemIds'] = $items->pluck('menu_id')->toArray();
            $loyaltyRule = LoyaltyRule::withCount('rulesItems')->where('rules_id', $ruleId)->first();
            $response = ['success' => true, 'data' => $loyaltyRule, 'view' => view('loyalty.rule_item_edit', $data)->render()];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $data = ['error' => true, 'message' => $th->getMessage()];
            return response()->json($data, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            $categories = json_decode($request->post('categoryIds'));
            $items = json_decode($request->post('items'));
            dd($items);
            $loyaltyRule = LoyaltyRule::where('rules_id', $request->post('rule_id'))->first();
            $loyaltyRule->restaurant_id = $restaurant->restaurant_id;
            $loyaltyRule->uid = $uid;
            $loyaltyRule->point = $request->post('point');
            $loyaltyRule->save();

            LoyaltyRuleItem::where('loyalty_rule_id', $request->post('rule_id'))->delete();

            // DB::beginTransaction();

            foreach ($categories as $category) {
                foreach ($items as $item) {
                    $rule_item = new LoyaltyRuleItem;
                    $rule_item->restaurant_id = $restaurant->restaurant_id;
                    $rule_item->loyalty_rule_id = $request->post('rule_id');
                    $rule_item->category_id = $category;
                    $rule_item->menu_id = $item;
                    $rule_item->save();
                }
            }
            // DB::commit();

            Toastr::success('Loyalty Rule update successfully.', '', Config::get('constants.toster'));
            return redirect()->route('loyalty.rules');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }

    }

    /**
     * delete a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        try {
            $rule_id = $request->post('rule_id');
            $loyaltyRule = LoyaltyRule::find($rule_id);
            if ($loyaltyRule) {
                $ruleItem = LoyaltyRuleItem::where('loyalty_rule_id', $rule_id)->delete();
                $loyaltyRule->delete();
            }
            Toastr::success('Loyalty Rule delete successfully.', '', Config::get('constants.toster'));
            return redirect()->route('loyalty.rules');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
