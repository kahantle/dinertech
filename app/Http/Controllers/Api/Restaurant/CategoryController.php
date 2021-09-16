<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Category;
use App\Models\Restaurant;
use Config;
use File;

class CategoryController extends Controller
{
    /**
     * @method Category List
     * 
     */

    public function addCategory(Request $request)
    {
        try {
            if($request->post('category_id')){
                $validator = Validator::make($request->all(), [
                    'restaurant_id' => 'required',
                    'category_id' => 'required',
                    'category_name'=>'required|unique:categories,category_name,'.$request->post('category_id').',category_id,restaurant_id,'.$request->post('restaurant_id').'',
                  //  'category_details' => 'required'
                ]);
            }else{
                $validator = Validator::make($request->all(), [
                    'restaurant_id' => 'required',
                    'category_name'=>'required|unique:categories,category_name,NULL,category_id,restaurant_id,'.$request->post('restaurant_id').'',
                   // 'category_details' => 'required'
                ]);
            }
           
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            
            if($request->post('category_id')){
                $category = Category::where('category_id',$request->post('category_id'))->first();
                $message = "Category updated successfully.";
            }else{
                $category = new  Category;
                $message = "Category added successfully.";
            }
            $category->restaurant_id = $request->post('restaurant_id');
            $category->category_name = $request->post('category_name');
            $category->category_details = $request->post('category_details');
            if($category->save()){
                $imageName = uniqid();
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $save_name = $imageName.'.'.$image->getClientOriginalExtension();
                    $image->storeAs(Config::get('constants.IMAGES.CATEGORY_IMAGE_PATH'), $save_name);
                    $category->image = $save_name;
                    $category->save();
                }
                return response()->json(['message' => $message, 'success' => true], 200);
            }else{
                return response()->json(['message' =>  Config::get('constants.COMMON_MESSAGES.COMMON_MESSAGE'), 
                'success' => true], 200);
            }
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
     * @method Category List
     * 
     */

    public function getCategoryList(Request $request)
    {
        try {
            $request_data = $request->json()->all();
                $validator = Validator::make($request_data, [
                'restaurant_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $categoryList = Category::where('restaurant_id', $request->post('restaurant_id'))
                ->get(['category_id','restaurant_id', 'category_name', 'category_details', 'image']);
            return response()->json(['category_list' => $categoryList, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function getCategoryItemList(Request $request)
    {
        try {
            $request_data = $request->json()->all();
                $validator = Validator::make($request_data, [
                'restaurant_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $categoryList = Category::where('restaurant_id', $request->post('restaurant_id'))
                ->with('category_item')
                ->get(['category_id','restaurant_id', 'category_name', 'category_details', 'image']);
            return response()->json(['category_list' => $categoryList, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function delete(Request $request)
    {

        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'category_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $category = Category::where('category_id', $request->post('category_id'))->delete();
            return response()->json(['message'=> "Category delete successfully.",'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }
}
