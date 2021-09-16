<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
            //'promotion_type_id' => 'required',
            'promotion_code' => 'required',
            'promotion_name' => 'required',
            'promotion_details' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
            'promotion_type_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'promotion_code.required'=> 'Please Enter promotion code.',
            'promotion_name.required'=> 'Please Enter promotion name.',
            'promotion_details.required'=> 'Please Enter promotion details.',
            'discount.required'=> 'Please Enter promotion discount.',
            'discount_type.required'=> 'Please Enter Bliing ammount.',
            'promotion_type_id.required'=> 'Please select promotion type.'
        ];
    }
}
