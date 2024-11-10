<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $digits_between = settings('min_phone_no_digit') != null && settings('max_phone_no_digit') != null ? 'digits_between:' . settings('min_phone_no_digit') . ',' . settings('max_phone_no_digit') : '';

        return [
            'name' => 'required|max:255',
            'phone' => [
                'required',
                'numeric',
                $digits_between,
                'unique:users,phone,' . $this->user->id,
            ],
            'email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|max:255|unique:users,email,' . $this->user->id,
            'role_id' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:25000',
        ];
    }
}
