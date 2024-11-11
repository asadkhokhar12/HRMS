<?php

namespace App\Http\Controllers;

use Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Http;
use App\Models\Permission\Permission;
use App\Models\Hrm\Attendance\Attendance;
use App\Notifications\HrmSystemNotification;
use App\Helpers\CoreApp\Traits\PermissionTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Hrm\Attendance\AttendanceRepository;

class DevController extends Controller
{
    use PermissionTrait,ApiReturnFormatTrait;
    
    public function lol(){

        try{
  
          $users =  DB::connection('mysql2')->select("SELECT * FROM users WHERE company_id = 3");
          foreach ($users as $user ){
              $request = $user;
              $data =  [
                  "name" => $request->name,
                  "company_id" => 1,
                  "branch_id" => 1,
                  "country_id" => 17,
                  "phone" => $request->phone,
                  "role_id" => 4,
                  "department_id" => 17,
                  "designation_id" => 33,
                  "shift_id" => 4,
                  "email" => $request->email,
             ];
  
             $this->createNewUser($data);
          }
  
  
         return 'done';
        }
        catch(\Throwable $th){
          dd($th);
          return $th;
        }
  
      }

      
      
    public function sendNotification(Request $request)
    {
        $user = User::first();
  
        $details = [
            'title' => 'Hi Artisan',
            'body' => 'This is my first notification',
            'actionText' => 'View My Site',
            'actionURL' => [
                'app' => '',
                'web' => url('/'),
                'target' => '_blank',
            ],
            'sender_id' => 46
        ];
  
        Notification::send($user, new HrmSystemNotification($details));
   
    }



    public function permissionUpdate()
    {
        try {
            DB::beginTransaction();
            $delete_existing_permissions = Permission::truncate();
            $attributes = $this->adminRolePermissions();
            foreach ($attributes as $key => $attribute) {
                $permission = new Permission;
                $permission->attribute = $key;
                $permission->keywords = $attribute;
                $permission->save();
            }
            DB::commit();
            Toastr::success(_trans('settings.Permission updated successfully'), 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
        
    }

    public function syncFlug($language_name)
    {
       try {
        $url = "https://restcountries.com/v3.1/lang/Afrikaans";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);
        curl_close($curl);
       } catch (\Throwable $th) {
       }
    }
    public function employees($company_id)
    {
        $users = User::active()->where('company_id',$company_id)->select('id', 'name', 'avatar_id')->get();
        $results = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => uploaded_asset($user->avatar_id),
            ];
        });
        return response()->json($results);
    }

    public function attendance(Request $request,$employee_id,$mode_type)
    {
        try {
            $attendance_repository=resolve(AttendanceRepository::class);

                $request['latitude'] = 'office';
                $request['longitude'] = 'office';
                $request['check_in'] = date('H:i');
                $request['check_out'] = date('H:i');
                $request['date'] =  date('Y-m-d');

            if ($mode_type == 'checkin') {

                $user=User::find($employee_id);

                if($user){
                    $check_in=Attendance::where('user_id',$employee_id)->where('date',$request['date'])->first();
                    if(!$check_in){
                        $check_in = new Attendance();
                    }
                    $check_in->company_id = $user->company->id;
                    $check_in->user_id = $user->id;
                    $check_in->remote_mode_in = 0;
                    $check_in->date = $request['date'];

                    $check_in->check_in = date('Y-m-d H:i:s');
                    $attendance_status = $attendance_repository->checkInStatus($user->id, $request['check_in']);

                    $check_in->in_status = $attendance_status[0];
                    $check_in->checkin_ip = $request->checkin_ip;
                    $check_in->late_time = $attendance_status[1];
                    $check_in->check_in_location = 'office';
                    $check_in->check_in_latitude = $request['latitude'];
                    $check_in->check_in_longitude = $request['longitude'];
                    $check_in->check_in_city = 'office';
                    $check_in->check_in_country_code = 'office';
                    $check_in->check_in_country = 'office';
                    $check_in->save();
                    return $this->responseWithSuccess('Check In successfully', $check_in, 200);
                }else{
                    return response()->json(['message' => 'User not found'], 404);
                }

                
            } else {
                       $check_in = Attendance::where('user_id', $employee_id)
                       ->where('date', $request['date'])
                    //    ->where('check_out', null)
                       ->first();
                       $attendance_status = $attendance_repository->checkOutStatus($employee_id, $request['check_out']);
                        if ($check_in) {
                            $check_in->user_id =$employee_id;
                            $check_in->remote_mode_out = 0;
                            $check_in->check_out = date('Y-m-d H:i:s');
                            $check_in->out_status = $attendance_status[0];
                            $check_in->checkout_ip = $request->checkin_ip;
                            $check_in->late_time = $attendance_status[1];
                            $check_in->check_out_location = 'office';
                            $check_in->check_out_latitude = 'office';
                            $check_in->check_out_longitude = 'office';
                            $check_in->check_out_city = 'office';
                            $check_in->check_out_country_code = 'office';
                            $check_in->check_out_country = 'office';
                            $check_in->save();

                            return $this->responseWithSuccess('Check out successfully', $check_in, 200);
                        } else {
                            return $this->responseWithError('No data found or checkout', [], 400);
                        }
            }
            
        } catch (\Throwable $th) {
            return $this->responseWithError('Something Wrong', [], 500);
        }

    }
    public function getAttendance(Request $request,$employee_id,$date)
    {
        try {
            $attendance = Attendance::where('user_id', $employee_id)
            ->where('date', $date)
            ->first();
            if ($attendance) {
                $data=[];
                $data['check_in']=$attendance->check_in;
                $data['check_out']=$attendance->check_out;
                $data['in_status']=$attendance->in_status;
                $data['out_status']=$attendance->out_status;

                return $this->responseWithSuccess('Attendance data', $data, 200);
            } else {
                return $this->responseWithError('No data found', [], 400);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError('Something Wrong', [], 500);
        }
    }
}
