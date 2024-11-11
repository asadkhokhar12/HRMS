<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicePackageReqeust extends FormRequest
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
                    'name' => 'required',
                    'status' => 'required',
                    'quantity' => 'required',
                    'contract_date' => 'required',
                    'expiration_date' => 'required',
                    'warranty_period' => 'required',
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
            'status.required' => _trans('validation.Status is required'),
            'quantity.required' => _trans('validation.Quantity is required'),
            'contract_date.required' => _trans('validation.Contract Date is required'),
            'expiration_date.required' => _trans('validation.expiration Date is required'),
            'warranty_period.required' => _trans('validation.Warranty Period is required'),
        ];
    }
}
