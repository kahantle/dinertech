<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantSubscription;
use App\Models\User;
use Auth;
use Config;
use Illuminate\Http\Request;
use Toastr;

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
                       $draftCampaigns = \CampaignMonitor::clients($restaurant->cm_client_id)->get_drafts();
                       
                       if (!$draftCampaigns->response->Code) {
                            $data['draftCampaigns'] = $draftCampaigns->response;
                       }

                       $sentCampaigns = \CampaignMonitor::clients($restaurant->cm_client_id)->get_campaigns();
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
            $restaurant = Restaurant::where('uid', $uid)->first();
            $data = array(
                'Email' => Config::get('constants.CAMPAIGN_MONITOR.EMAIL'),
                'Chrome' => Config::get('constants.CAMPAIGN_MONITOR.CHROME'),
                'Url' => '/campaigns/',
                'IntegratorID' => env('CAMPAIGNMONITOR_INTEGRATOR_ID'),
                'ClientID' => $restaurant->cm_client_id,
            );
            $clientCreate = \CampaignMonitor::getExternalSession($data);
            return redirect($clientCreate->response->SessionUrl);
        } catch (\Throwable $th) {
            $message = "Some Error in add campaign.";
            Toastr::error($message, '', Config::get('constants.toster'));
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
            $summary = \CampaignMonitor::campaigns($campaignId)->get_summary();
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
            $delete = \CampaignMonitor::campaigns($campaignId)->delete();
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
}
