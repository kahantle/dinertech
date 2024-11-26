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
            // 'promotion_code' => 'required',
            'promotion_name' => 'required',
            // 'promotion_details' => 'required',
            'dicount_usd_percentage'=> 'required',
            "dicount_usd_percentage_amount"=>"required",
            "set_minimum_order"=>"required",
            "set_minimum_order_amount" => "required",
            "client_type" => "required",
            "order_type" => "required",
            "only_selected_payment_method" => "accepted",
            "promotion_function" => "required",
            "availability"       => "required",
            "no_extra_charge"    => "required",
            // "mark_promo_as"=>"required",
            // "display_time"=>"required"
        ];
    }

    public function messages()
    {
        return [
            // 'promotion_code.required'=> 'Please Enter promotion code.',
            'promotion_name.required'=> 'Please Enter promotion name.',
            // 'promotion_details.required'=> 'Please Enter promotion details.',
            'dicount_usd_percentage.required'=> 'Please select discount type.',
            'dicount_usd_percentage_amount.required'=> 'Please Enter ammount.',
            'set_minimum_order.required' => "Please select minimum order value.",
            'set_minimum_order_amount.required'=> "Please enter minimum amount.",
            'client_type.required'=> 'Please select client type.',
            'order_type.required'=> 'Please select order type.',
            "only_selected_payment_method.accepted" => 'Please select payment method.',
            "promotion_function.required"   => 'Please select promotion function.',
            "no_extra_charge.required"      => 'Please select no extra charge.',
            "availability.required"         => 'Please select availability.'
            // "mark_promo_as.required" => "Please select mark promo as.",
            // "display_time.required" => "Please select display time."
        ];
    }
}
