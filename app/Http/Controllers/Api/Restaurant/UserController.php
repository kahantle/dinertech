<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantFcmTokens;
use App\Models\User;
use App\Notifications\Otp;
use Auth;
use Carbon\Carbon;
use Config;
use DB;
use Hash;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{

    /**
     * @method login
     *
     */

    public function login(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'email_id' => 'required_without:mobile_number|email',
                'mobile_number' => 'required_without:email_id|numeric',
                'fcm_id' => 'required',
                'device' => 'required',
                'password' => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $email = $request->post('email_id');
            $mobile_number = $request->post('mobile_number');
            $user = User::where('role', Config::get('constants.ROLES.RESTAURANT'))
                ->where(function ($query) use ($email, $mobile_number) {
                    $query->where('email_id', $email);
                    $query->orWhere('mobile_number', $mobile_number);
                })->first();
            if (!$user) {
                return response()->json(['success' => false, 'message' => "User not found."], 400);
            }
            if (!$user->is_verified_at) {
                return response()->json(['success' => false, 'message' => "Please verify this account."], 400);
            }
            if ($user) {
                if (Hash::check($request->post('password'), $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $user = $user->with('restaurant')
                        ->where('uid', $user->uid)
                        ->get(['uid', 'first_name', 'last_name',
                            'email_id', 'mobile_number', 'profile_image',
                            'app_notifications', 'chat_notifications',
                            'location_tracking', 'email_subscription','sales_tax','pin','loyalty_subscription'])
                        ->first()
                        ->makeHidden('restaurant');

                    // User::where('uid',$user->uid)->update(['fcm_id' => $request->post('fcm_id'),'device' => $request->post('device')]);
                    $user->email_subscription = $user->email_subscription;
                    $user->email_subscription_web_url = ($user->email_subscription == Config::get('constants.STATUS.ACTIVE')) ? route('restaurant.email.campaigns') . '/' . $user->uid : route('restaurant.email.subscriptions.list') . '/' . $user->uid;
                    $user->loyalty_subscription = $user->loyalty_subscription;
                    $user->loyalty_subscription_web_url = ($user->loyalty_subscription == Config::get('constants.STATUS.ACTIVE')) ? route('mobile_view.loyalties.list', $user->uid) : null ;
                    $user->restaurant_name = $user->restaurant->restaurant_name;
                    $user->restaurant_id = $user->restaurant->restaurant_id;
                    $user->restaurant_address = $user->restaurant->restaurant_address;
                    $user->restaurant_city = $user->restaurant->restaurant_city;
                    $user->restaurant_state = $user->restaurant->restaurant_state;
                    $user['menu_pin'] = $user->pin;
                    $user->is_pin_protected = ($user->restaurant->is_pinprotected) ? true : false;
                    $user->pin = ($user->restaurant->pin) ?? NULL;
                    $user->sales_tax = $user->restaurant->sales_tax;

                    $fcmId = $request->post('fcm_id');
                    $device = $request->post('device');
                    $restaurantFcmToken = RestaurantFcmTokens::where('restaurant_id', $user->restaurant->restaurant_id)->where('fcm_id', $fcmId)->first();
                    if ($restaurantFcmToken == null) {
                        $restaurantFcmToken = new RestaurantFcmTokens;
                        $restaurantFcmToken->uid = $user->uid;
                        $restaurantFcmToken->restaurant_id = $user->restaurant->restaurant_id;
                        $restaurantFcmToken->fcm_id = $fcmId;
                        $restaurantFcmToken->device = $device;
                        $restaurantFcmToken->save();
                    }
                    return response()->json(['token' => $token, 'user' => $user, 'message' => 'You have successfully login.', 'success' => true], 200);
                } else {
                    return response()->json(['success' => false, 'message' => "Please enter a valid email or mobile and password."], 400);
                }
            }
            return response()->json(['success' => false, 'message' => "Please enter email or mobile."], 400);
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

    public function signup(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email_id' => 'required|email|unique:users,email_id',
                'mobile_number' => 'required|phone:US,IN|unique:users,mobile_number',
                'password' => 'required|min:6',
                'restaurant_address' => 'required',
                'restaurant_name' => 'required|unique:restaurants,restaurant_name',
                'restaurant_city' => 'required',
                'restaurant_state' => 'required',
                'restaurant_zip' => 'required|numeric',
            ], ['mobile_number.phone' => 'PLease enter valid phone format.']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            DB::beginTransaction();
            $user = new User();
            $user->first_name = $request->post('first_name');
            $user->last_name = $request->post('last_name');
            $user->email_id = $request->post('email_id');
            $user->mobile_number = $request->post('mobile_number');
            $user->password = Hash::make($request->post('password'));
            $user->role = Config::get('constants.ROLES.RESTAURANT');
            $user->app_notifications = 0;
            $user->chat_notifications = 0;
            $user->location_tracking = 0;
            //$user->otp = mt_rand(Config::get('constantsOTP_NO_OF_DIGIT'), 9999);
            $user->otp = 1234;
            $user->otp_valid_time = Carbon::now()->addMinutes(Config::get('constants.OTP_VALID_DURATION'));
            $user->status = Config::get('constants.STATUS.INACTIVE');
            $user->save();
            $otp = new Otp();
            $otp->sendOTP($user);
            $restaurant = new Restaurant;
            $restaurant->uid = $user->uid;
            $restaurant->restaurant_name = $request->post('restaurant_name');
            $restaurant->restaurant_state = $request->post('restaurant_state');
            $restaurant->restaurant_city = $request->post('restaurant_city');
            $restaurant->restaurant_zip = $request->post('restaurant_zip');
            $restaurant->restaurant_address = $request->post('restaurant_address');
            $restaurant->save();
            DB::commit();
            return response()->json(['message' => 'Restaurant successfully created.', 'success' => true], 200);
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

    public function verifyOtp(Request $request)
    {
        try {
            $request_data = $request->json()->all();

            $validator = Validator::make($request_data, [
                'otp' => 'required',
                'email_id' => 'required_without:mobile_number|email',
                'mobile_number' => 'required_without:email_id|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $email = $request->post('email_id');
            $mobile = $request->post('mobile_number');
            $user = User::where('role', Config::get('constants.ROLES.RESTAURANT'))
                ->where('otp', $request->post('otp'))
                ->where(function ($query) use ($email, $mobile) {
                    $query->where('email_id', $email);
                    $query->orWhere('mobile_number', $mobile);
                })
                ->first();
            if ($user) {
                DB::beginTransaction();
                $user->is_verified_at = Carbon::now();
                $user->otp = null;
                $user->otp_valid_time = null;
                $user->status = Config::get('constants.STATUS.ACTIVE');
                $user->save();
                DB::commit();
                return response()->json(['uid' => $user->uid, 'message' => 'You account successfully verified.', 'success' => true], 200);
            } else {
                return response()->json(['success' => false, 'message' => "Please enter valid otp."], 400);
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

    public function forgotPassword(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'email_id' => 'required_without:mobile_number|email',
                'mobile_number' => 'required_without:email_id|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $email = $request->post('email_id');
            $mobile = $request->post('mobile_number');
            $user = User::where(function ($query) use ($email, $mobile) {
                $query->where('email_id', $email);
                $query->orWhere('mobile_number', $mobile);
            })->where('role', Config::get('constants.ROLES.RESTAURANT'))
                ->first();
            if ($user) {
                DB::beginTransaction();
                //$user->otp = mt_rand(Config::get('constantsOTP_NO_OF_DIGIT'), 9999);
                $user->otp = 1234;
                $user->otp_valid_time = Carbon::now()->addMinutes(Config::get('constants.OTP_VALID_DURATION'));
                $user->save();
                DB::commit();
                return response()->json(['message' => 'OTP sent successfully.', 'success' => true], 200);
            } else {
                return response()->json(['success' => false, 'message' => "User not found."], 400);
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

    public function resetPassword(Request $request)
    {
        try {
            $request_data = $request->json()->all();

            $validator = Validator::make($request_data, [
                'uid' => 'required',
                'password' => 'required|min:6',

            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $user = User::where('uid', $request->post('uid'))
                ->where('role', Config::get('constants.ROLES.RESTAURANT'))
                ->first();
            if ($user) {
                DB::beginTransaction();
                $user->password = Hash::make($request->post('password'));
                $user->save();
                DB::commit();
                return response()->json(['message' => 'Password reset successfully.', 'success' => true], 200);
            } else {
                return response()->json(['success' => false, 'message' => "User not found."], 400);
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

    public function logout(Request $request)
    {
        // return response()->json(['message' => 'You have been successfully logged out!', 'success' => true], 200);
        try {
            $request_data = $request->json()->all();

            $validator = Validator::make($request_data, [
                'fcm_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            $fcmId = $request->post('fcm_id');
            RestaurantFcmTokens::where('uid', $uid)->where('fcm_id', $fcmId)->delete();
            $token = auth('api')->user()->token();
            $token->revoke();
            return response()->json(['message' => 'You have been successfully logged out!', 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 401);
        }

    }

    public function setSalesTax(REQUEST $request)
    {
        try {

            $restaurant = auth('api')->user()->restaurant;
            $restaurant->sales_tax = $request->sales_tax;
            $restaurant->save();
            return response()->json(['message' => 'Sales tax set successfully.', 'success' => true], 200);

        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 401);
        }

    }
    public function store_pin(Request $request)
    {
        try {
            $uid = auth('api')->user()->uid;
            User::where('uid', $uid)->update(['pin' => $request->post('pin'), 'pin_notifications' => 'true']);

            return response()->json(['message' => 'Pin set successfully.', 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 401);
        }
    }

}
