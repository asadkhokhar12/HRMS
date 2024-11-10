<?php

namespace App\Http\Requests\Hrm\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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

        switch ($this->slug) {
            case 'official':
                return [
                    'name' => 'required|max:50',
                    'email' => 'required|email|max:100|unique:users,email,' . $this->user_id,
                    'joining_date' => 'sometimes|date',
                    'employee_type' => 'sometimes|max:30',
                    'employee_id' => 'sometimes|numeric',
                    'manager_id' => 'sometimes|numeric',
                    'department_id' => 'sometimes|numeric',
                    'designation_id' => 'sometimes|numeric',
                    'grade' => 'sometimes|max:30',
                ];
            case 'personal':
            {
                return [
                    'gender' => 'required',
                    'phone' => [
                        'required',
                        'numeric',
                        $digits_between,
                        'unique:users,phone,' . $this->user_id,
                    ],
                    'birth_date' => 'sometimes|date',
                    'address' => 'sometimes|max:190',
                    'nationality' => 'sometimes|max:30',
                    'avatar' => 'sometimes|image',
                    'blood_group' => 'required',
                    'passport_number'       => Rule::requiredIf(settings('is_employee_passport_required') ? true : false),
                    'passport_file_id'      => Rule::requiredIf(settings('is_employee_passport_required') ? true : false),
                    'passport_expire_date'  => Rule::requiredIf(settings('is_employee_passport_required') ? true : false),
                    'eid_number'            => Rule::requiredIf(settings('is_employee_eid_required') ? true : false),
                    'eid_file_id'           => Rule::requiredIf(settings('is_employee_eid_required') ? true : false),
                    'eid_expire_date'       => Rule::requiredIf(settings('is_employee_eid_required') ? true : false),
                ];
            }
            case 'financial':
            {
                return [
                    'tin' => 'sometimes|max:50',
                    'bank_name' => 'sometimes|max:50',
                    'bank_account' => 'sometimes|max:30'
                ];
            }
            case 'emergency':
            {
                return [
                    'emergency_name' => 'sometimes|max:50',
                    'emergency_mobile_number' => 'required|numeric',
                    'emergency_mobile_relationship' => 'sometimes|max:30'
                ];
            }
            case 'salary':
            {
                return [
                    'basic_salary' => 'sometimes|max:11',
                ];
            }
            case 'contract':
            {
                return [
                    'basic_salary' => 'sometimes|max:11',
                    'contract_start_date' => 'sometimes|date',
                    'contract_end_date' => 'sometimes|date',
                    'salary_type' => 'sometimes|max:30',
                ];
            }
            case 'security':
            {
                return [
                    'old_password' => 'required',
                    'password' => 'required|confirmed|min:6',
                ];
            }
            case 'company':
            {
                return [
                    'company_name' => 'required',
                    'email' => 'required',
                    'phone' => 'required',
                    'total_employee' => 'required',
                    'business_type' => 'sometimes|max:50',
                    'trade_licence_number' => 'sometimes|max:50',
                ];
            }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'phone.numeric' => 'Phone number should be a numeric number.',
            'gender.required' => 'Gender is required.',
            'blood_group.required' => 'Blood group is required.',
            
        ];
    }
}
