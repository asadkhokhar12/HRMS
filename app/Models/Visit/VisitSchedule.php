<?php

namespace App\Models\Visit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitSchedule extends Model
{
    use HasFactory;
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }
}
