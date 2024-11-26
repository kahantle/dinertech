<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModifierItemPriceRequest extends FormRequest
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
        if (request()->post('modifier_item_id')) {
            return [
                'modifier_item_group_id' => 'required',
                'modifier_group_item_name' => 'required',
                'modifier_group_item_price' => 'required'
            ];
        } else {
            return [
                'modifier_item_group_id' => 'required|unique:modifier_groups,modifier_group_name',
                'modifier_group_item_name' => 'required',
                'modifier_group_item_price' => 'required'
            ];
        }
    }
    public function messages()
    {
        return [
            'modifier_group_item_name.required' => 'Please enter modifier group item name.',
            'modifier_group_item_price.required' => 'Please enter modifier group item price.',
        ];
    }
}