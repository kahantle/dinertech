<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantSubscription;
use App\Models\User;
use Auth;
//use Bashy\CampaignMonitor\Facades\CampaignMonitor;
use CampaignMonitor;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Toastr;
use Illuminate\Support\Facades\Http;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $checkSubscription = auth()->user()->email_subscription;
            if ($checkSubscription == Config::get("constants.SUBSCRIPTION.INACTIVE")) {
                return redirect()->route('subscriptions');
            } else {
                $uid = auth()->user()->uid;
                $restaurant = Restaurant::withCount('subscribers')->where('uid', $uid)->first();
                $data['restaurant_subscribers'] = $restaurant->subscribers_count;
                $currentPlan = RestaurantSubscription::with(['payment', 'subscription'])->where('restaurant_id', $restaurant->restaurant_id)->where('status', Config::get('constants.STATUS.ACTIVE'))->orderBy('restaurant_subscription_id', 'desc')->first();
                // $planSubscriberLimit = explode('-', $currentPlan->subscription->subscribers);
                // if ($restaurant->subscribers_count > 1) {
                //     RestaurantSubscription::where('uid', $uid)->where('restaurant_id', $restaurant->restaurant_id)->update(['status' => Config::get("constants.STATUS.INACTIVE")]);
                // }

                $data['currentPlan'] = $currentPlan->subscription;
                $data['stripeSubscription'] = json_decode($currentPlan->payment->response);
                // try {
                   $data['sentCampaigns'] = array();
                   $data['draftCampaigns'] = array();
                   if ($restaurant->cm_client_id != null) {
                       $draftCampaigns = CampaignMonitor::clients($restaurant->cm_client_id)->get_drafts();

                       if (!$draftCampaigns->response->Code) {
                            $data['draftCampaigns'] = $draftCampaigns->response;
                       }

                       $sentCampaigns = CampaignMonitor::clients($restaurant->cm_client_id)->get_campaigns();
                       if (!$sentCampaigns->response->Code) {
                           $data['sentCampaigns'] = $sentCampaigns->response;
                       }
                   }
                   return view('campaign.index', $data); 

                // } catch (\Throwable $th) {
                //     return redirect()->back()->with('error',$th->getMessage());
                // }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $uid = auth()->user()->uid;
//            dd($uid);
            $restaurant = Restaurant::where('uid', $uid)->first();
//            dd($restaurant);
            $data = array(
                'Email' => Config::get('constants.CAMPAIGN_MONITOR.EMAIL'),
                'Chrome' => Config::get('constants.CAMPAIGN_MONITOR.CHROME'),
                'Url' => '/campaigns/',
                'IntegratorID' => env('CAMPAIGNMONITOR_INTEGRATOR_ID'),
                'ClientID' => $restaurant->cm_client_id,
            );

//            dd($restaurant->cm_client_id);
//               dd($data);
//            Log::info('Campaign creation data:', $data);
//
//            // Make sure CampaignMonitor facade or class is correctly instantiated
//            if (class_exists('CampaignMonitor')) {
//                $clientCreate = CampaignMonitor::getExternalSession($data);
//                return redirect($clientCreate->response->SessionUrl);
//            } else {
//                throw new \Exception('CampaignMonitor class not found.');
//            }


            $clientCreate = CampaignMonitor::getExternalSession($data);
            return redirect($clientCreate->response->SessionUrl);

        } catch (\Throwable $th) {
            Log::error("Error in add campaign: " . $th->getMessage());
            Toastr::error("Some Error in add campaign.", '', Config::get('constants.toster'));
            return back();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $campaignId = $request->post('campaignId');
        try {
            $summary = CampaignMonitor::campaigns($campaignId)->get_summary();
            $data['summary'] = $summary->response;
            $view = view('campaign.report', $data)->render();
            return response()->json(['success' => true, 'view' => $view], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'some error in report detail.'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $campaignId = $request->post('campaignId');
        try {
            $delete = CampaignMonitor::campaigns($campaignId)->delete();
            if ($delete->was_successful()) {
                $alert = ['Campaign delete successfully', '', Config::get('constants.toster')];
            }
            return response()->json(['alert' => $alert, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($errors, 500);
        }

    }

    public function getAllSubscribers(Request $request)
    {
        try {
            $uid = auth()->user()->uid;
            // dd($uid);
            $restaurant = Restaurant::where('uid', $uid)->first();
            // return  response()->json($restaurant);
            // Your API key and client ID
            $apiKey = env('CAMPAIGNMONITOR_API_KEY'); // Replace with your actual API key
            $clientId = '93C6142E4BF192C4';//$restaurant->cm_client_id; // The client ID of the restaurant

            // API URL to fetch all subscribers for the client
            $url = "https://api.createsend.com/api/v3.2/clients/{$clientId}/subscribers.json";

            // Make the API request
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,  // Ensure you use the correct auth method
            ])->get($url);

            if ($response->successful()) {
                // Return the list of all subscribers
                return $response->json();  // This will return the response data as an array
            } else {
                // Handle the error response
                return null;  // Or handle as needed (log errors, etc.)
            }
        } catch (\Exception $er) {
            return response()->json(['message'=>$er->getMessage()], 500);
        }
    }

    public function getClients(Request $request)
    {
        try {

            // Your API Key
            $apiKey = env('CAMPAIGNMONITOR_API_KEY');  // Replace with your actual API key
            // $apiKey = 'your_campaign_monitor_api_key'; // Replace with your actual API key

            // The API URL to fetch clients
            $url = "https://api.createsend.com/api/v3.2/clients.json";

            // Make the API call
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,  // Assuming OAuth 2.0 or just using the API key for authorization
            ])->get($url);

            // Check if the response was successful
            if ($response->successful()) {
                // Return the list of clients
                $clients = $response->json(); // This will parse the JSON response into an array
                return $clients; // You can return or process this data as needed
            } else {
                // Handle the error (e.g., invalid API key, rate limit exceeded)
                return response()->json(['error' => 'Failed to fetch clients'], 400);
            }
            // Fetch clients for the current account
            $clients = CampaignMonitor::clients(); // This will fetch all the clients

            return response()->json($clients);
            // If you need the specific client ID for a restaurant
            foreach ($clients as $client) {
                // Assuming the client object contains the name and clientId
                // if ($client->name == $restaurant->name) {
                    // You found the client, now get the client ID
                    $clientId = $client->clientId;
                    return $clientId;  // You can return this Client ID or use it for further API calls
                // }
            }
            $apiKey = env('CAMPAIGNMONITOR_API_KEY');  // Replace with your actual API key

            // Make the API request to fetch the list of clients
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,  // Ensure correct auth method
            ])->get('https://api.createsend.com/api/v3.2/clients.json');

            if ($response->successful()) {
                // Parse and return the client data
                $clients = $response->json();
                return $clients;  // This will contain an array of clients with their details, including Client ID
            } else {
                // Handle errors (e.g., invalid API key, issues with the request)
                return null;  // Or handle as needed (log errors, etc.)
            }
        } catch (\Exception $er) {
            return response()->json(['message'=>$er->getMessage()], 500);
        }
    }
}
