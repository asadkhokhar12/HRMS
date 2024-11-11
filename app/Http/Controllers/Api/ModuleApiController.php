<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;

class ModuleApiController extends Controller
{
    use ApiReturnFormatTrait;

    public function modules(Request $request)
    {
        try {

            $modules = [
                'MultiBranch',
                'FaceAttendance',
                'SingleDeviceLogin',
                'VideoConference',
                'Services',
                'Saas',
                'EmployeeDocuments',
                'MenuPermission',
                'LiveTracking',
                'MultiTheme',
                'AreaBasedAttendance',
                'IpBasedAttendance',
                'QrBasedAttendance',
                'SelfieBasedAttendance',
            ];

            return $this->responseWithSuccess(_trans('response.Success'), $modules);
        } catch (\Throwable $th) {
            return $this->responseWithError(_trans('response.Something went wrong!'));
        }
    }

    public function checkModuleStatus($module)
    {
        try {
            $filePath = base_path('modules_statuses.json');

            if (!file_exists($filePath)) {
                throw new \Exception("File not found: {$filePath}");
            }

            $isActive = json_decode(file_get_contents($filePath), true)[$module] ?? null;

            if ($isActive !== null) {
                return $this->responseWithSuccess(_trans('response.Success'), $isActive);
            } else {
                throw new \Exception("Module '{$module}' not found in {$filePath}");
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(_trans('response.Something went wrong!'), $th->getMessage());
        }
    }
}
