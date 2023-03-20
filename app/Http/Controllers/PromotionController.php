<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ModifierGroupRequest;
use App\Http\Requests\PromotionRequest;
use App\Http\Requests\PromotionCartRequest;
use App\Http\Requests\PromotionFreedeliveryRequest;
use App\Http\Requests\PromotionPaymentmethodRequest;
use App\Models\PromotionType;
use App\Models\Promotion;
use App\Models\PromotionItem;
use App\Models\Restaurant;
use App\Models\MenuItem;
use App\Models\PromotionEligibleItem;
use App\Models\PromotionCategoryItem;
use App\Models\PromotionCategory;
use App\Models\Category;
use Config;
use Auth;
use Toastr;
use Carbon\Carbon;
use DateTime;

class PromotionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        $promotion = Promotion::where('restaurant_id', $restaurant->restaurant_id)->with('promotion_type')->orderByDesc('promotion_id')->paginate(Config::get('constants.PAGINATION_PER_PAGE'));
        return view('promotion.index',compact('promotion'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function details($id)
    {
        $uid = Auth::user()->uid;
        $promotion = Promotion::where('promotion_id', $id)->first();
        return view('promotion.details',);
    }


   public function type()
    {
        $promotionType = PromotionType::where('status','active')->get();
        return view('promotion.type',compact('promotionType'));
    }

    public function listTypeForm(Request $request){

        $type = $request->id;
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        $webview = 0;
        if($type==1){ //Done
            $promotion = [];
            return view('promotion.cart.add',compact('promotion','webview'));
        }else if($type==2){ //Done
            return view('promotion.discount_selected_item.add',compact('category','webview'));
        }else if($type==3){ //Done
            $promotion = [];
            return view('promotion.freedelivery.add',compact('promotion','webview'));
        }else if($type==4){ //Done
            $promotion = [];
            return view('promotion.paymentmethod.add',compact('promotion','webview'));
        }else if($type==5){ //Done
            return view('promotion.freeitem.add',compact('category','webview'));
        }else if($type==6){ // Done
            return view('promotion.getonefree.add',compact('category','webview'));
        }else if($type==7){
            return view('promotion.mealbundle.add',compact('category','webview'));
        }else if($type==8){ // Done
            return view('promotion.buytwothree.add',compact('category','webview'));
        }else if($type==9){ // Done
            return view('promotion.fixeddiscount.add',compact('category','webview'));
        }else if($type==10){
            return view('promotion.discountcombo.add',compact('category','webview'));
        }
    }

    public function editCart(Request $request){
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $webview = 0;
        return view('promotion.cart.edit',compact('promotion','webview'));
    }

    public function storeCart(Request $request){
        try {

            if($request->post('restaurant_user_id')){
                $uid = $request->post('restaurant_user_id');
            } else {
                $uid = Auth::user()->uid;
            }

            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }

            if($request->post('promotion_id')){
                $promotion = Promotion::where('promotion_id',$request->post('promotion_id'))->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }

            
                $restricted_days = Carbon::createFromFormat('m-d-Y', $request->post('restricted_days'))->format('Y-m-d');
                // dd($request->post('restricted_days'),$restricted_days);    
                // $restricteddays = $restricted_days->format('Y-m-d');
                // dd($restricted_days,$restricteddays);

            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 1 ;
            $promotion->promotion_code = ($request->post('promotion_code')) ? $request->post('promotion_code') : null;
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_details = ($request->post('promotion_details')) ? $request->post('promotion_details') : null;
            $promotion->discount_type = $request->post('discount_usd_percentage');
            $promotion->discount = $request->post('discount_usd_percentage_amount');
            $promotion->set_minimum_order = ($request->post('set_minimum_order'))?1:0;
            $promotion->set_minimum_order_amount = $request->post('set_minimum_order_amount');
            $promotion->client_type = $request->post('client_type');
            $promotion->order_type = $request->post('order_type');
            $promotion->only_selected_payment_method = ($request->post('only_selected_payment_method'))?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->post('only_selected_cash_delivery_person'))?1:0;
            $promotion->only_selected_cash = ($request->post('only_selected_cash'))?1:0;
            $promotion->only_once_per_client = ($request->post('only_once_per_client'))?0:1;
            $promotion->no_extra_charge_type = $request->post('no_extra_charge');
            $promotion->promotion_function = $request->post('promotion_function');
            $promotion->availability = $request->post('availability');
            $promotion->restricted_days = $restricted_days;
            $promotion->restricted_hours = $request->post('restricted_hours');
            if($request->post('restaurant_user_id')){
                $promotion->save();
                return redirect()->back();
            } else {
                if ($promotion->save()) {
                    Toastr::success( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }else{
                    Toastr::error( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }
        } catch (\Throwable $th) {
            dd($th);
            Toastr::error('Please try again something wrong.','', Config::get('constants.toster'));
            //return redirect()->route('promotion');
        }
    }


    public function editSelectedItem(Request $request){
        $uid = Auth::user()->uid;
        $webview = 0;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        return view('promotion.discount_selected_item.edit',compact('promotion','category','webview'));
    }

    public function storeSelectedItems(Request $request){
        try {
            if($request->post('restaurant_user_id')){
                $uid = $request->post('restaurant_user_id');
            } else{
                $uid = Auth::user()->uid;
            }
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->post('promotion_id')){
                PromotionEligibleItem::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategory::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategoryItem::where('promotion_id',$request->post('promotion_id'))->delete();
                $promotion = Promotion::where('promotion_id',$request->post('promotion_id'))->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }

            $restricted_days = Carbon::createFromFormat('m-d-Y', $request->post('restricted_days'))->format('Y-m-d');

            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 2 ;
            $promotion->promotion_code = ($request->post('promotion_code')) ? $request->post('promotion_code') : null;
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_details = ($request->post('promotion_details')) ? $request->post('promotion_details') : null;
            $promotion->discount_type =  Config::get('constants.DISCOUNT_TYPE.USD');
            $promotion->discount = $request->post('discount_usd_percentage_amount');
            $promotion->set_minimum_order = ($request->post('set_minimum_order'))?1:0;
            $promotion->set_minimum_order_amount = $request->post('set_minimum_order_amount');
            $promotion->client_type = $request->post('client_type');
            $promotion->no_extra_charge_type = $request->post('no_extra_charge');
            $promotion->order_type = $request->post('order_type');
            $promotion->only_selected_payment_method = ($request->post('only_selected_payment_method'))?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->post('only_selected_cash_delivery_person'))?1:0;
            $promotion->only_selected_cash = ($request->post('only_selected_cash'))?1:0;
            $promotion->only_once_per_client = ($request->post('only_once_per_client'))?0:1;
            $promotion->promotion_function = $request->post('promotion_function');
            $promotion->availability = $request->post('availability');
            $promotion->restricted_days = $restricted_days;
            $promotion->restricted_hours = $request->post('restricted_hours');
            if ($promotion->save()) {
                if(is_array($request->post('category'))){
                    $eligible_item = New PromotionEligibleItem;
                    $eligible_item->eligible_item_id  = 1;
                    $eligible_item->promotion_id = $promotion->promotion_id;
                    if($eligible_item->save()){
                        foreach($request->post('category') as $key=>$value){
                            $category = New PromotionCategory;
                            $category->promotion_id = $promotion->promotion_id;
                            $category->eligible_item_id  = 1;
                            $category->category_id = $key;
                            $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                            if($category->save()){
                                if(is_array($value)){
                                    foreach ($value as $key1 => $value1) {
                                        $categoryItem = New PromotionCategoryItem;
                                        $categoryItem->promotion_id = $promotion->promotion_id;
                                        $categoryItem->category_id = $key;
                                        $categoryItem->eligible_item_id  = 1;
                                        $categoryItem->promotion_category_id = $category->promotion_category_id;
                                        $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                        $categoryItem->item_id = $key1;
                                        $categoryItem->save();
                                    }
                                }
                            }
                        }
                    }
                }

                if($request->post('restaurant_user_id'))
                {
                    return redirect()->back();
                }
                else
                {
                    Toastr::success( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }else{
                if($request->post('restaurant_user_id'))
                {
                    return redirect()->back();
                }
                else
                {
                    Toastr::error( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }
        } catch (\Throwable $th) {

            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }

    public function editFreeMethod(Request $request){
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $webview = 0;
        return view('promotion.freedelivery.edit',compact('promotion','webview'));
    }

    public function storefreedelivery(Request $request){

        try {
            if($request->post('restaurant_user_id')){
                $uid = $request->post('restaurant_user_id');
            } else {
                $uid = Auth::user()->uid;
            }

            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->post('promotion_id')){
                $promotion = Promotion::where('promotion_id',$request->post('promotion_id'))->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }

            $restricted_days = Carbon::createFromFormat('m-d-Y', $request->post('restricted_days'))->format('Y-m-d');

            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 3 ;
            $promotion->promotion_code = $request->post('promotion_code');
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_details = $request->post('promotion_details');
            $promotion->discount_type = Config::get('constants.DISCOUNT_TYPE.PERCENT');
            $promotion->discount = $request->post('discount_usd_percentage_amount');
            $promotion->set_minimum_order = ($request->post('set_minimum_order'))?1:0;
            $promotion->set_minimum_order_amount = $request->post('set_minimum_order_amount');
            $promotion->client_type = $request->post('client_type');
            $promotion->order_type = $request->post('order_type');
            $promotion->only_selected_payment_method = ($request->post('only_selected_payment_method'))?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->post('only_selected_cash_delivery_person'))?1:0;
            $promotion->only_selected_cash = ($request->post('only_selected_cash'))?1:0;
            $promotion->only_once_per_client = ($request->post('only_once_per_client'))?0:1;
            $promotion->mark_promoas_status = $request->post('mark_promo_as');
            $promotion->availability = $request->post('availability');
            $promotion->restricted_days = $restricted_days;
            $promotion->restricted_hours = $request->post('restricted_hours');
            if ($promotion->save()) {
                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                } else {
                    Toastr::success( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }else{

                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                } else  {
                    Toastr::error( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }
        } catch (\Throwable $th) {
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }


    public function editPaymentMethod(Request $request){
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $webview = 0;
        return view('promotion.paymentmethod.edit',compact('promotion','webview'));
    }

    public function storePaymentMethod(Request $request){
        // try {
            if($request->post('restaurant_user_id')) {
                $uid = $request->post('restaurant_user_id');
            } else {
                $uid = Auth::user()->uid;
            }

            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->post('promotion_id')){
                $promotion = Promotion::where('promotion_id',$request->post('promotion_id'))->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }

            $restricted_days = Carbon::createFromFormat('m-d-Y', $request->post('restricted_days'))->format('Y-m-d');

            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 4 ;
            $promotion->promotion_code = $request->post('promotion_code');
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_details = $request->post('promotion_details');
            $promotion->discount = $request->post('discount_usd_percentage');
            $promotion->discount_type        = Config::get('constants.DISCOUNT_TYPE.PERCENT');
            $promotion->set_minimum_order = ($request->post('set_minimum_order'))?1:0;
            $promotion->set_minimum_order_amount = $request->post('set_minimum_order_amount');
            $promotion->client_type = $request->post('client_type');
            $promotion->order_type = $request->post('order_type');
            $promotion->only_selected_payment_method = ($request->post('only_selected_payment_method'))?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->post('only_selected_cash_delivery_person'))?1:0;
            $promotion->only_selected_cash = ($request->post('only_selected_cash'))?1:0;
            $promotion->only_once_per_client = ($request->post('only_once_per_client'))?0:1;
            $promotion->mark_promoas_status = $request->post('mark_promo_as');
            $promotion->availability = $request->post('availability');
            $promotion->restricted_days = $restricted_days;
            $promotion->restricted_hours = $request->post('restricted_hours');
            if ($promotion->save()) {
                if($request->post('restaurant_user_id')) {
                    return redirect()->back();
                } else {
                    Toastr::success( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }else{
                if($request->post('restaurant_user_id')) {
                    return redirect()->back();
                } else {
                    Toastr::error( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }
        // } catch (\Throwable $th) {
        //     Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
        //     return redirect()->route('promotion');
        // }
    }

    public function editFreeItem(Request $request){
        $uid = Auth::user()->uid;
        $webview = 0;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        return view('promotion.freeitem.edit',compact('promotion','category','webview'));
    }

    public function storeFreeItems(Request $request){
        try {
            if($request->post('restaurant_user_id')) {
                $uid = $request->post('restaurant_user_id');
            } else {
                $uid = Auth::user()->uid;
            }

            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->post('promotion_id')){
                PromotionEligibleItem::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategory::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategoryItem::where('promotion_id',$request->post('promotion_id'))->delete();
                $promotion = Promotion::where('promotion_id',$request->post('promotion_id'))->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }

            $restricted_days = Carbon::createFromFormat('m-d-Y', $request->post('restricted_days'))->format('Y-m-d');

            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 5 ;
            $promotion->promotion_code = $request->post('promotion_code');
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_details = $request->post('promotion_details');
            $promotion->discount_type = Config::get('constants.DISCOUNT_TYPE.PERCENT');
            $promotion->set_minimum_order = ($request->post('set_minimum_order'))?1:0;
            $promotion->set_minimum_order_amount = $request->post('set_minimum_order_amount');
            $promotion->client_type = $request->post('client_type');
            $promotion->no_extra_charge_type = $request->post('no_extra_charge');
            $promotion->order_type = $request->post('order_type');
            $promotion->only_selected_payment_method = ($request->post('only_selected_payment_method'))?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->post('only_selected_cash_delivery_person'))?1:0;
            $promotion->only_selected_cash = ($request->post('only_selected_cash'))?1:0;
            $promotion->only_once_per_client = ($request->post('only_once_per_client'))?0:1;
            $promotion->mark_promoas_status = $request->post('mark_promo_as');
            $promotion->availability = $request->post('availability');
            $promotion->restricted_days = $restricted_days;
            $promotion->restricted_hours = $request->post('restricted_hours');
            if ($promotion->save()) {
                if(is_array($request->post('category'))){
                    $eligible_item = New PromotionEligibleItem;
                    $eligible_item->eligible_item_id  = 1;
                    $eligible_item->promotion_id = $promotion->promotion_id;
                    if($eligible_item->save()){
                        foreach($request->post('category') as $key=>$value){
                            $category = New PromotionCategory;
                            $category->promotion_id = $promotion->promotion_id;
                            $category->eligible_item_id  = 1;
                            $category->category_id = $key;
                            $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                            if($category->save()){
                                if(is_array($value)){
                                    foreach ($value as $key1 => $value1) {
                                        $categoryItem = New PromotionCategoryItem;
                                        $categoryItem->promotion_id = $promotion->promotion_id;
                                        $categoryItem->category_id = $key;
                                        $categoryItem->eligible_item_id  = 1;
                                        $categoryItem->promotion_category_id = $category->promotion_category_id;
                                        $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                        $categoryItem->item_id = $key1;
                                        $categoryItem->save();
                                    }
                                }
                            }
                        }
                    }
                }

                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                } else {
                    Toastr::success( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }else{
                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                } else {
                    Toastr::error( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }
        } catch (\Throwable $th) {
            Toastr::error('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }

    public function editGetOneFreeItem(Request $request){
        $uid = Auth::user()->uid;
        $webview = 0;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        $eligibleItems = PromotionEligibleItem::where('promotion_id',$request->id)->get();
        return view('promotion.getonefree.edit',compact('promotion','webview','category','eligibleItems'));
    }

    public function storeGetOneFreeItems(Request $request){
        try {

            if($request->post('restaurant_user_id')){
                $uid = $request->post('restaurant_user_id');
            } else {
                $uid = Auth::user()->uid;
            }

            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->post('promotion_id')){
                PromotionEligibleItem::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategory::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategoryItem::where('promotion_id',$request->post('promotion_id'))->delete();
                $promotion = Promotion::where('promotion_id',$request->post('promotion_id'))->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }

            $restricted_days = Carbon::createFromFormat('m-d-Y', $request->post('restricted_days'))->format('Y-m-d');

            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 6;
            $promotion->promotion_code = $request->post('promotion_code');
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_details = $request->post('promotion_details');
            $promotion->set_minimum_order = ($request->post('set_minimum_order'))?1:0;
            $promotion->set_minimum_order_amount = $request->post('set_minimum_order_amount');
            $promotion->discount_type = Config::get('constants.DISCOUNT_TYPE.PERCENT');
            $promotion->client_type = $request->post('client_type');
            $promotion->no_extra_charge_type = $request->post('no_extra_charge');
            $promotion->order_type = $request->post('order_type');
            $promotion->only_selected_payment_method = ($request->post('only_selected_payment_method'))?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->post('only_selected_cash_delivery_person'))?1:0;
            $promotion->only_selected_cash = ($request->post('only_selected_cash'))?1:0;
            $promotion->only_once_per_client = ($request->post('only_once_per_client'))?0:1;
            $promotion->mark_promoas_status = $request->post('mark_promo_as');
            $promotion->availability = $request->post('availability');
            $promotion->restricted_days = $restricted_days;
            $promotion->restricted_hours = $request->post('restricted_hours');
            $promotion->auto_manually_discount = $request->post('auto_manually_discount');
            if($request->post('auto_manually_discount') == Config::get('constants.AUTO_DISCOUNT.1')){
                $promotion->discount_cheapest = $request->post('discount_cheapest');
                $promotion->discount_expensive = $request->post('discount_expensive');
                // $promotion->item_group_1 = null;
                // $promotion->item_group_2 = null;
            }

            if($request->post('auto_manually_discount') == Config::get('constants.AUTO_DISCOUNT.2')){
                $promotion->discount_cheapest = null;
                $promotion->discount_expensive = null;
            }


            if ($promotion->save()) {

                $eligible_item = New PromotionEligibleItem;
                $eligible_item->eligible_item_id  = 1;
                $eligible_item->promotion_id = $promotion->promotion_id;
                $eligible_item->item_group_discount = $request->post('item_group_1');

                if($request->auto_manually_discount == Config::get('constants.AUTO_DISCOUNT.2')){
                    $eligible_item->item_group_discount = $request->post('item_group_1');
                }else{
                    $eligible_item->item_group_discount = null;
                }

                if($eligible_item->save()){
                    if($request->post('category')){
                        foreach($request->post('category') as $key => $value){
                            $category = New PromotionCategory;
                            $category->promotion_id = $promotion->promotion_id;
                            $category->eligible_item_id  = 1;
                            $category->category_id = $key;
                            $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                            if($category->save()){
                                if(is_array($value)){
                                    foreach ($value as $key1 => $value1) {
                                        $categoryItem = New PromotionCategoryItem;
                                        $categoryItem->promotion_id = $promotion->promotion_id;
                                        $categoryItem->category_id = $key;
                                        $categoryItem->eligible_item_id  = 1;
                                        $categoryItem->promotion_category_id = $category->promotion_category_id;
                                        $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                        $categoryItem->item_id = $key1;
                                        $categoryItem->save();
                                    }
                                }
                            }
                        }
                    }
                }

                $eligible_item = New PromotionEligibleItem;
                $eligible_item->eligible_item_id  = 2;
                $eligible_item->promotion_id = $promotion->promotion_id;

                if($request->auto_manually_discount == Config::get('constants.AUTO_DISCOUNT.2')){
                    $eligible_item->item_group_discount = $request->post('item_group_2');
                } else {
                    $eligible_item->item_group_discount = null;
                }

                if($eligible_item->save()){
                    if($request->post('category_two')){
                        foreach($request->post('category_two') as $key => $value){
                            $category = New PromotionCategory;
                            $category->promotion_id = $promotion->promotion_id;
                            $category->eligible_item_id  = 2;
                            $category->category_id = $key;
                            $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                            if($category->save()){
                                if(is_array($value)){
                                    foreach ($value as $key1 => $value1) {
                                        $categoryItem = New PromotionCategoryItem;
                                        $categoryItem->promotion_id = $promotion->promotion_id;
                                        $categoryItem->category_id = $key;
                                        $categoryItem->eligible_item_id  = 2;
                                        $categoryItem->promotion_category_id = $category->promotion_category_id;
                                        $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                        $categoryItem->item_id = $key1;
                                        $categoryItem->save();
                                    }
                                }
                            }
                        }
                    }
                }

                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                }else{
                    Toastr::success( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }else{
                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                } else {
                    Toastr::error( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }
        } catch (\Throwable $th) {
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }

    public function editMealBundleItem(Request $request){
        $uid = Auth::user()->uid;
        $webview = 0;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        $eligibleItems = PromotionEligibleItem::where('promotion_id',$request->id)->count();
        return view('promotion.mealbundle.edit',compact('promotion','category','webview','eligibleItems'));
    }

    public function storeMealBundleItems(Request $request){
        try {

            if($request->post('restaurant_user_id')){
                $uid = $request->post('restaurant_user_id');
            } else  {
                $uid = Auth::user()->uid;
            }
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->post('promotion_id')){
                PromotionEligibleItem::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategory::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategoryItem::where('promotion_id',$request->post('promotion_id'))->delete();
                $promotion = Promotion::where('promotion_id',$request->post('promotion_id'))->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }

            $restricted_days = Carbon::createFromFormat('m-d-Y', $request->post('restricted_days'))->format('Y-m-d');

            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 7;
            $promotion->promotion_code = $request->post('promotion_code');
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_details = $request->post('promotion_details');
            $promotion->minimum_order_status = ($request->post('set_minimum_order_amount')) ? 'TRUE' : 'FALSE';
            $promotion->discount = $request->post('flat_price');
            $promotion->discount_type  = Config::get('constants.DISCOUNT_TYPE.USD');
            $promotion->client_type = $request->post('client_type');
            $promotion->no_extra_charge_type = $request->post('no_extra_charge');
            $promotion->order_type = $request->post('order_type');
            $promotion->only_selected_payment_method = ($request->post('only_selected_payment_method'))?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->post('only_selected_cash_delivery_person'))?1:0;
            $promotion->only_selected_cash = ($request->post('only_selected_cash'))?1:0;
            $promotion->only_once_per_client = ($request->post('only_once_per_client'))?0:1;
            $promotion->mark_promoas_status = $request->post('mark_promo_as');
            $promotion->availability = $request->post('availability');
            $promotion->restricted_days = $restricted_days;
            $promotion->restricted_hours = $request->post('restricted_hours');

            $counter = 1;
            if ($promotion->save()) {
                if(is_array($request->post('category'))){
                    foreach($request->post('category') as $categoryKey => $categories){
                        $eligible_item = New PromotionEligibleItem;
                        $eligible_item->eligible_item_id  = $counter;
                        $eligible_item->promotion_id = $promotion->promotion_id;
                        if($eligible_item->save()){
                            foreach($categories as $key=>$value){
                                $category = New PromotionCategory;
                                $category->promotion_id = $promotion->promotion_id;
                                $category->eligible_item_id  = $counter;
                                $category->category_id = $key;
                                $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                if($category->save()){
                                    if(is_array($value)){
                                        foreach ($value as $key1 => $value1) {
                                            $categoryItem = New PromotionCategoryItem;
                                            $categoryItem->promotion_id = $promotion->promotion_id;
                                            $categoryItem->category_id = $key;
                                            $categoryItem->eligible_item_id  = $counter;
                                            $categoryItem->promotion_category_id = $category->promotion_category_id;
                                            $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                            $categoryItem->item_id = $key1;
                                            $categoryItem->save();
                                        }
                                    }
                                }
                            }
                        }
                        $counter++;
                    }
                }

                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                }else{
                    Toastr::success( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }else{
                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                } else {
                    Toastr::error( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }
        } catch (\Throwable $th) {
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }

    public function editBuyTwoThreeItem(Request $request){
        $uid = Auth::user()->uid;
        $webview = 0;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        $eligibleItems = PromotionEligibleItem::where('promotion_id',$request->id)->count();
        return view('promotion.buytwothree.edit',compact('promotion','category','webview','eligibleItems'));
    }

    public function storeBuyTwoThreeItems(Request $request){
        try {

            if($request->post('restaurant_user_id')){
                $uid = $request->post('restaurant_user_id');
            } else {
                $uid = Auth::user()->uid;
            }
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->post('promotion_id')){
                PromotionEligibleItem::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategory::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategoryItem::where('promotion_id',$request->post('promotion_id'))->delete();
                $promotion = Promotion::where('promotion_id',$request->post('promotion_id'))->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }

            $restricted_days = Carbon::createFromFormat('m-d-Y', $request->post('restricted_days'))->format('Y-m-d');

            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 8;
            $promotion->promotion_code = $request->post('promotion_code');
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_details = $request->post('promotion_details');
            $promotion->discount_type  = Config::get('constants.DISCOUNT_TYPE.PERCENT');
            $promotion->client_type = $request->post('client_type');
            $promotion->no_extra_charge_type = $request->post('no_extra_charge');
            $promotion->order_type = $request->post('order_type');
            $promotion->only_selected_payment_method = ($request->post('only_selected_payment_method'))?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->post('only_selected_cash_delivery_person'))?1:0;
            $promotion->only_selected_cash = ($request->post('only_selected_cash'))?1:0;
            $promotion->only_once_per_client = ($request->post('only_once_per_client'))?0:1;
            $promotion->mark_promoas_status = $request->post('mark_promo_as');
            $promotion->availability = $request->post('availability');
            $promotion->auto_manually_discount = $request->post('auto_manually_discount');
            $promotion->restricted_days =$restricted_days;
            $promotion->restricted_hours = $request->post('restricted_hours');
            if($request->post('auto_manually_discount') == Config::get('constants.AUTO_DISCOUNT.1')){
                $promotion->discount_cheapest = $request->post('discount_cheapest');
                $promotion->discount_expensive = $request->post('discount_expensive');
            } else {
                $promotion->discount_cheapest = NULL;
                $promotion->discount_expensive = NULL;
            }

            if ($promotion->save()) {
                $counter = 1;
                if(is_array($request->post('category'))){
                    foreach($request->post('category') as $categoryKey => $categories){
                        $eligible_item = New PromotionEligibleItem;
                        $eligible_item->eligible_item_id  = $counter;
                        $eligible_item->promotion_id = $promotion->promotion_id;
                        if($request->auto_manually_discount == Config::get('constants.AUTO_DISCOUNT.1')){
                            $eligible_item->item_group_discount = (isset($request->item_discount[$categoryKey]))?$request->item_discount[$categoryKey]:NULL;
                        } else {
                            $eligible_item->item_group_discount = $request->item_group_discount[$categoryKey];
                        }
                        if($eligible_item->save()){
                            foreach($categories as $key => $value){
                                $category = New PromotionCategory;
                                $category->promotion_id = $promotion->promotion_id;
                                $category->eligible_item_id  = $counter;
                                $category->category_id = $key;
                                $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                if($category->save()){
                                    if(is_array($value)){
                                        foreach ($value as $key1 => $value1) {
                                            $categoryItem = New PromotionCategoryItem;
                                            $categoryItem->promotion_id = $promotion->promotion_id;
                                            $categoryItem->category_id = $key;
                                            $categoryItem->eligible_item_id  = $counter;
                                            $categoryItem->promotion_category_id = $category->promotion_category_id;
                                            $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                            $categoryItem->item_id = $key1;
                                            $categoryItem->save();
                                        }
                                    }
                                }
                            }
                        }
                        $counter++;
                    }
                }

                if($request->post('restaurant_user_id')) {
                    return redirect()->back();
                } else {
                    Toastr::success( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }

            }else{

                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                } else {
                    Toastr::error( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }
        } catch (\Throwable $th) {
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }


    public function editFixedDiscountItem(Request $request){
        $uid = Auth::user()->uid;
        $webview = 0;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        $eligibleItems = PromotionEligibleItem::where('promotion_id',$request->id)->count();
        return view('promotion.fixeddiscount.edit',compact('promotion','category','webview','eligibleItems'));
    }

    public function storeFixedDiscountItems(Request $request){
        try {

            if($request->post('restaurant_user_id')){
                $uid = $request->post('restaurant_user_id');
            }else{
                $uid = Auth::user()->uid;
            }

            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->post('promotion_id')){
                PromotionEligibleItem::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategory::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategoryItem::where('promotion_id',$request->post('promotion_id'))->delete();
                $promotion = Promotion::where('promotion_id',$request->post('promotion_id'))->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }

            $restricted_days = Carbon::createFromFormat('m-d-Y', $request->post('restricted_days'))->format('Y-m-d');

            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 9;
            $promotion->promotion_code = $request->post('promotion_code');
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_details = $request->post('promotion_details');
            $promotion->discount = $request->post('discount_usd_percentage_amount');
            $promotion->discount_type = Config::get('constants.DISCOUNT_TYPE.USD');
            $promotion->set_minimum_order = ($request->post('set_minimum_order'))?1:0;
            $promotion->set_minimum_order_amount = $request->post('set_minimum_order_amount');
            $promotion->client_type = $request->post('client_type');
            $promotion->no_extra_charge_type = $request->post('no_extra_charge');
            $promotion->order_type = $request->post('order_type');
            $promotion->only_selected_payment_method = ($request->post('only_selected_payment_method'))?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->post('only_selected_cash_delivery_person'))?1:0;
            $promotion->only_selected_cash = ($request->post('only_selected_cash'))?1:0;
            $promotion->only_once_per_client = ($request->post('only_once_per_client'))?0:1;
            $promotion->mark_promoas_status = $request->post('mark_promo_as');
            $promotion->availability = $request->post('availability');
            $promotion->restricted_days = $restricted_days;
            $promotion->restricted_hours = $request->post('restricted_hours');

            if ($promotion->save()) {
                $counter = 1;
                if(is_array($request->post('category'))){
                     foreach($request->post('category') as $categoryKey => $categories){
                        $eligible_item = New PromotionEligibleItem;
                        $eligible_item->eligible_item_id  = $counter;
                        $eligible_item->promotion_id = $promotion->promotion_id;
                        if($eligible_item->save()){
                            foreach($categories as $key => $value){
                                $category = New PromotionCategory;
                                $category->promotion_id = $promotion->promotion_id;
                                $category->eligible_item_id  = $counter;
                                $category->category_id = $key;
                                $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                if($category->save()){
                                    if(is_array($value)){
                                        foreach ($value as $key1 => $value1) {
                                            $categoryItem = New PromotionCategoryItem;
                                            $categoryItem->promotion_id = $promotion->promotion_id;
                                            $categoryItem->category_id = $key;
                                            $categoryItem->eligible_item_id  = $counter;
                                            $categoryItem->promotion_category_id = $category->promotion_category_id;
                                            $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                            $categoryItem->item_id = $key1;
                                            $categoryItem->save();
                                        }
                                    }
                                }
                            }
                        }
                        $counter++;
                    }
                }

                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                }
                else{
                    Toastr::success( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }else{
                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                }else{
                    Toastr::error( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }
        } catch (\Throwable $th) {
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }


    public function editDiscountComboItem(Request $request){
        $uid = Auth::user()->uid;
        $webview = 0;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        $eligibleItems = PromotionEligibleItem::where('promotion_id',$request->id)->count();
        return view('promotion.discountcombo.edit',compact('promotion','category','webview','eligibleItems'));
    }

    public function storeDiscountComboItems(Request $request){
        try {

            if($request->post('restaurant_user_id')){
                $uid = $request->post('restaurant_user_id');
            } else {
                $uid = Auth::user()->uid;
            }

            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->post('promotion_id')){
                PromotionEligibleItem::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategory::where('promotion_id',$request->post('promotion_id'))->delete();
                PromotionCategoryItem::where('promotion_id',$request->post('promotion_id'))->delete();
                $promotion = Promotion::where('promotion_id',$request->post('promotion_id'))->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }

            $restricted_days = Carbon::createFromFormat('m-d-Y', $request->post('restricted_days'))->format('Y-m-d');

            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 10;
            $promotion->promotion_code = $request->post('promotion_code');
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_details = $request->post('promotion_details');
            $promotion->discount = $request->post('discount_usd_percentage_amount');
            $promotion->discount_type = Config::get('constants.DISCOUNT_TYPE.PERCENT');
            $promotion->client_type = $request->post('client_type');
            $promotion->no_extra_charge_type = $request->post('no_extra_charge');
            $promotion->order_type = $request->post('order_type');
            $promotion->only_selected_payment_method = ($request->post('only_selected_payment_method'))?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->post('only_selected_cash_delivery_person'))?1:0;
            $promotion->only_selected_cash = ($request->post('only_selected_cash'))?1:0;
            $promotion->only_once_per_client = ($request->post('only_once_per_client'))?0:1;
            $promotion->mark_promoas_status = $request->post('mark_promo_as');
            $promotion->availability = $request->post('availability');
            $promotion->restricted_days =$restricted_days ;
            $promotion->restricted_hours = $request->post('restricted_hours');
            if ($promotion->save()) {
                $counter = 1;
                if(is_array($request->post('category'))){
                     foreach($request->post('category') as $categoryKey => $categories){
                        $eligible_item = New PromotionEligibleItem;
                        $eligible_item->eligible_item_id  = $counter;
                        $eligible_item->promotion_id = $promotion->promotion_id;
                        if($eligible_item->save()){
                            foreach($categories as $key => $value){
                                $category = New PromotionCategory;
                                $category->promotion_id = $promotion->promotion_id;
                                $category->eligible_item_id  = $counter;
                                $category->category_id = $key;
                                $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                if($category->save()){
                                    if(is_array($value)){
                                        foreach ($value as $key1 => $value1) {
                                            $categoryItem = New PromotionCategoryItem;
                                            $categoryItem->promotion_id = $promotion->promotion_id;
                                            $categoryItem->category_id = $key;
                                            $categoryItem->eligible_item_id  = $counter;
                                            $categoryItem->promotion_category_id = $category->promotion_category_id;
                                            $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                            $categoryItem->item_id = $key1;
                                            $categoryItem->save();
                                        }
                                    }
                                }
                            }
                        }
                        $counter++;
                    }
                }

                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                } else {
                    Toastr::success( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }else{
                if($request->post('restaurant_user_id')){
                    return redirect()->back();
                }else{
                    Toastr::error( $message,'', Config::get('constants.toster'));
                    return redirect()->route('promotion');
                }
            }
        } catch (\Throwable $th) {
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }


    public function delete($id)
    {
        try {
            $alert =['Promotion does not delete successfully','', Config::get('constants.toster')];
            PromotionEligibleItem::where('promotion_id', $id)->delete();
            PromotionCategory::where('promotion_id', $id)->delete();
            PromotionCategoryItem::where('promotion_id', $id)->delete();
            $promotion = Promotion::where('promotion_id', $id)->first();
            if($promotion){
                $promotion->delete();
                $alert =['Promotion delete successfully','', Config::get('constants.toster')];
            }
            return response()->json(['route'=>route('promotion'),'alert'=>$alert,'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($errors, 500);
        }
    }
    public function status($id,$status)
    {
        try {
            $alert =['Promotion does not update successfully','', Config::get('constants.toster')];
            $promotion = Promotion::where('promotion_id', $id)->first();
            if($promotion){
                $promotion->status = ($status=='true')?'ACTIVE':'INACTIVE';
                $promotion->save();
                $alert =['Promotion update successfully','', Config::get('constants.toster')];
            }
            return response()->json(['route'=>route('promotion'),'alert'=>$alert,'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($errors, 500);
        }
    }

    public function webViewForm($promotionTypeId,$restaurantId,$formType,$promotionId = null)
    {
        $type = $promotionTypeId;
        $uid = $restaurantId;
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        $webview = 1;
        $promotion = Promotion::where('promotion_id',$promotionId)->first();
        try {
            if($type==1){//DONE
                if($formType == 'Add'){
                    return view('promotion.cart.add',compact('webview','uid'));
                } else {
                    return view('promotion.cart.edit',compact('promotion','webview','uid'));
                }
            }else if($type==2){//DONE
                if($formType == 'Add'){
                    return view('promotion.discount_selected_item.add',compact('category','webview','uid'));
                } else {
                    return view('promotion.discount_selected_item.edit',compact('promotion','webview','uid','category'));
                }
            }else if($type==3){//DONE
                if($formType == 'Add'){
                    return view('promotion.freedelivery.add',compact('webview','uid'));
                }else{
                    return view('promotion.freedelivery.edit',compact('promotion','webview','uid'));
                }
            }else if($type==4){//DONE
                if($formType == 'Add'){
                    return view('promotion.paymentmethod.add',compact('webview','uid'));
                }else{
                    return view('promotion.paymentmethod.edit',compact('promotion','webview','uid'));
                }
            }else if($type==5){//DONE
                if($formType == 'Add'){
                    return view('promotion.freeitem.add',compact('category','webview','uid'));
                }else{
                    return view('promotion.freeitem.edit',compact('promotion','category','webview','uid'));
                }
            }else if($type==6){//DONE
                if($formType == 'Add'){
                    return view('promotion.getonefree.add',compact('category','webview','uid'));
                }else{
                    $eligibleItems = PromotionEligibleItem::where('promotion_id',$promotion->promotion_id)->count();
                    return view('promotion.getonefree.edit',compact('promotion','category','webview','uid','eligibleItems'));
                }
            }else if($type==7){//DONE
                if($formType == 'Add'){
                    return view('promotion.mealbundle.add',compact('category','webview','uid'));
                }else{
                    $eligibleItems = PromotionEligibleItem::where('promotion_id',$promotion->promotion_id)->count();
                    return view('promotion.mealbundle.edit',compact('promotion','category','webview','uid','eligibleItems'));
                }
            }else if($type==8){//DONE
                if($formType == 'Add'){
                    return view('promotion.buytwothree.add',compact('category','webview','uid'));
                }else{
                    $eligibleItems = PromotionEligibleItem::where('promotion_id',$promotion->promotion_id)->count();
                    return view('promotion.buytwothree.edit',compact('promotion','category','webview','uid','eligibleItems'));
                }
            }else if($type==9){//DONE
                if($formType == 'Add'){
                    return view('promotion.fixeddiscount.add',compact('category','webview','uid'));
                }else{
                    $eligibleItems = PromotionEligibleItem::where('promotion_id',$promotion->promotion_id)->count();
                    return view('promotion.fixeddiscount.edit',compact('promotion','category','webview','uid','eligibleItems'));
                }
            }else if($type==10){//DONE
                if($formType == 'Add'){
                    return view('promotion.discountcombo.add',compact('category','webview','uid'));
                }else{
                    $eligibleItems = PromotionEligibleItem::where('promotion_id',$promotion->promotion_id)->count();
                    return view('promotion.discountcombo.edit',compact('promotion','category','webview','uid','eligibleItems'));
                }
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            $errors['debug'] = $th->getMessage();
            return response()->json($errors, 500);
        }
    }

    public function getCategories(Request $request)
    {
        if(Auth::check()){
            $uid = Auth::user()->uid;
        }
        else{
            $uid = $request->post('uid');
        }
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        return response()->json($category, 200);
    }
}
