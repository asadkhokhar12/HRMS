<?php

namespace App\Helpers\CoreApp\Traits;

use App\Models\Upload;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait FileHandler
{
    protected $path_prefix = 'allUploads';

    /**
     * @param UploadedFile $file
     * @param string $folder
     * @return
     */
    public function storeFile(UploadedFile $file, $folder = 'avatar')
    {
        $name = Str::random(40) . "." . $file->getClientOriginalExtension();
        $file->storeAs("{$this->path_prefix}/{$folder}", $name);
        return Storage::url($folder . '/' . $name);
    }

    public function createDirecrotory($path)
    {
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }

    public function saveImage(UploadedFile $file, $subdirectory = 'logo', $height = 300)
    {
        try {
            $path = $this->path_prefix . '/' . $subdirectory;
            if (env('FILESYSTEM_DRIVER') == 'server') {
                $file_path = Storage::disk('s3')->put($path, $file);
            } elseif (env('FILESYSTEM_DRIVER') == 's3') {
                $file_path = Storage::disk('s3')->put($path, $file);
            } elseif (env('FILESYSTEM_DRIVER') == 'local') {
                $this->createDirecrotory($path);
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file_path = $file->move($path, $filename);
            } else {
                $file_path = Storage::put($path, $file);
            }
            return (object) ["success" => true, "message" => "File has been uploaded successfully", "path" => $file_path];
        } catch (Exception $exception) {
            $file_name = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs($this->path_prefix . '/' . $subdirectory, $file_name);

            return (object) ["success" => true, "message" => "File has been uploaded successfully", "path" => $subdirectory . '/' . $file_name];
        }
    }
    public function makeImage(UploadedFile $file, $height = 300)
    {
        return Image::make($file)->resize(null, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save();
    }

    public function uploadImage(UploadedFile $uploadedFile = null, $folder = "images", $height = null)
    {
        if (is_null($uploadedFile)) {
            return null;
        }

        $file = $this->saveImage($uploadedFile, $folder, $height);
        // get file type
        $file_type = $uploadedFile->getClientOriginalExtension();
        // get file extension
        $file_extension = $uploadedFile->getClientOriginalExtension();

        if ($file->success)
        //image save to upload folder this method will not be modified without any discussion
        {
            $saveImage = new Upload;
        }

        $saveImage->user_id = auth()->id();
        $saveImage->img_path = $file->path;
        $saveImage->type = $file_type;
        $saveImage->extension = '.' . $file_extension;
        $saveImage->save();
        return $saveImage;
    }

    public function isFile(string $path = null)
    {
        if (env('FILESYSTEM_DRIVER') == 'server') {
            return Storage::disk('s3')->exists($path);
        } elseif (env('FILESYSTEM_DRIVER') == 'local') {
            return Storage::delete($this->removeStorage($path));
        } else {
            return Storage::delete($this->removeStorage($path));
        }
    }

    public function deleteImage(string $path = null)
    {
        return $this->deleteFile($path);
    }

    public function removeStorage($path)
    {
        return str_replace('/storage', '', $path);
    }

    public function deleteFile(string $path = null)
    {
        $path = $this->removeStorage($path);
        if ($this->isFile($path)) {
            if (env('FILESYSTEM_DRIVER') == 'server') {
                return Storage::disk('s3')->delete($path);
            } elseif (env('FILESYSTEM_DRIVER') == 'local') {
                return Storage::delete($this->removeStorage($path));
            } else {
                return Storage::delete($this->removeStorage($path));
            }
        }

        return false;
    }

    public function deleteMultipleFile(array $paths)
    {
        foreach ($paths as $path) {
            $this->deleteFile($path);
        }

        return true;
    }

    public function filePath(string $path = null)
    {
        $path = $this->removeStorage($path);
        if ($this->isFile($path)) {
            return Storage::url("{$this->path_prefix}/{$path}");
        }

        return null;
    }
    // file download function
    public function downloadFile($upload_id = null, $name = 'download')
    {
        $path = "";
        if (($asset = Upload::find($upload_id)) != null) {
            $path = @$asset->img_path;
            $type = File::mimeType($path) ?? 'application/octet-stream';
            $name = 'task_'.time().'.png';
            $headers = [
                'Content-Type' => 'application/' . $type,
                'Content-Disposition' => 'attachment; filename="' . $name . '"',
            ];
            // dd($headers);
        }

        if ($path == "") {
            return Response::download('static/blank_small.png');
        } else {
            if (env('FILESYSTEM_DRIVER') == 's3') {
                return Response::make(Storage::disk('s3')->get($path), $name, $headers);
            } elseif (env('FILESYSTEM_DRIVER') == 'server') {
                return Response::make(Storage::disk('s3')->get($path), $name, $headers);
            } else {
                if (Storage::exists($path)) {
                    return Storage::download($path, $name, $headers);
                } else {
                    $URL = asset($path); 
                    return redirect( $URL );
                }
            }
        }
    }

    public function convertBase64ToImage($base64Image)
    {
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

        $tmpFilePath = storage_path('app/temp_image.jpg');

        if (!Storage::exists($tmpFilePath)) {
            Storage::makeDirectory($tmpFilePath);
        }

        file_put_contents($tmpFilePath, $imageData);

        return new UploadedFile($tmpFilePath, 'image.jpg', filesize($tmpFilePath), null, true);
    }
}
