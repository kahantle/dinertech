<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ModifierGroupRequest;
use App\Http\Requests\PromotionRequest;
use App\Http\Requests\PromotionCartRequest;
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

        if($type==1){//DONE
            $promotion = [];
            return view('promotion.cart.add',compact('promotion'));
        }else if($type==2){//DONE
            return view('promotion.discount_selected_item.add',compact('category'));
        }else if($type==3){//DONE
            $promotion = [];
            return view('promotion.freedelivery.add',compact('promotion'));
        }else if($type==4){//DONE
            $promotion = [];
            return view('promotion.paymentmethod.add',compact('promotion'));
        }else if($type==5){//DONE
            return view('promotion.freeitem.add',compact('category'));
        }else if($type==6){//DONE
            return view('promotion.getonefree.add',compact('category'));
        }else if($type==7){//DONE
            return view('promotion.mealbundle.add',compact('category'));
        }else if($type==8){//
            return view('promotion.buytwothree.add',compact('category'));
        }else if($type==9){
            return view('promotion.fixeddiscount.add',compact('category'));
        }else if($type==10){
            return view('promotion.discountcombo.add',compact('category'));
        }
    }

    public function editCart(Request $request){
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        return view('promotion.cart.edit',compact('promotion'));
    }
    public function storeCart(PromotionCartRequest $request){
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->promotion_id){
                $promotion = Promotion::where('promotion_id',$request->promotion_id)->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }
            
            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 1 ;
            $promotion->promotion_code = $request->promotion_code;
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_details = $request->promotion_details;
            $promotion->dicount_usd_percentage = $request->dicount_usd_percentage;
            $promotion->dicount_usd_percentage_amount = $request->dicount_usd_percentage_amount;
            $promotion->set_minimum_order = ($request->set_minimum_order)?1:0;
            $promotion->set_minimum_order_amount = $request->set_minimum_order_amount;
            $promotion->client_type = $request->client_type;
            $promotion->order_type = $request->order_type;
            $promotion->only_selected_payment_method = ($request->only_selected_payment_method)?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->only_selected_cash_delivery_person)?1:0;
            $promotion->only_selected_cash = ($request->only_selected_cash)?1:0;
            $promotion->only_once_per_client = ($request->only_once_per_client)?1:0;
            $promotion->mark_promo_as = $request->mark_promo_as;
            $promotion->display_time = $request->display_time;
            if ($promotion->save()) {
                Toastr::success( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }else{
                Toastr::error( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }            
        } catch (\Throwable $th) {
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }


    public function editSelectedItem(Request $request){
        $uid = Auth::user()->uid;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        return view('promotion.discount_selected_item.edit',compact('promotion','category'));
    }

    public function storeSelectedItems(Request $request){
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->promotion_id){
                PromotionEligibleItem::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategory::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategoryItem::where('promotion_id',$request->promotion_id)->delete();
                $promotion = Promotion::where('promotion_id',$request->promotion_id)->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }
            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 2 ;
            $promotion->promotion_code = $request->promotion_code;
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_details = $request->promotion_details;
            $promotion->dicount_usd_percentage = $request->dicount_usd_percentage;
            $promotion->dicount_usd_percentage_amount = $request->dicount_usd_percentage_amount;
            $promotion->set_minimum_order_amount = $request->set_minimum_order_amount;
            $promotion->client_type = $request->client_type;
            $promotion->no_extra_charge = $request->no_extra_charge;
            $promotion->order_type = $request->order_type;
            $promotion->only_selected_payment_method = ($request->only_selected_payment_method)?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->only_selected_cash_delivery_person)?1:0;
            $promotion->only_selected_cash = ($request->only_selected_cash)?1:0;
            $promotion->only_once_per_client = ($request->only_once_per_client)?1:0;
            $promotion->mark_promo_as = $request->mark_promo_as;
            $promotion->display_time = $request->display_time;
            if ($promotion->save()) {
                if(is_array($request->category)){
                    $eligible_item = New PromotionEligibleItem;
                    $eligible_item->eligible_item_id  = 1;
                    $eligible_item->promotion_id = $promotion->promotion_id;
                    if($eligible_item->save()){
                        foreach($request->category as $key=>$value){
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
                Toastr::success( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }else{
                Toastr::error( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }            
        } catch (\Throwable $th) {
            
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }

    public function editFreeMethod(Request $request){
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        return view('promotion.freedelivery.edit',compact('promotion'));
    }

    public function storefreedelivery(PromotionCartRequest $request){
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->promotion_id){
                $promotion = Promotion::where('promotion_id',$request->promotion_id)->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }
            
            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 3 ;
            $promotion->promotion_code = $request->promotion_code;
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_details = $request->promotion_details;
            $promotion->dicount_usd_percentage = $request->dicount_usd_percentage;
            $promotion->dicount_usd_percentage_amount = $request->dicount_usd_percentage_amount;
            $promotion->set_minimum_order = ($request->set_minimum_order)?1:0;
            $promotion->set_minimum_order_amount = $request->set_minimum_order_amount;
            $promotion->client_type = $request->client_type;
            $promotion->order_type = $request->order_type;
            $promotion->only_selected_payment_method = ($request->only_selected_payment_method)?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->only_selected_cash_delivery_person)?1:0;
            $promotion->only_selected_cash = ($request->only_selected_cash)?1:0;
            $promotion->only_once_per_client = ($request->only_once_per_client)?1:0;
            $promotion->mark_promo_as = $request->mark_promo_as;
            $promotion->display_time = $request->display_time;
            if ($promotion->save()) {
                Toastr::success( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }else{
                Toastr::error( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }            
        } catch (\Throwable $th) {
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }


    public function editPaymentMethod(Request $request){
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        return view('promotion.paymentmethod.edit',compact('promotion'));
    }

    public function storePaymentMethod(PromotionCartRequest $request){
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->promotion_id){
                $promotion = Promotion::where('promotion_id',$request->promotion_id)->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }
           
            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 4 ;
            $promotion->promotion_code = $request->promotion_code;
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_details = $request->promotion_details;
            $promotion->dicount_usd_percentage = $request->dicount_usd_percentage;
            $promotion->dicount_usd_percentage_amount = $request->dicount_usd_percentage_amount;
            $promotion->set_minimum_order = ($request->set_minimum_order)?1:0;
            $promotion->set_minimum_order_amount = $request->set_minimum_order_amount;
            $promotion->client_type = $request->client_type;
            $promotion->order_type = $request->order_type;
            $promotion->only_selected_payment_method = ($request->only_selected_payment_method)?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->only_selected_cash_delivery_person)?1:0;
            $promotion->only_selected_cash = ($request->only_selected_cash)?1:0;
            $promotion->only_once_per_client = ($request->only_once_per_client)?1:0;
            $promotion->mark_promo_as = $request->mark_promo_as;
            $promotion->display_time = $request->display_time;
            if ($promotion->save()) {
                Toastr::success( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }else{
                Toastr::error( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }            
        } catch (\Throwable $th) {
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }



    public function editFreeItem(Request $request){
        $uid = Auth::user()->uid;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        return view('promotion.freeitem.edit',compact('promotion','category'));
    }

    public function storeFreeItems(Request $request){
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->promotion_id){
                PromotionEligibleItem::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategory::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategoryItem::where('promotion_id',$request->promotion_id)->delete();
                $promotion = Promotion::where('promotion_id',$request->promotion_id)->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }
            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 5 ;
            $promotion->promotion_code = $request->promotion_code;
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_details = $request->promotion_details;
            $promotion->dicount_usd_percentage = $request->dicount_usd_percentage;
            $promotion->dicount_usd_percentage_amount = $request->dicount_usd_percentage_amount;
            $promotion->set_minimum_order_amount = $request->set_minimum_order_amount;
            $promotion->client_type = $request->client_type;
            $promotion->no_extra_charge = $request->no_extra_charge;
            $promotion->order_type = $request->order_type;
            $promotion->only_selected_payment_method = ($request->only_selected_payment_method)?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->only_selected_cash_delivery_person)?1:0;
            $promotion->only_selected_cash = ($request->only_selected_cash)?1:0;
            $promotion->only_once_per_client = ($request->only_once_per_client)?1:0;
            $promotion->mark_promo_as = $request->mark_promo_as;
            $promotion->display_time = $request->display_time;
            if ($promotion->save()) {
                if(is_array($request->category)){
                    $eligible_item = New PromotionEligibleItem;
                    $eligible_item->eligible_item_id  = 1;
                    $eligible_item->promotion_id = $promotion->promotion_id;
                    if($eligible_item->save()){
                        foreach($request->category as $key=>$value){
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
                Toastr::success( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }else{
                Toastr::error( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }            
        } catch (\Throwable $th) {
            Toastr::error('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }


    public function editGetOneFreeItem(Request $request){
        $uid = Auth::user()->uid;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        return view('promotion.getonefree.edit',compact('promotion','category'));
    }

    public function storeGetOneFreeItems(Request $request){
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->promotion_id){
                PromotionEligibleItem::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategory::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategoryItem::where('promotion_id',$request->promotion_id)->delete();
                $promotion = Promotion::where('promotion_id',$request->promotion_id)->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }
            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 6;
            $promotion->promotion_code = $request->promotion_code;
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_details = $request->promotion_details;
            $promotion->dicount_usd_percentage = $request->dicount_usd_percentage;
            $promotion->dicount_usd_percentage_amount = $request->dicount_usd_percentage_amount;
            $promotion->set_minimum_order_amount = $request->set_minimum_order_amount;
            $promotion->client_type = $request->client_type;
            $promotion->no_extra_charge = $request->no_extra_charge;
            $promotion->order_type = $request->order_type;
            $promotion->only_selected_payment_method = ($request->only_selected_payment_method)?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->only_selected_cash_delivery_person)?1:0;
            $promotion->only_selected_cash = ($request->only_selected_cash)?1:0;
            $promotion->only_once_per_client = ($request->only_once_per_client)?1:0;
            $promotion->mark_promo_as = $request->mark_promo_as;
            $promotion->display_time = $request->display_time;

            $promotion->auto_manually_discount = $request->auto_manually_discount;
            $promotion->discount_cheapest = $request->discount_cheapest;
            $promotion->discount_expensive = $request->discount_expensive;
            $promotion->item_group_1 = $request->item_group_1;
            $promotion->item_group_2 = $request->item_group_2;


            if ($promotion->save()) {
                if(is_array($request->eligible_item)){
                    foreach($request->eligible_item as $key=>$value){
                            $eligible_item = New PromotionEligibleItem;
                            $eligible_item->eligible_item_id  = $key;
                            $eligible_item->promotion_id = $promotion->promotion_id;
                            if($eligible_item->save()){
                                foreach($value as $key1=>$value1){
                                    $category = New PromotionCategory;
                                    $category->promotion_id = $promotion->promotion_id;
                                    $category->eligible_item_id  = $key;
                                    $category->category_id = $key1;
                                    $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                    if($category->save()){
                                        if(is_array($value1)){
                                            foreach ($value1 as $key2 => $value2) {
                                                $categoryItem = New PromotionCategoryItem;
                                                $categoryItem->promotion_id = $promotion->promotion_id;
                                                $categoryItem->category_id = $key1;
                                                $categoryItem->eligible_item_id  = $key;
                                                $categoryItem->promotion_category_id = $category->promotion_category_id;
                                                $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                                $categoryItem->item_id = $key2;
                                                $categoryItem->save();
                                            }
                                        }
                                    }
                                }
                            }
                    }   
                }
                Toastr::success( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }else{
                Toastr::error( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }            
        } catch (\Throwable $th) {
            
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }



    public function editMealBundleItem(Request $request){
        $uid = Auth::user()->uid;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        return view('promotion.mealbundle.edit',compact('promotion','category'));
    }

    public function storeMealBundleItems(Request $request){
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->promotion_id){
                PromotionEligibleItem::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategory::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategoryItem::where('promotion_id',$request->promotion_id)->delete();
                $promotion = Promotion::where('promotion_id',$request->promotion_id)->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }
            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 7;
            $promotion->promotion_code = $request->promotion_code;
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_details = $request->promotion_details;
            $promotion->dicount_usd_percentage = $request->dicount_usd_percentage;
            $promotion->dicount_usd_percentage_amount = $request->dicount_usd_percentage_amount;
            $promotion->set_minimum_order_amount = $request->set_minimum_order_amount;
            $promotion->client_type = $request->client_type;
            $promotion->no_extra_charge = $request->no_extra_charge;
            $promotion->order_type = $request->order_type;
            $promotion->only_selected_payment_method = ($request->only_selected_payment_method)?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->only_selected_cash_delivery_person)?1:0;
            $promotion->only_selected_cash = ($request->only_selected_cash)?1:0;
            $promotion->only_once_per_client = ($request->only_once_per_client)?1:0;
            $promotion->mark_promo_as = $request->mark_promo_as;
            $promotion->display_time = $request->display_time;
            $promotion->discount_usd= $request->discount_usd;
            $promotion->auto_manually_discount = $request->auto_manually_discount;
            $promotion->discount_cheapest = $request->discount_cheapest;
            $promotion->discount_expensive = $request->discount_expensive;
            $promotion->item_group_1 = $request->item_group_1;
            $promotion->item_group_2 = $request->item_group_2;
            
            if ($promotion->save()) {
                if(is_array($request->eligible_item)){
                    foreach($request->eligible_item as $key=>$value){
                            $eligible_item = New PromotionEligibleItem;
                            $eligible_item->eligible_item_id  = $key;
                            $eligible_item->promotion_id = $promotion->promotion_id;
                            if($eligible_item->save()){
                                foreach($value as $key1=>$value1){
                                    $category = New PromotionCategory;
                                    $category->promotion_id = $promotion->promotion_id;
                                    $category->eligible_item_id  = $key;
                                    $category->category_id = $key1;
                                    $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                    if($category->save()){
                                        if(is_array($value1)){
                                            foreach ($value1 as $key2 => $value2) {
                                                $categoryItem = New PromotionCategoryItem;
                                                $categoryItem->promotion_id = $promotion->promotion_id;
                                                $categoryItem->category_id = $key1;
                                                $categoryItem->eligible_item_id  = $key;
                                                $categoryItem->promotion_category_id = $category->promotion_category_id;
                                                $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                                $categoryItem->item_id = $key2;
                                                $categoryItem->save();
                                            }
                                        }
                                    }
                                }
                            }
                    }   
                }
                Toastr::success( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }else{
                Toastr::error( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }            
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }



    public function editBuyTwoThreeItem(Request $request){
        $uid = Auth::user()->uid;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        return view('promotion.buytwothree.edit',compact('promotion','category'));
    }

    public function storeBuyTwoThreeItems(Request $request){
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->promotion_id){
                PromotionEligibleItem::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategory::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategoryItem::where('promotion_id',$request->promotion_id)->delete();
                $promotion = Promotion::where('promotion_id',$request->promotion_id)->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }
            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 8;
            $promotion->promotion_code = $request->promotion_code;
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_details = $request->promotion_details;
            $promotion->dicount_usd_percentage = $request->dicount_usd_percentage;
            $promotion->dicount_usd_percentage_amount = $request->dicount_usd_percentage_amount;
            $promotion->set_minimum_order_amount = $request->set_minimum_order_amount;
            $promotion->client_type = $request->client_type;
            $promotion->no_extra_charge = $request->no_extra_charge;
            $promotion->order_type = $request->order_type;
            $promotion->only_selected_payment_method = ($request->only_selected_payment_method)?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->only_selected_cash_delivery_person)?1:0;
            $promotion->only_selected_cash = ($request->only_selected_cash)?1:0;
            $promotion->only_once_per_client = ($request->only_once_per_client)?1:0;
            $promotion->mark_promo_as = $request->mark_promo_as;
            $promotion->display_time = $request->display_time;
            $promotion->discount_usd= $request->discount_usd;
            $promotion->auto_manually_discount = $request->auto_manually_discount;
            $promotion->discount_cheapest = $request->discount_cheapest;
            $promotion->discount_expensive = $request->discount_expensive;
            $promotion->item_group_1 = $request->item_group_1;
            $promotion->item_group_2 = $request->item_group_2;
            if ($promotion->save()) {
                if(is_array($request->eligible_item)){
                    foreach($request->eligible_item as $key=>$value){
                            $eligible_item = New PromotionEligibleItem;
                            $eligible_item->eligible_item_id  = $key;
                            $eligible_item->promotion_id = $promotion->promotion_id;
                            if($eligible_item->save()){
                                foreach($value as $key1=>$value1){
                                    $category = New PromotionCategory;
                                    $category->promotion_id = $promotion->promotion_id;
                                    $category->eligible_item_id  = $key;
                                    $category->category_id = $key1;
                                    $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                    if($category->save()){
                                        if(is_array($value1)){
                                            foreach ($value1 as $key2 => $value2) {
                                                $categoryItem = New PromotionCategoryItem;
                                                $categoryItem->promotion_id = $promotion->promotion_id;
                                                $categoryItem->category_id = $key1;
                                                $categoryItem->eligible_item_id  = $key;
                                                $categoryItem->promotion_category_id = $category->promotion_category_id;
                                                $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                                $categoryItem->item_id = $key2;
                                                $categoryItem->save();
                                            }
                                        }
                                    }
                                }
                            }
                    }   
                }
                Toastr::success( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }else{
                Toastr::error( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }            
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }


    public function editFixedDiscountItem(Request $request){
        $uid = Auth::user()->uid;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        return view('promotion.fixeddiscount.edit',compact('promotion','category'));
    }

    public function storeFixedDiscountItems(Request $request){
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->promotion_id){
                PromotionEligibleItem::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategory::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategoryItem::where('promotion_id',$request->promotion_id)->delete();
                $promotion = Promotion::where('promotion_id',$request->promotion_id)->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }
            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 9;
            $promotion->promotion_code = $request->promotion_code;
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_details = $request->promotion_details;
            $promotion->dicount_usd_percentage = $request->dicount_usd_percentage;
            $promotion->dicount_usd_percentage_amount = $request->dicount_usd_percentage_amount;
            $promotion->set_minimum_order_amount = $request->set_minimum_order_amount;
            $promotion->client_type = $request->client_type;
            $promotion->no_extra_charge = $request->no_extra_charge;
            $promotion->order_type = $request->order_type;
            $promotion->only_selected_payment_method = ($request->only_selected_payment_method)?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->only_selected_cash_delivery_person)?1:0;
            $promotion->only_selected_cash = ($request->only_selected_cash)?1:0;
            $promotion->only_once_per_client = ($request->only_once_per_client)?1:0;
            $promotion->mark_promo_as = $request->mark_promo_as;
            $promotion->display_time = $request->display_time;
            $promotion->discount_usd= $request->discount_usd;
            $promotion->auto_manually_discount = $request->auto_manually_discount;
            $promotion->discount_cheapest = $request->discount_cheapest;
            $promotion->discount_expensive = $request->discount_expensive;
            $promotion->item_group_1 = $request->item_group_1;
            $promotion->item_group_2 = $request->item_group_2;
            if ($promotion->save()) {
                if(is_array($request->eligible_item)){
                    foreach($request->eligible_item as $key=>$value){
                            $eligible_item = New PromotionEligibleItem;
                            $eligible_item->eligible_item_id  = $key;
                            $eligible_item->promotion_id = $promotion->promotion_id;
                            if($eligible_item->save()){
                                foreach($value as $key1=>$value1){
                                    $category = New PromotionCategory;
                                    $category->promotion_id = $promotion->promotion_id;
                                    $category->eligible_item_id  = $key;
                                    $category->category_id = $key1;
                                    $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                    if($category->save()){
                                        if(is_array($value1)){
                                            foreach ($value1 as $key2 => $value2) {
                                                $categoryItem = New PromotionCategoryItem;
                                                $categoryItem->promotion_id = $promotion->promotion_id;
                                                $categoryItem->category_id = $key1;
                                                $categoryItem->eligible_item_id  = $key;
                                                $categoryItem->promotion_category_id = $category->promotion_category_id;
                                                $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                                $categoryItem->item_id = $key2;
                                                $categoryItem->save();
                                            }
                                        }
                                    }
                                }
                            }
                    }   
                }
                Toastr::success( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }else{
                Toastr::error( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }            
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Toastr::success('Please try again something wrong.','', Config::get('constants.toster'));
            return redirect()->route('promotion');
        }
    }





    public function editDiscountComboItem(Request $request){
        $uid = Auth::user()->uid;
        $promotion = Promotion::where('promotion_id',$request->id)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $category = Category::where('restaurant_id', $restaurant->restaurant_id)->with('category_item')->get();
        return view('promotion.fixeddiscount.edit',compact('promotion','category'));
    }

    public function storeDiscountComboItems(Request $request){
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('promotion')->with('error', 'Invalid users for this restaurant.');
            }
            if($request->promotion_id){
                PromotionEligibleItem::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategory::where('promotion_id',$request->promotion_id)->delete();
                PromotionCategoryItem::where('promotion_id',$request->promotion_id)->delete();
                $promotion = Promotion::where('promotion_id',$request->promotion_id)->first();
                $message = 'Promotion update successfully.';
            }else{
                $promotion = new  Promotion;
                $message = 'Promotion added successfully.';
            }
            $promotion->restaurant_id = $restaurant->restaurant_id;
            $promotion->promotion_type_id = 10;
            $promotion->promotion_code = $request->promotion_code;
            $promotion->promotion_name = $request->promotion_name;
            $promotion->promotion_details = $request->promotion_details;
            $promotion->dicount_usd_percentage = $request->dicount_usd_percentage;
            $promotion->dicount_usd_percentage_amount = $request->dicount_usd_percentage_amount;
            $promotion->set_minimum_order_amount = $request->set_minimum_order_amount;
            $promotion->client_type = $request->client_type;
            $promotion->no_extra_charge = $request->no_extra_charge;
            $promotion->order_type = $request->order_type;
            $promotion->only_selected_payment_method = ($request->only_selected_payment_method)?1:0;
            $promotion->only_selected_cash_delivery_person = ($request->only_selected_cash_delivery_person)?1:0;
            $promotion->only_selected_cash = ($request->only_selected_cash)?1:0;
            $promotion->only_once_per_client = ($request->only_once_per_client)?1:0;
            $promotion->mark_promo_as = $request->mark_promo_as;
            $promotion->display_time = $request->display_time;
            $promotion->discount_usd= $request->discount_usd;
            $promotion->auto_manually_discount = $request->auto_manually_discount;
            $promotion->discount_cheapest = $request->discount_cheapest;
            $promotion->discount_expensive = $request->discount_expensive;
            $promotion->item_group_1 = $request->item_group_1;
            $promotion->item_group_2 = $request->item_group_2;
            if ($promotion->save()) {
                if(is_array($request->eligible_item)){
                    foreach($request->eligible_item as $key=>$value){
                            $eligible_item = New PromotionEligibleItem;
                            $eligible_item->eligible_item_id  = $key;
                            $eligible_item->promotion_id = $promotion->promotion_id;
                            if($eligible_item->save()){
                                foreach($value as $key1=>$value1){
                                    $category = New PromotionCategory;
                                    $category->promotion_id = $promotion->promotion_id;
                                    $category->eligible_item_id  = $key;
                                    $category->category_id = $key1;
                                    $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                    if($category->save()){
                                        if(is_array($value1)){
                                            foreach ($value1 as $key2 => $value2) {
                                                $categoryItem = New PromotionCategoryItem;
                                                $categoryItem->promotion_id = $promotion->promotion_id;
                                                $categoryItem->category_id = $key1;
                                                $categoryItem->eligible_item_id  = $key;
                                                $categoryItem->promotion_category_id = $category->promotion_category_id;
                                                $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                                                $categoryItem->item_id = $key2;
                                                $categoryItem->save();
                                            }
                                        }
                                    }
                                }
                            }
                    }   
                }
                Toastr::success( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }else{
                Toastr::error( $message,'', Config::get('constants.toster'));
                return redirect()->route('promotion');
            }            
        } catch (\Throwable $th) {
            dd($th->getMessage());
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
}
