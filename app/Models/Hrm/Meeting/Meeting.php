<?php

namespace App\Models\Hrm\Meeting;

use App\Models\User;
use App\Models\Traits\BranchTrait;
use App\Models\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    use HasFactory, CompanyTrait, StatusRelationTrait,BranchTrait;

    protected $fillable = [
        'company_id',
        'user_id',
        'user_id',
        'description',
        'location',
        'date',
        'duration',
        'start_at',
        'end_at',
        'attachment_file_id',
        'status_id'
    ];

    public function meetingParticipants(): HasMany
    {
        return $this->hasMany(MeetingParticipant::class, 'meeting_id', 'id')->with('user');
    }

    public function meetingHost(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
