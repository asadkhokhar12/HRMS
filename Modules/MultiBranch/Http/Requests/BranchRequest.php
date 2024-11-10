<?php

namespace Modules\MultiBranch\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST' || 'PATCH':
            {
                return [
                    'name' => 'required|max:255',
                    'email' => 'required|email',
                    'phone' => 'required',
                    'address' => 'required',
                    'status' => 'required'
                ];
            }
            default:
                break;
        }
    }
    public function messages()
    {
        return [
            'name.required' => _trans('validation.Name is required'),
            'name.max'      => _trans('validation.Name is not more than 255 characters'),
            'email.required'=>_trans('validation.Email is required'),
            'phone.required'=>_trans('validation.Phone is required'),
            'address.required'=>_trans('validation.Address is required'),
            'status.required' => _trans('validation.Status is required'),
        ];
    }
}
