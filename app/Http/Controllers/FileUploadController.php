<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;

class FileUploadController extends Controller
{
    use FileHandler, ApiReturnFormatTrait;

    public function fileUpload(Request $request){

        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|file',
            ]
        );

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
        }

        try {
            $filePath = '';
            if ($request->hasFile('file')) {
                $filePath = $this->uploadImage($request->file, 'uploads/files');
            }
            $data=[
                'file_id'=>$filePath->id,
                'preview_url'=>uploaded_asset($filePath->id),
            ];
            return $this->responseWithSuccess('File Uploaded', $data, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 500);
        }
    }
}
