<?php

namespace App\Models;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public function create(array $attributes = [])
    {
        if (config('app.style') === 'demo') {
            // Prevent storing the model
            Toastr::error(_trans('response.You are not allowed for demo!'), 'Error');
            return response()->json([
                'result' => false,
                'message' => 'You are not allowed for demo',
                'error' => 'failed',
            ], 401);
        }

        return parent::create($attributes);
    }

    public function update(array $attributes = [], array $options = [])
    {
        if (config('app.style') === 'demo') {

            Toastr::error(_trans('response.You are not allowed for demo!'), 'Error');
            return response()->json([
                'result' => false,
                'message' => 'You are not allowed for demo',
                'error' => 'failed',
            ], 401);
        }

        return parent::update($attributes, $options);
    }

    public function delete()
    {
        if (config('app.style') === 'demo') {

            Toastr::error(_trans('response.You are not allowed for demo!'), 'Error');
            return response()->json([
                'result' => false,
                'message' => 'You are not allowed for demo',
                'error' => 'failed',
            ], 401);
        }

        return parent::delete();
    }
}
