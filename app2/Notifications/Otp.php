<?php

namespace App\Notifications;

use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtp;

class Otp extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function sendOTP($user)
    {
        $url = 'https://us.sms.api.sinch.com/xms/v1/' . Config::get('constants.SNICH_KEY.PLAN_ID') . '/batches';

        $messages = Config::get('constants.SNICH_KEY.MESSAGE') . " : " . $user->otp;
        Http::withHeaders([
            'Authorization' => Config::get('constants.SNICH_KEY.TOKEN'),
            'Content-Type' => 'application/json',
        ])->post($url, [
            'from' => Config::get('constants.SNICH_KEY.FROM'),
            'to' => ['+1'.$user->mobile_number],
            'body' => $messages,
        ]);
        
        $data['user'] = $user;
        $data['messages'] = "Your Activate Account OTP is: ". $user->otp;
        Mail::to($user->email_id)->send(new SendOtp($data));       
        return true;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
