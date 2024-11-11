<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
        
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required|max:255',
                    'phone' => [
                        'required',
                        'numeric',
                        $digits_between,
                        'unique:users,phone',
                        Rule::unique('users')->whereNull('deleted_at'),
                    ],
                    'email' => [
                        'required',
                        'email',
                        'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                        'unique:users,email',
                        Rule::unique('users')->whereNull('deleted_at'),
                    ],
                    'role_id' => 'required',
                    'department_id' => 'required',
                    'designation_id' => 'required',
                    'gender' => 'required',
                    'country' => 'required',
                    'shift_id' => 'required',
                    'basic_salary' => 'required',
                    'joining_date' => 'required',

                ];
            }
            case 'PATCH':
            {
                return [
                    'name' => 'required|max:255',
                    'phone' => [
                        'required',
                        'numeric',
                        $digits_between,
                        'unique:users,phone,' . $this->id,
                        Rule::unique('users')->whereNull('deleted_at'),
                    ],
                    'email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|max:255|unique:users,email,' . $this->id,
                    'role_id' => 'required',
                    'department_id' => 'required',
                    'designation_id' => 'required',
                ];
            }
            default:
                break;
        }
    }
}
