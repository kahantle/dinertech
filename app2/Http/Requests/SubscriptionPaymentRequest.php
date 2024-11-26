<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->post('payment_method')) {
            return [
                'payment_method' => 'required',
            ];

        } else {
            return [
                'card_number' => 'required',
                'exp_card' => 'required',
                'cvv' => 'required',
                'card_holder_name' => 'required|string',
            ];
        }
    }

    public function messages()
    {
        return [
            'card_number.required' => 'Please enter card number.',
            'exp_card.required' => 'Please enter card expirations.',
            'cvv.required' => 'Please enter card cvv number.',
            'card_holder_name.required' => 'Please enter card holder name.',
            'payment_method.required' => 'Please select any card',
        ];
    }
}
