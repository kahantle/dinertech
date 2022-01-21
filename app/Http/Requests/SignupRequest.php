<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'restaurant_name' => 'required|unique:restaurants,restaurant_name',
            'address' => 'required',
            'email_id' => 'required|email|unique:users,email_id',
            'mobile_number' => 'required|phone:US,IN|unique:users,mobile_number',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'country' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Please enter first name.',
            'last_name.required' => 'Please enter last name.',
            'email.required' => 'Please enter email.',
            'phone.required' => 'Please enter phone number.',
            'phone.numeric' => 'Please enter valid phone number.',
            'password.required' => 'Please enter password.',
            'country.required' => 'Please select country.',
        ];
    }
}
