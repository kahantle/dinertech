<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Config;

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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }
    public function sendOTP($user)
    {
        $url = 'https://sms.api.sinch.com/xms/v1/' . Config::get('constants.SNICH_KEY.PLAN_ID') . '/batches';
        $messages =  Config::get('constants.SNICH_KEY.MESSAGE') . " : " . $user->otp;
        Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => Config::get('constants.SNICH_KEY.TOKEN'),
        ])->post($url, [
            'from' => Config::get('constants.SNICH_KEY.FROM'),
            'to' => [$user->mobile_number],
            'body' =>    $messages
        ]);
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
