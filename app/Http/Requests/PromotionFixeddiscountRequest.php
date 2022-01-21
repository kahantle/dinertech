<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionFixeddiscountRequest extends FormRequest
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
            'minimum_order_status' => 'required',
            'auto_manually_discount' => 'required',
            "discount_usd_percentage_amount"=>"required",
            'no_extra_charge'=>"required",
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
            'promotion_name.required'=> 'Please Enter promotion name.',
            'minimum_order_status.required' =>'Please select minimum order status',
            'auto_manually_discount.required' => 'Please select discount',
            'no_extra_charge.required' => "Please select no extra charge.",
            'discount_usd_percentage_amount.required'=> 'Please enter discount amount.',
            'client_type.required'=> 'Please select client type.',
            'order_type.required'=> 'Please select order type.',
            "only_selected_payment_method.accepted" => 'Please select payment method.',
            "mark_promo_as.required" => "Please select mark promo as.",
            "availability.required" => "Please select availability."
        ];
    }
}
