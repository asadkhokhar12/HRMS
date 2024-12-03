<?php

namespace App\Repositories\Settings;

use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Http\Resources\Hrm\UserCollection;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Hrm\Department\Department;
use App\Models\Hrm\Designation\Designation;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProfileUpdateSettingRepository
{
    use ApiReturnFormatTrait, RelationshipTrait;

    protected User $user;
    protected Department $department;
    protected Designation $designation;

    public function __construct(User $user, Department $department, Designation $designation)
    {
        $this->user = $user;
        $this->department = $department;
        $this->designation = $designation;
    }


    public function getDesignationUser($request)
    {
        // $designation_id= $request->get('designation_id');
        // $designation = $this->designation->query()->where('id', $designation_id)->first();
        $users = $this->user->query()->where('company_id', 1);
        $users->when(\request()->get('designation_id'),function(Builder $builder){
                return $builder->where('designation_id',\request()->get('designation_id'));
        });
        $users->when(\request()->get('department_id'),function(Builder $builder){
            return $builder->where('department_id',\request()->get('department_id'));
         });
         $users->select('id', 'name', 'phone', 'designation_id', 'avatar_id');

        $data = $users->when(\request('keywords'), function (Builder $builder) {
            $keywords = \request('keywords');
            return $builder->where('name', 'LIKE', "%$keywords%");
        });
        $array = $users->paginate(10);
        $data = new UserCollection($array);

        return $this->responseWithSuccess("Users", $data, 200);
    }

    public function getUserInfo($request){
        $user = $this->user->query()->where(['id' => $request['id'] , 'company_id' => 1]);
        $user->select('id', 'name', 'phone', 'designation_id', 'avatar_id');
        $array = $user->paginate(10);
        $data = new UserCollection($array);
        return $this->responseWithSuccess("User", $data, 200);
    }

    public function getDepartmentUser($request)
    {
        $department_id = $request->get('department_id');
        $designation = $this->designation->query()->where('id', $department_id)->first();
        $users = $this->user->query()->where('company_id', 1);
        $users->when(\request()->get('department_id'), function (Builder $builder) {
            return $builder->where('department_id', \request()->get('department_id'));
        });
        $users->when(\request()->get('department_id'), function (Builder $builder) {
            return $builder->where('department_id', \request()->get('department_id'));
        });
        $users->select('id', 'name', 'phone', 'designation_id', 'avatar_id');

        $data = $users->when(\request('keywords'), function (Builder $builder) {
            $keywords = \request('keywords');
            return $builder->where('name', 'LIKE', "%$keywords%");
        });
        $array = $users->paginate(10);
        $data = new UserCollection($array);

        return $this->responseWithSuccess("Users", $data, 200);
    }
    
    public function getSearchUser($request)
    {
        $users = $this->user->query()->where('company_id', 1);
        $users->select('id', 'name', 'phone', 'designation_id', 'avatar_id');

        $data = $users->when(\request('search'), function (Builder $builder) {
            $keywords = \request('search');
            return $builder->where('name', 'LIKE', "%$keywords%");
        });
        $array = $users->paginate(10);
        $data = new UserCollection($array);

        return $this->responseWithSuccess("Users", $data, 200);
    }
    public function getAllUserInfo($request)
    {
        $users = $this->user->query()->where('company_id', 1);
        $users->select('id', 'name', 'phone', 'designation_id', 'avatar_id');
        $array = $users->paginate(10);
        $data = new UserCollection($array);

        return $this->responseWithSuccess("Users", $data, 200);
    }
    public function getAllDepartment(): \Illuminate\Http\JsonResponse
    {
        $data['departments'] = $this->department->query()->select('id', 'title')->where(['company_id' => $this->companyInformation()->id, 'status_id' => 1])->get();
        return $this->responseWithSuccess('All Department', $data, 200);
    }

    public function getAllDesignation(): \Illuminate\Http\JsonResponse
    {
        $data['designations'] = $this->designation->query()->select('id', 'title')->where('status_id', 1)->get();
        return $this->responseWithSuccess('All Designation', $data, 200);
    }

    public function getEmploymentType(): \Illuminate\Http\JsonResponse
    {
        $data['types'] = config('hrm.employee_type');
        return $this->responseWithSuccess('All employment type', $data, 200);
    }

    public function getBloodGroups(): \Illuminate\Http\JsonResponse
    {
        $data['blood_group'] = config('hrm.blood_group');
        return $this->responseWithSuccess('All employment type', $data, 200);
    }

    public function getDepartmentWiseUsers($request)
    {
        $designation = $this->designation->query()->where('id', $designation_id)->first();
        $users = $this->user->query()->where('company_id', 1);
        $users->when(\request()->get('designation_id'),function(Builder $builder){
                return $builder->where('designation_id',\request()->get('designation_id'));
        });
        $users->when(\request()->get('department_id'),function(Builder $builder){
            return $builder->where('department_id',\request()->get('department_id'));
         });
         $users->select('id', 'name', 'phone', 'designation_id', 'avatar_id');

        $data = $users->when(\request('keywords'), function (Builder $builder) {
            $keywords = \request('keywords');
            return $builder->where('name', 'LIKE', "%$keywords%");
        });
        $array = $users->take(20)->get();
        $data = new UserCollection($array);

        return $this->responseWithSuccess("Users", $data, 200);
    }
}
