<?php

namespace App\Models\Settings;

use App\Models\Traits\BranchTrait;
use App\Models\Traits\CompanyTrait;
use App\Models\coreApp\Status\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocationBind extends Model
{
    use HasFactory,BranchTrait,CompanyTrait;

    
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
