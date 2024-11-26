<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionFreeitemRequest extends FormRequest
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
            // 'promotion_code' => 'required',
            'promotion_name' => 'required',
            // 'promotion_details' => 'required',
            'hidden_eligible_item'=>'required',
            // 'discount_usd_percentage'=> 'required',
            "discount_usd_percentage_amount"=>"required",
            'no_extra_charge'=>"required",
            "set_minimum_order"=>"required",
            "set_minimum_order_amount" => "required",
            "client_type" => "required",
            "order_type" => "required",
            "only_selected_payment_method" => "accepted",
            "mark_promo_as"=>"required",
            "availability"=>"required"
        ];
    }

    public function messages()
    {
        return [
            // 'promotion_code.required'=> 'Please Enter promotion code.',
            'promotion_name.required'=> 'Please Enter promotion name.',
            // 'promotion_details.required'=> 'Please Enter promotion details.',
            'no_extra_charge.required' => "Please select no extra charge.",
            'hidden_eligible_item.required' => 'Please select eligible items.',
            // 'discount_usd_percentage.required'=> 'Please select discount type.',
            'discount_usd_percentage_amount.required'=> 'Please enter discount percentage.',
            'set_minimum_order.required' => "Please select minimum order value.",
            'set_minimum_order_amount.required'=> "Please enter minimum amount.",
            'client_type.required'=> 'Please select client type.',
            'order_type.required'=> 'Please select order type.',
            "only_selected_payment_method.accepted" => 'Please select payment method.',
            "mark_promo_as.required" => "Please select mark promo as.",
            "availability.required"  => 'Please select availability.'
        ];
    }
}
