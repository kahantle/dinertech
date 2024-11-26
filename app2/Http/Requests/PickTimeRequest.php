<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PickTimeRequest extends FormRequest
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
            'sltDuration'             =>  'required',
            'sltMinutes'          =>  'required',
        ];
    }
    public function messages()
    {
        return [
            'sltDuration.required' => 'Please select duration.',
            'sltMinutes.required'  => 'Please select type.',
        ];
    }
}