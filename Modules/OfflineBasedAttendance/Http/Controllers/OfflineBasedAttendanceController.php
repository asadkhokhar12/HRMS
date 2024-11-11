<?php

namespace Modules\OfflineBasedAttendance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\OfflineBasedAttendance\Repositories\AttendanceRepository;

class OfflineBasedAttendanceController extends Controller
{
    protected $attendance;

    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendance = $attendanceRepository;
    }

    public function manageAttendanceOffline(Request $request)
    {
        //$jsonArray = $request->json()->all();
        $jsonArray = $request->data;
        return $this->attendance->storeOffline($jsonArray);

        //$jsonArray = $request->data;
        //dd($request->data);
        //dd($request->json()->all());
        //$jsonArray = $request->json()->all();
        
    }
}
