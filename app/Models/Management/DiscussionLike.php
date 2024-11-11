<?php

namespace App\Models\Management;

use App\Models\User;
use App\Models\Management\Discussion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscussionLike extends Model
{
    use HasFactory;
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
