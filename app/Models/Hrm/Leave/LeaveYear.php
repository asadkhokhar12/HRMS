<?php

namespace App\Models\Hrm\Leave;

use App\Models\User;
use App\Models\Hrm\Leave\LeaveType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hrm\Department\Department;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'department_id', 'leave_days', 'leave_available', 'leave_used', 'year', 'type_id', 'user_id', 'status_id'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class, 'type_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
