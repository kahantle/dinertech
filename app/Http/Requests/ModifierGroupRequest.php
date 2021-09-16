<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModifierGroupRequest extends FormRequest
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
        $segmentId = request()->segment(4); //returns 'posts'
        if ($segmentId) {
            return [
                'modifier_group_name'             =>  'required|unique:modifier_groups,modifier_group_name,'.$segmentId,
            ];

        } else {
            return [
                'modifier_group_name'             =>  'required',
            ];
        }
    }
    public function messages()
    {
        return [
            'modifier_group_name.required' => 'Please enter modifier group name.',
        ];
    }
}