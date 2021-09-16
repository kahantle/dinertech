<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
            "email"=>"email",
            'feedback_type' => 'required',
          //  'feedback_report' => 'required',
            'suggestion' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please enter valid email.',
            'feedback_type.required' => 'Please select feedback type.',
      //      'feedback_report.required' => 'Please select feedback report.',
            'suggestion.required' => 'Please Enter feedback suggestion.',
        ];
    }
}
