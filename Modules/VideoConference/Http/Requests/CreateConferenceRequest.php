<?php

namespace Modules\VideoConference\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateConferenceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'content' => 'required|max:1000',
            'date' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'user_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => _trans('validation.Title is required'),
            'title.max' => _trans('validation.Title may not be greater than 255 characters'),
            'content.required' => _trans('validation.Content is required'),
            'content.max' => _trans('validation.Content may not be greater than 1000 characters'),
            'date.required' => _trans('validation.Date is required'),
            'start_at.required' => _trans('validation.Start Date is required'),
            'end_at.required' => _trans('validation.End Date is required'),
            'user_id.required' => _trans('validation.Employee is required'),
        ];
    }
}
