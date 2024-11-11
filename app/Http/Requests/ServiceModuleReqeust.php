<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceModuleReqeust extends FormRequest
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

                    'installation_date' => 'required',

                ];
            }
            default:
                break;
        }
    }

    public function messages()
    {
        return [

            'installation_date.required' => _trans('validation.Installation Date is required'),

        ];
    }
}
