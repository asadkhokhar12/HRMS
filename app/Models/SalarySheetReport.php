<?php

namespace App\Models;

use App\Models\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySheetReport extends Model
{
    use HasFactory,CompanyTrait;
}
