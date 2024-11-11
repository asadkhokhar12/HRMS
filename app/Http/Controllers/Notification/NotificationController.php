<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\ExpireNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $data['title'] = _trans('common.Notification');
        return view('backend.notification.index', compact('data'));
    }

    //readNotification
    public function readNotification(Request $request)
    {
        try {
            $notification = auth()->user()->unreadNotifications->where('id', $request->id)->first();
            if ($notification->read_at == null) {
                $notification->markAsRead();
            }
            $action_url= $notification->data['actionURL']['web'];
            $data=[];
            $data['action_url'] = $action_url;
            $data['notification'] = $notification;
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    // expire notification
    public function expireIndex()
    {
        $data['title'] = _trans('common.Expire Notification');
        $data['notifications'] = ExpireNotification::with('user.designation','user.department')->where(['receiver_id' => auth()->user()->id, 'is_read' => 0])->get();
        return view('backend.notification.expire_notification', compact('data'));
    }
}
