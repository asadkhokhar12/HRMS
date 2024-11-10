<?php

namespace App\Models;

use App\Models\User;
use App\Models\coreApp\Status\Status;
use Illuminate\Database\Eloquent\Model;
use Modules\EmployeeDocuments\Entities\UserDocument;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDocumentRequest extends Model
{
    use HasFactory;

    protected $table = "user_document_requests";

    public function userDocuments()
    {
        return $this->hasMany(UserDocument::class);
    }

    protected $fillable = [
        'user_id', 'request_type', 'request_description', 'approved', 'request_date',
    ];

    public function user(): BelongsTo // Typo: Missing "o" in BelongsTo
    {
        return $this->belongsTo(User::class); // Assuming 'user_id' is the default foreign key
    }


    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
