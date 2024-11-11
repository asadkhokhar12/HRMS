<?php

namespace App\Models\Hrm\Leave;

use App\Models\Traits\BranchTrait;
use App\Models\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveSetting extends Model
{
    use CompanyTrait,BranchTrait;

    protected $fillable = ['company_id', 'sandwich_leave', 'month', 'prorate_leave'];
}
