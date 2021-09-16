<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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
            //'modifier_group_id' => 'required',
            'item_img' =>  'mimes:jpeg,png,JFIF',
            'item_name' => 'required',
            'item_details' => 'required',
            'category_id' => 'required',
            'item_price' => 'required',
            'modifier_group_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'restaurant_id.required' => 'Please select restaurant id.',
            'modifier_group_id.required' => 'Please select group id',
            'item_img.mimes' => 'please select valid image.',
            'item_name.required' => 'Please enter item name',
            'item_details.required' => 'Please enter item details.',
            'category_id.required' => 'Please select any category.',
            'item_price.required' => 'Please enter price.',
            'modifier_group_id.required' => 'Please select any modifier.'
        ];
    }
}