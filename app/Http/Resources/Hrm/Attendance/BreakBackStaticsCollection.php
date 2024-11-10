<?php

namespace App\Http\Resources\Hrm\Attendance;

use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BreakBackStaticsCollection extends ResourceCollection
{
    use TimeDurationTrait;

    public function toArray($request)
    {
        return [
            'today_history' => $this->collection->map(function ($data) {
                return [
                    'name' => @$data->user->name,
                    'reason' => $data->reason,
                    'break_time_duration' => $this->hourOrMinute($data->break_time,$data->back_time),
                    'break_back_time' => $this->dateTimeInAmPm($data->break_time,).' To '.$this->dateTimeInAmPm($data->back_time),
                ];
            }),
           
        ];
    }
}