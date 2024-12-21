<?php

namespace App\Http\Controllers;

use App\Models\FullCalenderEvent;
use App\Models\Hrm\Appoinment\Appoinment;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class FullCalenderController extends Controller
{
    protected $user;
    public function __construct(
        UserRepository $user,
       
    ) {
        $this->user = $user;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $userId = $request->user_id? $request->user_id: auth()->user()->id;

            $data = Appoinment::whereDate('date', '>=', $request->start)
                ->whereDate('date',   '<=', $request->end)
                ->where('created_by', $userId)
                ->get(['id', 'title', 'date', 'appoinment_start_at', 'appoinment_end_at']);

            $events = [];

            foreach($data as $event)
            {
                $events[] = [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => date('Y-m-d H:i a', strtotime($event->date.' '.$event->appoinment_start_at)),
                    'end' => date('Y-m-d H:i a', strtotime($event->date.' '.$event->appoinment_end_at)),
                ]; 
            }

            return response()->json($events);
        }

        $employee = $this->user->getActiveAll();

        return view('calendar', compact('employee'));
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->type == 'add') {
                $event = FullCalenderEvent::create([
                    'title'        =>    $request->title,
                    'start'        =>    $request->start,
                    'end'        =>    $request->end
                ]);

                return response()->json($event);
            }

            if ($request->type == 'update') {
                $event = FullCalenderEvent::find($request->id)->update([
                    'title'        =>    $request->title,
                    'start'        =>    $request->start,
                    'end'        =>    $request->end
                ]);

                return response()->json($event);
            }

            if ($request->type == 'delete') {
                $event = FullCalenderEvent::find($request->id)->delete();

                return response()->json($event);
            }
        }
    }
}
