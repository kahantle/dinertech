<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoyaltyRuleRequest extends FormRequest
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
            'point' => 'required|numeric',
            'menuItems' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'point.required' => 'Please enter point.',
            'menuItems.required' => 'Please select menu items.',
        ];
    }
}
