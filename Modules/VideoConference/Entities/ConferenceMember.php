<?php

namespace Modules\VideoConference\Entities;

use App\Models\Traits\BranchTrait;
use App\Models\Traits\CompanyTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\VideoConference\Entities\Conference;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConferenceMember extends Model
{
    use HasFactory, BranchTrait, CompanyTrait;

    protected $fillable = [];
    
    public function conference(){
          return $this->belongsTo(Conference::class,'conference_id');
    }

    public function user(){
          return $this->belongsTo(User::class,'user_id');
    }
}
