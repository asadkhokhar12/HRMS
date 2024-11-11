<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kreait\Laravel\Firebase\Facades\Firebase;

class ExpireNotificationController extends Controller
{

    public function getAllEmployeeListApi()
    {
        $users = DB::table('users')->select('id', 'name', 'email', 'phone')->get()->toArray();
        return response()->json($users, 200);
    }
    public function glist()
    {
    //     $now = now()->subMinute(50)->toDateTimeString();
    //     $list = [];
    //     $firebase_data = Firebase::firestore()
    //     ->database()
    //     ->collection('hrm_employee_track')
    //     ->where('datetime', '>=', $now)
    //     ->orderBy('datetime')
    //     ->documents();
    // $data = [];
    // foreach ($firebase_data as $document) {
    //     $data[] = $document->data();
    // }
    //  dd($firebase_data);
    

    //     foreach ($firebase_data as $key => $value) {
    //         dd($value->data());
    //         $list[] = $value['data'];
    //     }
    //     dd($list);
        return view('test.glist');
    }

    public function index()
    {

        try {
            $startDate = now()->addDays(30)->format('m/d/Y');
            $endDate = now()->addDays(31)->format('m/d/Y');

            $users = User::active()->select(
                'id',
                'name',
                'branch_id',
                'department_id',
                'company_id',
                'passport_expire_date',
                'eid_expire_date',
                'visa_expire_date',
                'insurance_expire_date',
                'labour_card_expire_date',
                'passport_is_notified',
                'eid_is_notified',
                'visa_is_notified',
                'insurance_is_notified',
                'labour_card_is_notified'
            )
                ->whereBetween('passport_expire_date', [$startDate, $endDate])
                ->orWhereBetween('eid_expire_date', [$startDate, $endDate])
                ->orWhereBetween('visa_expire_date', [$startDate, $endDate])
                ->orWhereBetween('insurance_expire_date', [$startDate, $endDate])
                ->orWhereBetween('labour_card_expire_date', [$startDate, $endDate])
                ->get();

            $hrReceivers = getNotifiableIds();

            foreach ($users as $user) {
                $this->processExpirationNotification($user, 'passport', $startDate, $endDate, $hrReceivers);
                $this->processExpirationNotification($user, 'eid', $startDate, $endDate, $hrReceivers);
                $this->processExpirationNotification($user, 'visa', $startDate, $endDate, $hrReceivers);
                $this->processExpirationNotification($user, 'insurance', $startDate, $endDate, $hrReceivers);
                $this->processExpirationNotification($user, 'labour_card', $startDate, $endDate, $hrReceivers);
            }

            return response()->json("success");
        } catch (\Exception $e) {
        }
    }

    private function processExpirationNotification($user, $type, $startDate, $endDate, $hrReceivers)
    {
        $notifiedField = "{$type}_is_notified";
        $expireDateField = "{$type}_expire_date";

        if ($user->$notifiedField == 0 && $startDate <= $user->$expireDateField && $endDate <= $user->$expireDateField) {
            $user->where('id', $user->id)->update([$notifiedField => 1]);

            foreach ($hrReceivers as $hr) {

                try {
                    $insert = new ExpireNotification();
                    $insert->receiver_id = $hr->id;
                    $insert->employee_id = $user->id;
                    $insert->branch_id = $user->branch_id;
                    $insert->company_id = $user->company_id;
                    $insert->title = $user->name . "'s {$type} is expired";
                    $insert->description = $user->name . "'s {$type} is expired on date " . $user->$expireDateField;
                    $insert->is_read = 0;
                    $insert->save();
                } catch (\Throwable $th) {
                    //throw $th;
                }

                $userData = [
                    'name' => $hr->name,
                    'user_name' => $user->name,
                    'user_department' => $user->department->title,
                    'expire_date' => $user->$expireDateField,
                    'type' => $type,
                ];
                try {
                    dispatch(new SendExpireNotificationEmailQueueJob($hr->email, $userData));
                } catch (Exception $e) {
                }
            }
        }
        return true;
    }

    public function notificationRead($id, $employee_id)
    {
        ExpireNotification::where('id', $id)->update(['is_read' => 1]);
        return redirect('dashboard/user/show/' . @$employee_id . '/personal');
    }
}
