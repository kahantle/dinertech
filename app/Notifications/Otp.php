<?php

namespace App\Notifications;

use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

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
        $url = 'https://sms.api.sinch.com/xms/v1/' . Config::get('constants.SNICH_KEY.PLAN_ID') . '/batches';
        // $url = 'https: //us.sms.api.sinch.com/xms/v1/' . Config::get('constants.SNICH_KEY.PLAN_ID') . '/batches';

        $messages = Config::get('constants.SNICH_KEY.MESSAGE') . " : " . $user->otp;
        Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => Config::get('constants.SNICH_KEY.TOKEN'),
        ])->post($url, [
            'from' => Config::get('constants.SNICH_KEY.FROM'),
            'to' => [$user->mobile_number],
            'body' => $messages,
        ]);
        // Mail::send('emails.otp',  ['messages' => $messages], function ($m) use ($user) {
        //     $m->to($user->email_id, $user->FullName)->subject(config('app.name') . " OTP ");
        // });
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
