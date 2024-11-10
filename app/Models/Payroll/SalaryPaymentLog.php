<?php

namespace App\Models\Payroll;

use App\Models\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryPaymentLog extends Model
{
    use HasFactory,BranchTrait;
}
