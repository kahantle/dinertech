<?php

namespace App\Http\Controllers\Api\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use Validator;

class StripeController extends Controller
{
    public function getConnectionToken(Request $request)
    {
        try {
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );
            $connectionToken = $stripe->terminal->connectionTokens->create([]);
            return response()->json(['message' => 'Stripe secret create successfully.','data' => $connectionToken,'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function createCharge(Request $request)
    {
        try {
            $request_data = $request->json()->all();

            $validator = Validator::make($request_data, [
               "amount" => "required",
               "currency" => "required",
               "source"  => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );

            $charge = $stripe->charges->create([
                        'amount' => $request->post('amount'),
                        'currency' => $request->post('currency'),
                        'source' => $request->post('source'),
                        'description' => ($request->post('description')) ? $request->post('description') : null,
                        ]);
            // Check that it was paid:
	        if ($charge->paid == true) {
                return response()->json(['message' => 'Payment has been charged!!','stripe_payment_id' => $charge->created,'success' => true], 200);
            }
            else {
                return response()->json(['message' => 'Your payment could NOT be processed because the payment system rejected the transaction. You can try again or use another card.','success' => false], 200);
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
}
