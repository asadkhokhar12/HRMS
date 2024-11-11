<?php
namespace App\Traits;

use App\Models\Hrm\Attendance\Attendance;
use Carbon\Carbon;

trait AutoCheckoutTrait {
    public function autoCheckout(){
        
        
        try {
            //code...
            $attendances = $this->incompleteAttendances();
            foreach($attendances as $attendance){
                // $inputTime = $attendance->user->shift->dutySchedule->end_time;
                // $time = Carbon::createFromFormat('H:i:s', $inputTime);
                // $time->addMinutes(1);
                // $resultTime = $time->format('H:i:s');

                // $attendance->update([
                //     'check_out' => $attendance->date.' '.'23:59:59',
                    // 'check_out' => $attendance->date.' '.$resultTime,
                // ]);
            }
            echo "Auto Checkout Successful";
        } catch (\Throwable $th) {
            //throw $th;
            echo "Sorry! Something went wrong";
        }

    }

    protected function incompleteAttendances(){
        $selectable = ['id', 'user_id', 'date', 'check_in', 'check_out'];
        $Incomplete_attendances = Attendance::with('user')->whereNotNull('check_in')->whereNull('check_out')->select($selectable)->get();
        return $Incomplete_attendances;
    }
}