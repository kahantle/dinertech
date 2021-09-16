<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Models\Restaurant;

class HourRequest extends FormRequest
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
        $user = Auth::user();
        return [
            'opening_hours' => 'required',
            'closing_hours' => 'required',
            'day.*' =>'required|min:1',
        ];
    }

    public function messages()
    {
        return [
            'day.*.required' => 'Please select at least one day.',
            'opening_hours.required' => 'select time.',
            'closing_hours.required' => 'Select time.',
        ];
    }
}
