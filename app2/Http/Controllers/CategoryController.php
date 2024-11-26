<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Config;
use Auth;
use Toastr;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        $categories = Category::where('restaurant_id',$restaurant->restaurant_id);
        $params = $request->get('searchText');
        if($params){
            $categories = $categories->where('category_name', 'like', '%' . $params . '%');
            $categories = $categories->orWhere('category_details', 'like', '%' . $params . '%');
        }
        $categories = $categories->paginate(Config::get('constants.PAGINATION_PER_PAGE'));
        return view('category.index', compact('categories','params'));
    }

    public function add()
    {
        return view('category.add');
    }

    public function store(CategoryRequest $request)
    {
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('category')->with('error', 'Invalid users for this restaurant.');
            }
            $category = new  Category;
            $category->restaurant_id =$restaurant->restaurant_id;
            $category->category_name = $request->post('name');
            $category->category_details = $request->post('details');
            if ($request->hasFile('profile_photo')) {
                $image = $request->file('profile_photo');
                $save_name =  $request->post('name') . '.' . $image->getClientOriginalExtension();
                $image->storeAs(Config::get('constants.IMAGES.CATEGORY_IMAGE_PATH'), $save_name);
                $category->image = $save_name;
            }
            if ($category->save()) {
                Toastr::success('Category added successfully.','', Config::get('constants.toster'));
                return redirect()->route('category');
            }
            Toastr::error('Category does not added successfully.','', Config::get('constants.toster'));
            return redirect()->route('category');
        } catch (\Throwable $th) {
            return redirect()->route('category')->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $category = Category::where('category_id', $id)->first();
        return view('category.edit', compact('category'));
    }


    public function update(CategoryRequest $request)
    {
        $category  = Category::findOrFail($request->hidden_id);
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        if (!$restaurant) {
            return redirect()->route('category')->with('error', 'Invalid users for this restaurant.');
        }
        $category->restaurant_id = $restaurant->restaurant_id;
        $category->category_name = $request->post('name');
        $category->category_details = $request->post('details');
        if ($request->hasFile('profile_photo')) {
                $image = $request->file('profile_photo');
                $save_name =  $request->post('name') . '.' . $image->getClientOriginalExtension();
                $image->storeAs(Config::get('constants.IMAGES.CATEGORY_IMAGE_PATH'), $save_name);
                $category->image = $save_name;
            }
        if ($category->save()) {
            Toastr::success('Category update successfully.','', Config::get('constants.toster'));
            return redirect()->route('category');      
          } else {
            Toastr::success('Category does not update successfully.','', Config::get('constants.toster'));
            return redirect()->route('category');
        }
    }


    public function delete($id)
    {

        try {
            $alert =['Category does not delete successfully','', Config::get('constants.toster')];
            $category = Category::where('category_id', $id)->first();
            if($category){
                $category->delete();
                $alert =['Category delete successfully','', Config::get('constants.toster')];
            }
            return response()->json(['route'=>route('category'),'alert'=>$alert,'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($errors, 500);
        }
    }
}
