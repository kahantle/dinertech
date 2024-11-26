<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $uid = request()->segment(4);
        return [
            'email' => 'required|email|unique:users,email_id,'.$uid,
            'mobile_number' => 'required|phone:US,IN|unique:users,mobile_number,'.$uid,
        ];
    }
}
