<?php

namespace App\Http\Resources\Hrm;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;

class AttendanceCheckoutApiCollection extends JsonResource {
    use TimeDurationTrait;
    public function toArray($request) {
                return [
                    'id' => $this->id,
                    'company_id' => $this->company_id,
                    'user_id' => $this->user_id,
                    'date' => $this->date,
                    'check_in' => $this->check_in,
                    'check_out' => $this->check_out,
                    'stay_time' => $this->calculateStayTime($this->check_in, $this->check_out),
                    'late_reason' => $this->late_reason,
                    'late_time' => $this->late_time,
                    'in_status' => $this->in_status,
                    'out_status' => $this->out_status,
                    'checkin_ip' => $this->checkin_ip,
                    'checkout_ip' => $this->checkout_ip,
                    'latitude' => $this->check_out_latitude,
                    'longitude' => $this->check_out_longitude,
                    'updated_at' => $this->updated_at,
                    'created_at' => $this->created_at,
                    'in_time' => $this->dateTimeInAmPm($this->check_in),
                    'out_time' => $this->dateTimeInAmPm($this->check_out),

                  
                ];
                
    }
    private function calculateStayTime($checkIn, $checkOut)
{
    $checkInTime = new DateTime($checkIn);
    $checkOutTime = new DateTime($checkOut);

    $diff = $checkOutTime->diff($checkInTime);

    return $diff->format('%H:%I:%S');
}
}
