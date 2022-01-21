<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'digit.*' => 'required|numeric',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'digit.*.required'       => '',
            'ccExpiryMonth.required'        => 'Please select expiry month.',
            'ccExpiryYear.required'            => 'Please select expiry year.',
            'cvvNumber.required'            => 'Please enter cvv.'
        ];
    }
}
