<?php

namespace App\Models\Hrm\Leave;

use App\Models\User;
use App\Models\Traits\BranchTrait;
use Spatie\Activitylog\LogOptions;
use App\Models\Traits\CompanyTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hrm\Department\Department;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;

class AssignLeave extends Model
{
    use HasFactory, StatusRelationTrait, LogsActivity, SoftDeletes,CompanyTrait,BranchTrait;

    protected $fillable = [
        'company_id', 'department_id', 'days', 'type_id', 'status_id'
    ];

    protected static $logAttributes = [
        'company_id', 'department_id', 'days', 'type_id', 'status_id'
    ];


    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class, 'type_id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
