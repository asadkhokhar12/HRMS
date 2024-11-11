<?php

namespace App\Models\Hrm\Support;

use App\Models\User;
use App\Models\Traits\BranchTrait;
use App\Models\Traits\CompanyTrait;
use App\Models\coreApp\Status\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\UserRelationTrait;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;

class SupportTicket extends Model
{
    use HasFactory, StatusRelationTrait, CompanyTrait,UserRelationTrait,BranchTrait;

    protected $fillable = [
        'assigned_id',
        'code',
        'user_id',
        'company_id',
        'attachment_file_id',
        'type_id',
        'subject',
        'date',
        'description',
        'priority_id',
        'status_id',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'type_id', 'id');
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'priority_id', 'id');
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(TicketReply::class, 'support_ticket_id', 'id')->orderBy('id','ASC');
    }
}
