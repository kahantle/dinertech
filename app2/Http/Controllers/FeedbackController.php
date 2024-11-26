<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Feedback;
use App\Http\Requests\FeedbackRequest;
use Auth;
use Config;
use Toastr;

class FeedbackController extends Controller
{
 	public function index()
 	{
 		$uid = Auth::user()->uid;
      	$restaurant = Restaurant::where('uid', $uid)->first();
      	$feedbackRecords = Feedback::where('restaurant_id', $restaurant->restaurant_id)->get();
 		return view('feedback.index',compact('feedbackRecords'));
 	}

 	public function add()
 	{
        $user = Auth::user();
 		return view('feedback.add',compact('user'));
 	}

 	public function edit($id)
 	{
 		$uid = Auth::user()->uid;
      	$restaurant = Restaurant::where('uid', $uid)->first();
      	$feedbackRecords = Feedback::where('id', $id)->first();
      	return view('feedback.edit',compact('feedbackRecords'));

 	}

 	public function store(FeedbackRequest $request)
 	{
 		 try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('category')->with('error', 'Invalid users for this restaurant.');
            }
            if ($request->post('hidden_id')) {
            	$feedback = Feedback::where('id',$request->hidden_id)->first();
                $message = 'Feedback update successfully.';
            }else{
                $feedback = new Feedback;
                $message = 'Feedback added successfully.';
            }

            $feedback->restaurant_id =$restaurant->restaurant_id;
            $feedback->feedback_type = $request->post('feedback_type');
            $feedback->name = $request->post('name');
            $feedback->email = $request->post('email');
            $feedback->phone = $request->post('phone');
           // $feedback->feedback_report = $request->post('feedback_report');
            $feedback->suggestion = $request->post('suggestion');
            if ($feedback->save()) {
                Toastr::success($message,'', Config::get('constants.toster'));
                return redirect()->route('feedback.add');
            }
            Toastr::error($message,'', Config::get('constants.toster'));
            return redirect()->route('feedback.add');
        } catch (\Throwable $th) {
            return redirect()->route('feedback.add')->with('error', $th->getMessage());
        }
 	}

 	public function delete($id)
 	{
 		try {
            $alert =['Feedback does not delete successfully','', Config::get('constants.toster')];
            $feedback = Feedback::where('id', $id)->first();
            if($feedback){
                $feedback->delete();
                $alert =['Feedback delete successfully','', Config::get('constants.toster')];
            }
            return response()->json(['route'=>route('feedback'),'alert'=>$alert,'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($errors, 500);
        }
 	}
}
