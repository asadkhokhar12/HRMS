<?php

namespace App\Models\Hrm\Leave;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\UserRelationTrait;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;

class DailyLeave extends Model
{
    use HasFactory, StatusRelationTrait, UserRelationTrait;


    // user  
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // approved_by_tl  
    public function tlApprovedBy()
    {
        return $this->belongsTo(User::class, 'approved_by_tl', 'id');
    }
    // approved_by_hr   
    public function hrApprovedBy()
    {
        return $this->belongsTo(User::class, 'approved_by_hr', 'id');
    }
}
