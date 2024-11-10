<?php

namespace App\Models\Accounts;

use App\Models\Traits\BranchTrait;
use App\Models\coreApp\Status\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;

class Category extends Model
{
    use HasFactory, SoftDeletes,StatusRelationTrait,BranchTrait;

      // status query belongsTo relationship with status table
      public function status(): BelongsTo
      {
          return $this->belongsTo(Status::class);
      }
}
