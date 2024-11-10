<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpireNotification extends Model
{
    use HasFactory;

    protected $fillable = ['receiver_id','employee_id','branch_id','company_id','title','description','is_read'];
    public function user(){
        return $this->belongsTo(User::class, 'employee_id','id')->withDefault();
    }
    
}
