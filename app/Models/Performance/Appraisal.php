<?php

namespace App\Models\Performance;

use App\Models\User;
use App\Models\Traits\BranchTrait;
use App\Models\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appraisal extends Model
{
    use HasFactory,BranchTrait,CompanyTrait;

    protected $casts = [
        'rates'   => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function added(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }
}
