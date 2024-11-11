<?php

namespace App\Models;

use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;

class Subscription extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $guarded = [];
    protected $table = "tenant_subscriptions";

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function scopeActive($query)
    {
        $query->where('status_id', 1);
    }
}
