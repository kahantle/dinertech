<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $segmentId = request()->segment(4);
        if ($segmentId) {
            return [
                'name'  =>  'required|unique:categories,name,'.$segmentId,
            ];

        } else {
            return [
                'name'  =>  'required',
            ];
        }
    }
    public function messages()
    {
        return [
            'name.required' => 'Please enter category name.',
        ];
    }
}