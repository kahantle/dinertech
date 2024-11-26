<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Category;
use App\Models\Card;
use Config;
use App\Models\OrderPayment;
use DB;
use Cartalyst\Stripe\Stripe;

class PaymentController extends Controller
{
   
    public function payment(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'exp_month' => 'required',
                'exp_year' => 'required',
                'card_number' => 'required',
                'card_holder_name' => 'required',
                'card_cvv' => 'required',
                'amount' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $stripe = Stripe::make(env('STRIPE_SECRET'));
            $token = $stripe->tokens()->create([
                'card' => [
                'number' =>  $request->post('card_number'),
                'exp_month' => $request->get('exp_month'),
                'exp_year' => $request->get('exp_year'),
                'cvc' => $request->get('card_cvv'),
                ],
            ]);
             
            if (!isset($token['id'])) {
                return response()->json(['message' => "Invalid card details please try again.", 'success' => true], 401);
            }
            $charge = $stripe->charges()->create([
                'card' => $token['id'],
                'currency' => 'USD',
                'amount' => $request->post('amount'),
                'description' => 'restaurants initial changes',
            ]);
            $uid = auth('api')->user()->uid;

            if($charge['status'] == 'succeeded') {
                DB::beginTransaction();
                $payment = New OrderPayment;
                $payment->uid =   $uid ;
                $payment->status = 'SUCCESS';
                $payment->amount =  $request->post('amount');
                $payment->currency = 'USD';
                $payment->response = json_encode($charge);
                $payment->save();
                DB::commit();
                return response()->json(['message' => "You successfully paid.", 'stripe_payment_id'=>$charge['id'], 'success' => true], 200);
            }else{
                return response()->json(['message' => "You does not successfully paid.", 'success' => true], 401);
            } 
      
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }
}
