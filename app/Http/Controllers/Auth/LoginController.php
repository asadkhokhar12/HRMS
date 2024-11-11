<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and

    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function credentials($request)
    {
        if (is_numeric($request->get('email'))) {
            return ['email' => $request->get('email'), 'password' => $request->get('password'), 'is_email' => 0];
        } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password' => $request->get('password'), 'is_email' => 1];
        }
    }


    public function authenticate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'password' => 'required',
                'device_uuid' => 'required'
            ],
            [
                'email.required' => 'Phone or email required'
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $credentials = $this->credentials($request);

            if ($credentials['is_email']) {
                $type = 'email';
                $input = ['email' => $credentials['email'], 'password' => $credentials['password'], 'status_id' => 1];
            } else {
                $type = 'phone';
                $input = ['phone' => $credentials['email'], 'password' => $credentials['password'], 'status_id' => 1];
            }

            $user = User::where($type, $request->email)->first();

            if ($user) {
                // if ($user->role_id == 1) {
                //     Auth::logout();
                //     return response()->json(['error' => ['email' => ["Please login to SAAS admin panel"]]], 422);
                // }
                if (isModuleActive('SingleDeviceLogin')) {
                    if ($user->is_admin == 1 || $user->role_id == 1) {
                        return $this->userLogin($input, $user, $request->device_uuid);
                    }
                    if ($user->device_uuid == null || $user->device_uuid == $request->device_uuid) {
                        return $this->userLogin($input, $user, $request->device_uuid);
                    } else {
                        return response()->json(['error' => ['email' => ["User already registered with another device"]]], 422);
                    }
                } else {
                    return $this->userLogin($input, $user, $request->device_uuid);
                }
                
                
            } else {
                return response()->json(['error' => ['email' => ["User not found"]]], 422);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => ['email' => ["Something went wrong"]]], 422);
        }
    }
    public function userLogin($input, $user, $uuid)
    {
        if(isModuleActive('SingleDeviceLogin')){
            
            if ($user->role->web_login != 1 && $user->id != 1) {
                return response()->json(['error' => ['email' => ["You don't have permission to login"]]], 422);
            }
        }
        if (Auth::attempt($input)) {
            try {
                $user->_token = auth()->getSession()->getId();
                $user->last_login_device = 'web';
                $user->device_uuid = $uuid;
                // $this->logoutFromMobile($user);
                $user->save();
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            // Auth::logoutOtherDevices(request('password'));
            return 0;
        } else {
            return response()->json(['error' => ['email' => ["Credentials doesn't match"]]], 422);
        }
    }
    function SingleDevice()
    {
    }

    public function authenticated()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back();
        }
    }
}
