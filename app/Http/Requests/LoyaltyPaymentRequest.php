<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoyaltyPaymentRequest extends FormRequest
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

        return [
            'card_number' => 'sometimes|nullable|required_if:payment_method,null|regex:/[0-9\s]+/',
            'exp_card' => 'sometimes|nullable|required_if:payment_method,null',
            // 'ccExpiryYear' => 'required',
            'cvv' => 'sometimes|nullable|required_if:payment_method,null',
            'card_holder_name' => 'sometimes|nullable|required_if:payment_method,null',
        ];

    }

    public function messages()
    {
        return [
            'payment_method.required' => 'Please select any card',
            'card_number.required' => 'Please enter card number.',
            'exp_card.required' => 'Please enter expiry month and year.',
            // 'ccExpiryYear.required' => 'Please select expiry year.',
            'cvv.required' => 'Please enter cvv.',
            'card_holder_name.required' => 'Please enter card holder name',
        ];
    }
}
