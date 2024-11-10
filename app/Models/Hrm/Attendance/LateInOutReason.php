<?php

namespace App\Models\Hrm\Attendance;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LateInOutReason extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['company_id', 'attendance_id', 'type', 'reason'];

    protected static $logAttributes = ['company_id', 'attendance_id', 'type', 'reason'];

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }



    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
