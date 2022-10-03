<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\CustomerFcmTokens;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Otp;
use App\Notifications\RestaurantChat;
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
                'restaurant_id' => 'required',
                'fcm_id' => 'required',
                'device' => 'required',
                'password' => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $email = $request->post('email_id');
            $mobile = $request->post('mobile_number');
            $restaurantId = $request->post('restaurant_id');
            $user = User::where('role', Config::get('constants.ROLES.CUSTOMER'))
                ->whereHas('restaurant_user', function ($query) use ($restaurantId) {
                    $query->where('restaurant_id', $restaurantId);
                })
                ->where('status','!=','DELETED')
                ->where(function ($query) use ($email, $mobile) {
                    $query->where('email_id', $email);
                    $query->orWhere('mobile_number', $mobile);
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
                    $user = $user->with('address')
                        ->where('uid', $user->uid)
                        ->first(['uid', 'first_name', 'last_name', 'email_id', 'mobile_number', 'profile_image',
                            'app_notifications', 'chat_notifications', 'location_tracking']);
                    $fcmId = $request->post('fcm_id');
                    $device = $request->post('device');
                    $customerFcmToken = CustomerFcmTokens::where('uid', $user->uid)->where('fcm_id', $fcmId)->first();
                    if ($customerFcmToken == null) {
                        $customerFcmToken = new CustomerFcmTokens;
                        $customerFcmToken->uid = $user->uid;
                        $customerFcmToken->fcm_id = $fcmId;
                        $customerFcmToken->device = $device;
                        $customerFcmToken->save();
                    }
                    // User::where('uid',$user->uid)->update(['fcm_id' => $request->post('fcm_id'),'device' => $request->post('device')]);
                    return response()->json(['token' => $token, 'user' => $user, 'message' => 'You have succcessfuly login.', 'success' => true], 200);
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
            return response()->json($errors, 401);
        }
    }

    public function signup(Request $request)
    {
        try {
            $request_data = $request->json()->all();

            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email_id' => 'required|email|unique:users,email_id',
                'mobile_number' => 'required|phone:US,IN|unique:users,mobile_number',
                'password' => 'required|min:6',
                'physical_address' => 'required',
                'state' => 'required',
                'city' => 'required',
                'zip_code' => 'required',
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
            $user->role = Config::get('constants.ROLES.CUSTOMER');
            //$user->otp = mt_rand(Config::get('constantsOTP_NO_OF_DIGIT'), 9999);
            $user->otp = 1234;
            $user->otp_valid_time = Carbon::now()->addMinutes(Config::get('constants.OTP_VALID_DURATION'));
            $user->status = Config::get('constants.STATUS.INACTIVE');
            $user->save();
            $otp = new Otp();
            $otp->sendOTP($user);
            $restaurantUser = new RestaurantUser;
            $restaurantUser->uid = $user->uid;
            $restaurantUser->restaurant_id = $request->post('restaurant_id');
            $restaurantUser->status = Config::get('constants.STATUS.ACTIVE');
            $restaurantUser->save();
            $user_address = new CustomerAddress;
            $user_address->uid = $user->uid;
            $user_address->address = $request->post('physical_address');
            $user_address->state = $request->post('state');
            $user_address->city = $request->post('city');
            $user_address->zip = $request->post('zip_code');
            $user_address->save();
            DB::commit();

            $restaurant_detail = Restaurant::where('restaurant_id', $request->post('restaurant_id'))->first();
            if ($restaurant_detail->cm_client_id) {
                $customer = [
                    'email' => $user->email_id,
                    'name' => $user->getFullNameAttribute(),
                    'uid' => $user->uid,
                ];
                create_subscriber($restaurant_detail->cm_client_id, $customer, $restaurant_detail->restaurant_id);
            }

            return response()->json(['message' => 'You have successfully signup.', 'success' => true], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 401);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $request_data = $request->json()->all();

            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'otp' => 'required',
                'email_id' => 'required_without:mobile_number|email',
                'mobile_number' => 'required_without:email_id|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $restaurantId = $request->post('restaurant_id');
            $email = $request->post('email_id');
            $mobile = $request->post('mobile_number');
            $user = User::where('role', Config::get('constants.ROLES.CUSTOMER'))
                ->where('otp', $request->post('otp'))
                ->whereHas('restaurant_user', function ($query) use ($restaurantId) {
                    $query->where('restaurant_id', $restaurantId);
                })
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
                return response()->json(['uid' => $user->uid, 'message' => 'You account succcessfully verified.', 'success' => true], 200);
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
            return response()->json($errors, 401);
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $request_data = $request->json()->all();

            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'email_id' => 'required_without:mobile_number|email',
                'mobile_number' => 'required_without:email_id|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $restaurantId = $request->post('restaurant_id');
            $email = $request->post('email_id');
            $mobile = $request->post('mobile_number');
            $user = User::where('role', Config::get('constants.ROLES.CUSTOMER'))
                ->where(function ($query) use ($email, $mobile) {
                    $query->where('email_id', $email);
                    $query->orWhere('mobile_number', $mobile);
                })
                ->whereHas('restaurant_user', function ($query) use ($restaurantId) {
                    $query->where('restaurant_id', $restaurantId);
                })->first();
            if ($user) {
                DB::beginTransaction();
                //$user->otp = mt_rand(Config::get('constantsOTP_NO_OF_DIGIT'), 9999);
                $user->otp = 1234;
                $user->otp_valid_time = Carbon::now()->addMinutes(Config::get('constants.OTP_VALID_DURATION'));
                $user->save();
                $otp = new Otp();
                $otp->sendOTP($user);
                DB::commit();
                return response()->json(['message' => 'OTP sent succcessfully.', 'success' => true], 200);
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
            return response()->json($errors, 401);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request_data = $request->json()->all();

            $validator = Validator::make($request_data, [
                'uid' => 'required',
                'restaurant_id' => 'required',
                'password' => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $restaurantId = $request->post('restaurant_id');
            $user = User::where('uid', $request->post('uid'))
                ->where('role', Config::get('constants.ROLES.CUSTOMER'))
                ->whereHas('restaurant_user', function ($query) use ($restaurantId) {
                    $query->where('restaurant_id', $restaurantId);
                })
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
            return response()->json($errors, 401);
        }
    }

    public function logout(Request $request)
    {
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
            CustomerFcmTokens::where('uid', $uid)->where('fcm_id', $fcmId)->delete();
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

    public function changePassword(Request $request)
    {
        try {
            $request_data = $request->json()->all();

            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'current_password' => 'required|min:6',
                'new_password' => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            $restaurantId = $request->post('restaurant_id');
            $user = User::where('uid', $uid)
                ->where('role', Config::get('constants.ROLES.CUSTOMER'))
                ->whereHas('restaurant_user', function ($query) use ($restaurantId) {
                    $query->where('restaurant_id', $restaurantId);
                })->first();
            if ($user) {
                DB::beginTransaction();
                $user->password = Hash::make($request->post('new_password'));
                $user->save();
                DB::commit();
                return response()->json(['message' => 'Password changed successfully.', 'success' => true], 200);
            } else {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => "User not found."], 400);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 401);
        }
    }

    public function profile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'physical_address' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            DB::beginTransaction();
            $uid = auth('api')->user()->uid;
            $user = User::where('uid', $uid)->first();
            if ($request->hasFile('item_img')) {
                $image = $request->file('item_img');
                $save_name = $uid . '.' . $image->getClientOriginalExtension();
                $image->storeAs(Config::get('constants.IMAGES.USER_IMAGE_PATH'), $save_name);
                $user->profile_image = $save_name;
            }
            $user->first_name = $request->post('first_name');
            $user->last_name = $request->post('last_name');
            $user->save();
            $user_address = CustomerAddress::where('uid', $uid)->first();
            if (!$user_address) {
                $user_address = new CustomerAddress;
            }
            $user_address->address = $request->post('physical_address');
            $user_address->uid = $uid;
            $user_address->save();
            DB::commit();
            $user = $user->with('address')
                ->where('uid', $user->uid)
                ->first(['uid', 'first_name', 'last_name', 'email_id', 'mobile_number', 'profile_image', 'app_notifications', 'chat_notifications', 'location_tracking']);
            return response()->json(['message' => 'You have succcessfully update profile.', 'success' => true, 'user' => $user], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 401);
        }
    }

    public function sendChatNotification(Request $request)
    {
        try {
            $request_data = $request->json()->all();

            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'order_number' => 'required',
                'message' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $orderId = $request->post('order_number');
            $restaurantId = $request->post('restaurant_id');
            $message = $request->post('message');
            $restaurant = Restaurant::with(['order' => function ($order) use ($orderId, $restaurantId) {
                $order->where('order_number', $orderId)->where('restaurant_id', $restaurantId)->first();
            }])->first();
            $messageData = ['message' => $message,'order_id' => (string) $restaurant->order->order_id, 'order_number' => (string) $restaurant->order->order_number];
            $restaurant->notify(new RestaurantChat($messageData));
            $messageCount = $restaurant->order->customer_msg_count + 1;
            Order::where('order_id',$restaurant->order->order_id)->where('restaurant_id',$restaurantId)->update(['customer_msg_count' => $messageCount]);
            return response()->json(['message' => 'Chat notification send successfully.', 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 401);
        }
    }

    public function deleteAccount()
    {
        $user = auth('api')->user();
        $user->delete();
        // $user->update([
        //     'status' => Config::get('constants.STATUS.DELETED')
        // ]);
        return response()->json(['message' => 'Account deleted successfully.', 'success' => true], 200);
    }

}
