<?php

namespace App\Models\coreApp\Payment;

use App\Models\coreApp\BaseModel;
use Spatie\Activitylog\LogOptions;
use App\Models\coreApp\Status\Status;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\coreApp\Traits\Translate\TranslatedNameTrait;

class PaymentSetting extends BaseModel
{
    use LogsActivity;

    protected $fillable = ['payment_method_name', 'api_key', 'secret_key', 'status_id'];

    protected static $logAttributes = ['payment_method_name', 'secret_key'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
