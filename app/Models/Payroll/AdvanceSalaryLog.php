<?php

namespace App\Models\Payroll;

use App\Models\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvanceSalaryLog extends Model
{
    use HasFactory,BranchTrait;
}
