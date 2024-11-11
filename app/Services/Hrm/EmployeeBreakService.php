<?php

namespace App\Services\Hrm;

use Validator;
use Carbon\Carbon;
use App\Services\Core\BaseService;
use App\Models\Expenses\HrmExpense;
use App\Models\Hrm\Attendance\Attendance;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Models\Hrm\Attendance\EmployeeBreak;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Http\Resources\Hrm\Attendance\BreakBackCollection;
use App\Http\Resources\Hrm\Attendance\BreakBackStaticsCollection;

class EmployeeBreakService extends BaseService
{
    use RelationshipTrait, DateHandler, ApiReturnFormatTrait, TimeDurationTrait;

    protected $attendance;

    public function __construct(Attendance $attendance, EmployeeBreak $employeeBreak)
    {
        $this->attendance = $attendance;
        $this->model = $employeeBreak;
    }

    public function breakBackList()
    {
        $validator = Validator::make(\request()->all(), [
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }

        $breakList = $this->model->query()
            ->where('company_id', $this->companyInformation()->id)
            ->whereNotNull('back_time')
            ->when(\request()->get('date'), function (Builder $builder) {
                return $builder->where('date', \request()->get('date'));
            })->paginate(10);


        $totalBreakTime = 0;
        $totalBackTime = 0;
        $totalBreakTimeCount = 0;
        foreach ($breakList as $item) {
            $totalBreakTime += $this->timeToSeconds($item->break_time);
            $totalBackTime += $this->timeToSeconds($item->back_time);
        }
        $totalBreakTimeCount = $this->totalSpendTime($totalBreakTime, $totalBackTime);
        $data['total_break_time'] = $totalBreakTimeCount;
        $data['has_break'] = $breakList->count() > 0 ? true : false;
        $data['break_history'] = new BreakBackCollection($breakList);

        return $this->responseWithSuccess('Employees break history', $data, 200);
    }

    public function breakStartEnd($request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'time' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }
        try {
            if ($slug === 'start') {
                $attendance = $this->attendance->query()
                    ->where('user_id', auth()->user()->id)
                    ->where('date', date('Y-m-d'))
                    ->first();
                if ($attendance) {
                    //take Break
                    $takeBreak = $this->model->query()
                        ->where([
                            'company_id' => $this->companyInformation()->id,
                            'user_id' => auth()->id(),
                            'date' => date('Y-m-d'),
                        ])->whereNull('back_time')
                        ->orderByDesc('id')->first();
                    if ($takeBreak) {
                        $takeBreak->back_time = $request->time;
                        $takeBreak->save();
                        $takeBreak['status'] = "break_out";
                        return $this->responseWithSuccess('Your last break has been end', $takeBreak, 200);
                    } else {
                        $break = $this->model->create([
                            'company_id' => $this->companyInformation()->id,
                            'user_id' => auth()->id(),
                            'date' => date('Y-m-d'),
                            'break_time' => $request->time,
                            'back_time' => null,
                            'reason' => 'Break'
                        ]);
                        $break['status'] = "break_in";
                        return $this->responseWithSuccess('Break start successfully', $break, 200);
                    }
                } else {
                    $break = $this->model->create([
                        'company_id' => $this->companyInformation()->id,
                        'user_id' => auth()->id(),
                        'date' => date('Y-m-d'),
                        'break_time' => $request->time,
                        'back_time' => null,
                        'reason' => $request->reason ?? 'Break'
                    ]);

                    $break['status'] = "break_in";
                    return $this->responseWithSuccess('Break start successfully', $break, 200);
                }
            } else {
                //Check break started
                $takeBreak = $this->model->query()
                    ->where([
                        'company_id' => $this->companyInformation()->id,
                        'user_id' => auth()->id(),
                        'date' => date('Y-m-d'),
                    ])->whereNull('back_time')
                    ->orderByDesc('id')->first();
                if ($takeBreak) {
                    $takeBreak->back_time = $request->time;
                    $takeBreak->save();
                    $takeBreak['status'] = "break_out";
                    return $this->responseWithSuccess('Break End successfully', $takeBreak, 200);
                } else {
                    return $this->responseWithSuccess('Already break end', [], 200);
                }
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(_trans('response.Something went wrong.'), [], 400);
        }
    }

    public function breakBackEnd($request)
    {
        try {

            // $attendance = $this->attendance->query()
            //     ->where('user_id', auth()->user()->id)
            //     ->where('date', date('Y-m-d'))->whereNull('check_out')
            //     ->first();
            // if ($attendance) {

                //take Break
                $takeBreak = $this->model->query()
                    ->where([
                        'company_id' => $this->companyInformation()->id,
                        'user_id' => auth()->id(),
                        'date' => date('Y-m-d'),
                    ])->whereNull('back_time')
                    ->orderByDesc('id')->first();
                if ($takeBreak) {
                    $takeBreak->back_time = date('H:i');
                    $takeBreak->save();
                    $takeBreak['status'] = "break_out";
                    $takeBreak['histroy'] = $this->breakBackTodayHistoryStatics($request);
                    return $this->responseWithSuccess('Your last break has been end', $takeBreak, 200);
                } else {
                    $break = $this->model->create([
                        'company_id' => $this->companyInformation()->id,
                        'user_id' => auth()->id(),
                        'date' => date('Y-m-d'),
                        'break_time' => date('H:i'),
                        'back_time' => null,
                        'reason' => 'Break'
                    ]);
                    $break['status'] = "break_in";
                    return $this->responseWithSuccess('Break start successfully', $break, 200);
                }
            // } else {
               
            //     return $this->responseWithError('You have not checked in yet', [], 200);
            // }
        } catch (\Throwable $th) {
            return $this->responseWithError(_trans('response.Something went wrong.'), [], 400);
        }
    }

    public function breakStartEndWeb($request, $slug)
    {
        try {
            $takeBreak = $this->model->query()
                ->where([
                    'company_id' => $this->companyInformation()->id,
                    'user_id' => auth()->id(),
                    'date' => date('Y-m-d'),
                ])->whereNull('back_time')
                ->orderByDesc('id')->first();
            if ($takeBreak) {
                $takeBreak->back_time = $request->time;
                $takeBreak->save();
                return $takeBreak;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function breakBackHistory($request)
    {
        // if (appSuperUser() || $request->user_id) {
        //     $validator = Validator::make($request->all(), [
        //         'user_id' => 'required',
        //     ]);

        //     if ($validator->fails()) {
        //         return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        //     }

        //     $userId = $request->user_id;
        // } else {
        //     $userId = auth()->user()->id;
        // }

        // code from hrm-api-2.0  
        if(!$request->user_id){  // logic added new
            $userId = auth()->user()->id;
        } else if (appSuperUser() || $request->user_id) {
            $userId = $request->user_id;
        } else {
            $userId = auth()->user()->id;
        }
        // code from hrm-api-2.0 end

        $totalBreakBacks = $this->model->query()->where('user_id', $userId)->whereNotNull('back_time');
        $totalBreakBacks->when(\request()->get('date'), function (Builder $builder) {
            return $builder->where('date', \request()->get('date'));
        });
        if (!\request()->get('date')) {
            $totalBreakBacks = $totalBreakBacks->where('date', date('Y-m-d'));
        }
        $totalBreakBacks = $totalBreakBacks->orderBy('created_at', 'DESC')->paginate(10);
        $totalBreakTime = 0;
        $totalBackTime = 0;
        $totalBreakTimeCount = 0;
        foreach ($totalBreakBacks as $item) {
            $totalBreakTime += $this->timeToSeconds($item->break_time);
            $totalBackTime += $this->timeToSeconds($item->back_time);
        }
        $totalBreakTimeCount = $this->totalSpendTime($totalBreakTime, $totalBackTime);
        $data['total_break_time'] = $totalBreakTimeCount;
        $data['has_break'] = $totalBreakBacks->count() > 0 ? true : false;
        $data['break_history'] = new BreakBackCollection($totalBreakBacks);

        return $this->responseWithSuccess('Break history', $data, 200);
    }

    public function breakBackHistoryStatics($request)
    {
        if (appSuperUser()) {
            $userId = $request->user_id;
        } else {
            $userId = auth()->user()->id;
        }
    
        $currentDate = date('Y-m-d');
        $totalBreakBacks = $this->model->query()
            ->where('user_id', $userId)
            ->whereNotNull('back_time')
            ->where('date', $currentDate)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
    
        $totalBreakTime = 0;
        $totalBackTime = 0;
    
        foreach ($totalBreakBacks as $item) {
            $totalBreakTime += $this->timeToSeconds($item->break_time);
            $totalBackTime += $this->timeToSeconds($item->back_time);
        }
    
        $totalBreakTimeCount = $this->totalSpendTime($totalBreakTime, $totalBackTime);
    
        $data['total_break_time'] = $totalBreakTimeCount;
        $data['has_break'] = $totalBreakBacks->count() > 0 ? true : false;
        $data['break_history'] = new BreakBackStaticsCollection($totalBreakBacks);
    
        return $this->responseWithSuccess('Break history', $data, 200);
    }

    public function breakBackTodayHistoryStatics($request)
    {
        if (appSuperUser()) {
            $userId = $request->user_id;
        } else {
            $userId = auth()->user()->id;
        }
    
        $currentDate = date('Y-m-d');
        $totalBreakBacks = $this->model->query()
            ->where('user_id', $userId)
            ->whereNotNull('back_time')
            ->where('date', $currentDate)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
    
        return new BreakBackStaticsCollection($totalBreakBacks);
    }
    
    public function userBreakHistory($request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }
        $totalBreakBacks = $this->model->query()->where('user_id', $request->user_id)->whereNotNull('back_time');
        $totalBreakBacks->when(\request()->get('date'), function (Builder $builder) {
            return $builder->where('date', \request()->get('date'));
        });
        if (!\request()->get('date')) {
            $totalBreakBacks = $totalBreakBacks->where('date', date('Y-m-d'));
        }
        $totalBreakBacks = $totalBreakBacks->orderBy('created_at', 'DESC')->paginate(10);
        $totalBreakTime = 0;
        $totalBackTime = 0;
        $totalBreakTimeCount = 0;
        foreach ($totalBreakBacks as $item) {
            $totalBreakTime += $this->timeToSeconds($item->break_time);
            $totalBackTime += $this->timeToSeconds($item->back_time);
        }
        $totalBreakTimeCount = $this->totalSpendTime($totalBreakTime, $totalBackTime);
        $data['total_break_time'] = $totalBreakTimeCount;
        $data['has_break'] = $totalBreakBacks->count() > 0 ? true : false;
        $data['break_history'] = new BreakBackCollection($totalBreakBacks);

        return $this->responseWithSuccess('Break history', $data, 200);
    }

    public function isBreakRunning()
    {
        $takeBreak = $this->model->query()
            ->where([
                'company_id' => $this->companyInformation()->id,
                'user_id' => auth()->id(),
                'date' => date('Y-m-d')
            ])->whereNull('back_time')
            ->first();
        if ($takeBreak) {
            $takeBreak['status'] = "break_in";
            $takeBreak['back_time'] = "";
            $diffTime = Carbon::parse(now())->format("H%:%i:s%");
            $takeBreak['diff_time'] = $this->hourMinSecond($takeBreak->break_time);
            return $takeBreak;
        } else {
            $takeBreak = [
                "break_time" => "",
                "back_time" => "",
                "reason" => "",
                "created_at" => "",
                "updated_at" => "",
                "status" => "break_out",
                "diff_time" => ""
            ];
            return $takeBreak;
        }
    }
}
