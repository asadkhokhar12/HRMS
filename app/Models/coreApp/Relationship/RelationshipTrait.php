<?php

namespace App\Models\coreApp\Relationship;

use App\Models\Hrm\Leave\LeaveYear;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait RelationshipTrait
{
    public function companyInformation(): object
    {
        return auth()->user()->company;
    }

    public function isExistsWhenStore($model, $columnName, $value): bool
    {
        $tableName  = $model->getTable();
        $query      = $model->where('company_id', getCurrentCompany());

        if (Schema::hasColumn($tableName, 'branch_id')) {
            $query->where('branch_id', getCurrentBranch());
        }

        $data = $query->where($columnName, $value)->first();
                
        return !$data ? true : false;
    }


    public function isExistsWhenUpdate($existingModel, $model, $columnName, $value): bool
    {
        $data = $model->query()->where([
            'company_id' => getCUrrentCompany(),
            'branch_id'=>userBranch(),
            $columnName => $value
        ])->first();
        if ($data) {
            if ($existingModel->id == $data->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function isExistsWhenUpdateMultipleColumn($model, $id, $column1, $column2, $value1, $value2): bool
    {
        $data = $model->query()->where([
            'company_id' => getCUrrentCompany(),
            'branch_id'=>userBranch(),
            $column1 => $value1,
            $column2 => $value2
        ])->first();
        if ($data) {
            if ($id == $data->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }


    public function isExistsWhenStoreMultipleColumn($model, $column1, $column2, $value1, $value2): bool
    {
        $data = $model->query()->where(['company_id' => getCUrrentCompany(), $column1 => $value1, $column2 => $value2])->first();

        if (!$data) {
            return true;
        }

        if(settings('leave_carryover')){
            $leave_year = LeaveYear::where(['type_id' => $data->type_id, $column1 => $value1, 'year' => now()->format('Y')])->first();
            if (!$leave_year) {
                $data->delete();
                return true;
            } else {
                return false;
            }
        } else{
            return false;
        }
       
        
        // if (!$data) {
        //     return true;
        // } else {
        //     return false;
        // }
    }
}