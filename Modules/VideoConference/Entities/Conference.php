<?php

namespace Modules\VideoConference\Entities;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Traits\BranchTrait;
use App\Models\Traits\CompanyTrait;
use App\Models\coreApp\Status\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\VideoConference\Entities\ConferenceMember;

class Conference extends Model
{
    use HasFactory, CompanyTrait, BranchTrait;

    protected $fillable = [];
    
   public function creator(){
        return $this->belongsTo(User::class,'created_by');
   }
   public function members(){
        return $this->hasMany(ConferenceMember::class,'conference_id');
   }
   public function host(){
    return $this->hasOne(ConferenceMember::class,'conference_id')->where('is_host',1);
   }
   public function status()
    {
        return $this->belongsTo(Status::class);
    }

   public function generateUniqueCode()
   {
    do {
           $code = Uuid::uuid4()->toString();
        //    $code = random_int(100000, 999999);
       } while (Conference::where("room_id", "=", $code)->first());
 
       return $code;
   }
   public function getJoinAttribute(){
        $current_time = date('Y-m-d H:i:s');
        $start_time =$this->start_at;
        $end_time =$this->end_at;
        $current_time = strtotime($current_time);
        $start_time = strtotime($start_time);
        $end_time = strtotime($end_time);
        $link="https://meet.jit.si/".$this->room_id;
        if ($current_time > $start_time && $current_time < $end_time) {
            return [
                'link'=>$link,
                'button'=>'Join'
            ];
        }elseif ($current_time < $start_time) {
            return [
                'link'=>$link,
                'button'=>'Upcoming'
            ];
        }elseif ($current_time > $end_time) {
            return [
                'link'=>$link,
                'button'=>'Ended'
            ];
        }
   }

     protected static function boot()
     {
           parent::boot();
           static::creating(function ($model) {
            $model->room_id = $model->generateUniqueCode();
           });
     }
}
