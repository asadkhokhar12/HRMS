<?php

namespace App\Models\Performance;

use App\Models\Traits\BranchTrait;
use App\Models\Traits\CompanyTrait;
use App\Models\Performance\GoalType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goal extends Model
{
    use HasFactory,BranchTrait,CompanyTrait;

    public function goalType()
    {
        return $this->belongsTo(GoalType::class);
    }
}
