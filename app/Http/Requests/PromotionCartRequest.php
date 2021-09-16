<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionCartRequest extends FormRequest
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
            'promotion_name' => 'required',
            'promotion_details' => 'required'
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
