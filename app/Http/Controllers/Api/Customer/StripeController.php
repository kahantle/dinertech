<?php

namespace App\Http\Controllers\Api\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
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
                "card_id" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $uid = auth('api')->user()->uid;

            $get_card = Card::where('card_id', $request->post('card_id'))->where('uid', $uid)->first();

            if(!empty($get_card)) {

                $stripe = new \Stripe\StripeClient(
                    env('STRIPE_SECRET')
                );

                //////////////// OLD PAYMENT LOGIC \\\\\\\\\\\\\\\\\\
                // $charge = $stripe->charges->create([
                //             'amount' => $request->post('amount'),
                //             'currency' => $request->post('currency'),
                //             'source' => $request->post('source'),
                //             'description' => ($request->post('description')) ? $request->post('description') : null,
                //             ]);

                // for remove whitespace in card_number
                $card_number = str_replace(' ', '', $get_card->card_number);

                // for split card expiry month and year and convert into integer datatype
                $expiry_month_year = explode('/', $get_card->card_expire_date);
                $expiry_month = (int)$expiry_month_year[0];
                $expiry_year = (int)$expiry_month_year[1];

                // Create a PaymentMethod using the payment method details received from the client
                $payment_method = $stripe->paymentMethods->create([
                                    'type' => 'card',
                                    'card' => [
                                        'number' => $card_number,
                                        'exp_month' => $expiry_month,
                                        'exp_year' => $expiry_year,
                                        'cvc' => $get_card->card_cvv,
                                    ],
                                    'metadata' => [
                                        'uid' => ($get_card->uid) ? $get_card->uid : null,
                                        'card_id' => ($get_card->card_id) ? $get_card->card_id : null,
                                    ],
                                ]);
                if (isset($payment_method->id)) {
                    $payment_intent = $stripe->paymentIntents->create([
                                        'amount' => $request->post('amount'),
                                        'currency' => $request->post('currency'),
                                        'description' => ($request->post('description')) ? $request->post('description') : null,
                                        'automatic_payment_methods' => [
                                            'enabled' => true,
                                            'allow_redirects' => 'never',
                                            ],
                                        'confirm' => true,
                                        'capture_method' => 'automatic',
                                        'payment_method' => $payment_method->id,
                                        'metadata' => [
                                            'uid' => ($get_card->uid) ? $get_card->uid : null,
                                            'card_id' => ($get_card->card_id) ? $get_card->card_id : null,
                                        ],
                                    ]);//'payment_method_types' => ['card'],

                    // Check for payment success or not:
                    if (isset($payment_intent->id) && $payment_intent->status == 'succeeded') {

                        // for get payment charge id
                        $payment_charge_id = null;

                        // Decode the JSON response of payment intent
                        $response = json_decode($payment_intent, true);

                        // Check if 'charges' object and 'data' array exist
                        if (isset($response['charges']['data']) && is_array($response['charges']['data']) && count($response['charges']['data']) > 0) {

                            // Get the first object in the 'data' array
                            $firstCharge = $response['charges']['data'][0];

                            // Check if 'id' field of the first object is not empty or null
                            if (isset($firstCharge['id']) && !empty($firstCharge['id'])) {

                                // Store the 'id' in payment_charge_id variable
                                $payment_charge_id = $firstCharge['id'];
                            }
                        }

                        return response()->json(['message' => 'Payment has been charged!!','stripe_payment_id' => $payment_intent->created,'payment_method_id' => $payment_intent->payment_method,'payment_intent_id' => $payment_intent->id,'payment_intent_client_secret' => $payment_intent->client_secret,'stripe_charge_id'=> $payment_charge_id,'payment_card_id'=> $request->post('card_id'),'success' => true], 200);

                        //////////////// OLD RESPONSE \\\\\\\\\\\\\\\\\\
                        // return response()->json(['message' => 'Payment has been charged!!','stripe_payment_id' => $charge->created,'success' => true], 200);
                    } else {
                        return response()->json(['message' => 'Your payment could NOT be processed because the payment system rejected the transaction. You can try again or use another card.','success' => false], 200);
                    }
                } else {
                    return response()->json(['message' => 'Your payment could not be processed because there was some incorrect card details. You can try again or use another card.','success' => false], 200);
                }
            } else {

                return response()->json(['message' => 'User card details not found','success' => false], 200);
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
