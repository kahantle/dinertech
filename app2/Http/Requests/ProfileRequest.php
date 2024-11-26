<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ProfileRequest extends FormRequest
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
        $uid = Auth::user()->uid;
            return [
                'fname'=>  'required',
                'lname'=>  'required',
                'email'=>  'required|email|unique:users,email_id,'.$uid.',uid',
                'mobile'=>  'required|phone:US,IN|unique:users,mobile_number,'.$uid.',uid',
                'password'=> 'nullable|min:6',
                'confirm_password' => 'required_with:password|same:password',
            ];
    }
    public function messages()
    {
        return [
            'fname.required' => 'Please enter first name.',
            'lname.required'  => 'Please enter last name.',
            'email.required'  => 'Please enter email.',
            'mobile.required'  => 'Please enter mobile.',
            'password.required'  => 'Please enter password.',
            'confirm_password.required'  => 'Please enter Confirm password.',
        ];
    }

}
