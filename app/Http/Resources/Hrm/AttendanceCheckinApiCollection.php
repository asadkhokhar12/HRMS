<?php

namespace App\Http\Resources\Hrm;

use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceCheckinApiCollection extends JsonResource {
    use TimeDurationTrait;
    public function toArray($request) {
                return [
                    'id' => $this->id,
                    'company_id' => $this->company_id,
                    'user_id' => $this->user_id,
                    'date' => $this->date,
                    'check_in' => $this->check_in,
                    'in_status' => $this->in_status,
                    'checkin_ip' => $this->checkin_ip,
                    'late_time' => $this->late_time,
                    'latitude' => $this->check_in_latitude,
                    'longitude' => $this->check_in_longitude,
                    'updated_at' => $this->updated_at,
                    'created_at' => $this->created_at,
                    'in_time' => $this->dateTimeInAmPm($this->check_in),

                  
                ];
    }
}
