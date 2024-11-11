<?php

namespace App\Models\Management;

use App\Models\Visit\VisitImage;
use App\Models\Traits\BranchTrait;
use App\Models\Hrm\Country\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;

class Client extends Model
{
    use HasFactory,StatusRelationTrait, SoftDeletes,BranchTrait;

    public function avater()
    {
        return $this->morphOne(VisitImage::class, 'imageable');
    }

    //country relation
    public function countryInfo()
    {
        return $this->belongsTo(Country::class,'country');
    } 
}
