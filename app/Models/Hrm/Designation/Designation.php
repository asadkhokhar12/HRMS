<?php

namespace App\Models\Hrm\Designation;

use App\Models\Traits\BranchTrait;
use Spatie\Activitylog\LogOptions;
use App\Models\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;

class Designation extends Model
{
    use HasFactory, StatusRelationTrait, LogsActivity,CompanyTrait, SoftDeletes,BranchTrait;

    protected $fillable = [
        'id', 'company_id','title', 'status_id'
    ];

    protected static $logAttributes = [
       'company_id', 'id','title', 'status_id'
    ];




    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

}
