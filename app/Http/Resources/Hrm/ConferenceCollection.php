<?php

namespace App\Http\Resources\Hrm;

use Carbon\Carbon;
use App\Models\Visit\Visit;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ConferenceCollection extends ResourceCollection
{
    use DateHandler,TimeDurationTrait;

    public function toArray($request)
    {
        return [
            'items' => $this->collection->map(function ($conference){
                $members = [];
                $members = $conference->members->map(function ($member) {
                    return [
                        'name' => $member->user->name,
                        'is_agree' => $member->is_agree==1 ? 'Agree' : 'Disagree',
                        'is_present' => $member->is_present==1 ? 'Present' : 'Absent',
                        'present_at' => $member->present_at,
                        'started_at' => $member->conference_started_at,
                        'ended_at' => $member->conference_ended_at,

                    ];
                });
				

                if(!empty($members) && count($members) > 0){
                    return [
                        'id' => $conference->id,
                        'title' => $conference->name,
                        'description' => $conference->description,
                        'date' => Carbon::parse($conference->start_at)->format('F j'),
                        'day' => Carbon::parse($conference->date)->format('l'),
                        'time' => $this->dateTimeInAmPm($conference->start_at),
                        'start_at' => $this->timeFormatInPlainText($conference->start_at),
                        'end_at' => $this->timeFormatInPlainText($conference->end_at),
                        'members' => $members,
                    ];
                } else{
                    return [];
                } 
            })->reject(function ($item) {
                return empty($item['members']);
            })->values(),
        ];
    }
}
