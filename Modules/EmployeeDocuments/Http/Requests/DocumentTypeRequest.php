<?php

namespace Modules\EmployeeDocuments\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentTypeRequest extends FormRequest
{
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
            case 'POST':
                {
                    return [
                        'name' => 'required|max:255|unique:user_document_types,name',
                    ];
                }
            case 'PATCH':
                {
                    return [
                        'name' => 'required|max:255|unique:user_document_types,name,' . $this->id,
                    ];
                }
            default:
                break;
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => _trans('validation.Document type is required'),
            'name.max' => _trans('validation.Document type not greater than 255'),
            'name.unique' => _trans('validation.Document type is already in use'),

        ];
    }
}
