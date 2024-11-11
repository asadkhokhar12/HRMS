<?php

namespace App\Http\Controllers\Api\Core\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Models\Hrm\Designation\Designation;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Settings\ProfileUpdateSettingRepository;

class ProfileUpdateSettingController extends Controller
{
    use ApiReturnFormatTrait;

    protected ProfileUpdateSettingRepository $profileSetting;
    protected UserRepository $user;

    public function __construct(ProfileUpdateSettingRepository $profileSetting, UserRepository $user)
    {
        $this->profileSetting = $profileSetting;
        $this->user = $user;
    }

    public function getDesignationWiseUsers(Request $request,$designation_id=null)
    {
        try {
            $request['designation_id'] = $designation_id;
            return $this->profileSetting->getDesignationUser($request);
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }
    public function getAllUser(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $designation_id = $request->input('designation_id');
            $department_id = $request->input('department_id');
            $search = $request->input('search');

            $query = DB::table('users')->where('company_id', auth()->user()->company_id);
            $query->select('id', 'name', 'phone', 'designation_id', 'avatar_id');

            if ($designation_id) {
                return $this->profileSetting->getDesignationUser($request);
            }

            if ($department_id) {
                return $this->profileSetting->getDepartmentUser($request);
            }

            if ($search) {
                return $this->profileSetting->getSearchUser($request);
            }

            $users = $query->paginate($perPage);

            return $this->profileSetting->getAllUserInfo($users); 

        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function getUserData($id){
        try {
            $request['id'] = $id;
            return $this->profileSetting->getUserInfo($request);
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function getDepartment(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->profileSetting->getAllDepartment();
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function getDesignation(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->profileSetting->getAllDesignation();
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function getEmployment(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->profileSetting->getEmploymentType();
        } catch (\Exception $exception) {
            dd($exception);
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function getBloodGroup(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->profileSetting->getBloodGroups();
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    //get All Users
    public function getUsers(Request $request)
    {
        return $this->user->getUserByKeywords($request);
    }


}
