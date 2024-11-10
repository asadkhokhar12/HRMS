<?php

namespace App\Models\Content;

use App\Models\coreApp\Status\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'type',
        'title',
        'slug',
        'content',
        'meta_title',
        'keywords',
        'created_by',
        'updated_by',
        'status_id',
        'created_at',
        'updated_at',
        'branch_id',
        'meta_image',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
