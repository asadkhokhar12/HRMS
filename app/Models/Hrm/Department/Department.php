<?php

namespace App\Models\Hrm\Department;

use App\Models\User;
use App\Models\Traits\BranchTrait;
use Spatie\Activitylog\LogOptions;
use App\Models\Traits\CompanyTrait;
use App\Models\Hrm\Leave\AssignLeave;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hrm\Attendance\DutySchedule;
use App\Models\Hrm\Notice\NoticeDepartment;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;

class Department extends Model
{
    use HasFactory, StatusRelationTrait, LogsActivity, SoftDeletes,CompanyTrait,BranchTrait;

    // protected $fillable = [
    //     'company_id', 'id', 'title', 'status_id'
    // ];

    protected $guarded = [];

    protected static $logAttributes = [
        'company_id', 'id', 'title', 'status_id'
    ];

    public function assignLeaves(): HasMany
    {
        return $this->hasMany(AssignLeave::class, 'department_id', 'id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'department_id', 'id')->where('status_id', 1);
    }



    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
