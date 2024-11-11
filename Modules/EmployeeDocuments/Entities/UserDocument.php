<?php

namespace Modules\EmployeeDocuments\Entities;

use App\Models\Traits\BranchTrait;
use App\Models\Traits\CompanyTrait;
use App\Models\User;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDocument extends Model
{
    use HasFactory, CompanyTrait, BranchTrait;
    protected $table = 'user_documents';
    protected $fillable = [
        'document_title',
        'user_id', 'document_type', 'document_number', 'document_expiration',
        'document_request_description', 'document_request_approved',
        'document_request_date', 'document_notification_date','attachment_id','user_document_type_id','branch_id'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
    public function image()
    {
        return $this->belongsTo(Upload::class, 'attachment', 'id');
    }
}
