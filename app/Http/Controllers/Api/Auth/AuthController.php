<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Company\Company;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProfileRepository;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use Modules\Saas\Entities\UserTenantMapping;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use GuzzleHttp\Exception\RequestException;

class AuthController extends Controller
{
    public $token = true;
    protected $profile;

    use ApiReturnFormatTrait;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profile = $profileRepository;
    }





    public function companyList()
    {
        $data = Company::where(['status_id' => 1, 'is_main_company' => 'no'])->get();
        if(config('app.mood')==="Saas" && isModuleActive("Saas")){  //Saas
            $collection = $data->map(function ($data) {
                $subdomain = $data->subdomain;
                if ($subdomain) {
                    if (env('APP_HTTPS')) {
                        $url = 'https://' . $subdomain . '/api/V11/';
                    } else {
                        $url = 'http://' . $subdomain . '/api/V11/';
                    } 
                } else {
                    $url = url('/api/V11/');
                }
                return [
                    'id' => $data->id,
                    'company_name' => $data->company_name,
                    'subdomain' => $subdomain ?? env('APP_URL'),
                    'url' => $url,
                ];
            });
        } else{  //Non-saas
            $collection = [
                    [
                    'id' => 1,
                    'company_name' => env('APP_NAME'),
                    'subdomain' => @base_settings('company_domain'),
                    'url' => 'https://'. @base_settings('company_domain') .'/api/V11/',
                    ]
            ];
        }
        return $this->responseWithSuccess('Company List', $collection, 200);
    }
    
    public function credentials($request)
    {
        if (is_numeric($request->get('email'))) {
            return ['email' => $request->get('email'), 'password' => $request->get('password'), 'is_email' => 0];
        } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password' => $request->get('password'), 'is_email' => 1];
        }
    }

    public function centralLogin(Request $request)
    {
        $userMapping = UserTenantMapping::where('email', $request->email)->first();
        if ($userMapping) {
            
            $subdomainURL = env('APP_HTTPS') ? 'https://' : 'http://';
            $apiUrl = $subdomainURL . $userMapping->domain . '/api/V11/login';

            try {
                $client = new \GuzzleHttp\Client();
                $response = $client->request('POST', $apiUrl, [
                    'form_params' => [
                        'email' => $request->email,
                        'password' => $request->password,
                        'device_id' => $request->device_id ?? null,
                        'device_info' => $request->device_info ?? null,
                    ],
                ]);
            
                if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                    $responseData = json_decode($response->getBody()->getContents(), true);
                    $responseData['data']['base_url'] = $subdomainURL . $userMapping->domain;
                    $responseData['data']['api_url'] = $subdomainURL . $userMapping->domain.'/api/V11';

                    return $responseData;
                } else {
                    return $response->getBody()->getContents();
                }
            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    return $e->getResponse()->getBody()->getContents();
                } else {
                    return $this->responseWithError('Something went wrong!', [], 500);
                }
            }
        } else {
            return $this->responseWithError('User not found', [], 404);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),
            [
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);

            }
            if (isModuleActive('SingleDeviceLogin')) {

                $validator = Validator::make($request->all(),
                    [
                        'device_id' => 'required',
                        'device_info' => 'required',
                    ]);

                if ($validator->fails()) {
                    return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
                }
            }

            $identifier = filter_var($request->email, FILTER_VALIDATE_EMAIL)? 'email' : 'phone';
            $request->merge(['phone' => $identifier == 'phone' ? $request->email : '']);


            if (!Auth::attempt($request->only([$identifier, 'password']))) {
                return $this->responseWithError(__('Invalid Email or Password'), [], 400);
            }

            $user = User::where($identifier, $request->$identifier)->first();
            if (isModuleActive('SingleDeviceLogin')) {
                if ($user) {
                    if ($user->device_id == null || $user->device_id == $request->device_id) {
                        $checkUser['id'] = $user->id;
                        $checkUser['company_id'] = $user->company_id;
                        $checkUser['department_id'] = $user->department_id;
                        $checkUser['department_name'] = $user->department->title;
                        $checkUser['is_admin'] = auth()->user()->is_admin ? true : false;
                        $checkUser['is_hr'] = auth()->user()->is_hr ? true : false;
                        $checkUser['is_face_registered'] = auth()->user()->face_data ? true : false;
                        $checkUser['name'] = $user->name;
                        $checkUser['email'] = $user->email;
                        $checkUser['phone'] = $user->phone;
                        $checkUser['avatar'] = uploaded_asset($user->avatar_id);

                        $user->device_id = $request->device_id;
                        $user->device_info = $request->device_info;
                        $user->last_login_device = 'mobile';
                        $user->save();
                    } else {
                        return $this->responseWithError(__('User already registered with another device'), [], 401);
                    }
                } else {
                    return $this->responseWithError(__('User not found'), [], 401);
                }
            } else {
                $checkUser['id'] = $user->id;
                $checkUser['company_id'] = $user->company_id;
                $checkUser['department_id'] = $user->department_id;
                $checkUser['department_name'] = $user->department->title;
                $checkUser['is_admin'] = auth()->user()->is_admin ? true : false;
                $checkUser['is_hr'] = auth()->user()->is_hr ? true : false;
                $checkUser['is_face_registered'] = auth()->user()->face_data ? true : false;
                $checkUser['name'] = $user->name;
                $checkUser['email'] = $user->email;
                $checkUser['phone'] = $user->phone;
                $checkUser['avatar'] = uploaded_asset($user->avatar_id);
            }

            if ($user->role->app_login == 1) {
                $checkUser['token'] = $user->createToken("API TOKEN")->plainTextToken;
            } else {
                return $this->responseWithError(__('You are not allowed to login to the APP'), [], 400);
            }
            if (isModuleActive('SingleDeviceLogin')) {
                $user->app_token = $checkUser['token'];
            }
            $user->save();

            // exceptional for login
            return $this->responseWithSuccess(__('Successfully Login'), $checkUser, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage());
        }
    }

    public function logout()
    {
        try {
            if (isModuleActive('SingleDeviceLogin')) {
                $user = User::find(auth()->id());
                $user->app_token = null;
                $user->device_id = null;
                $user->device_info = null;
                $user->last_login_device = null;
                $user->save();
            }

            auth()->user()->currentAccessToken()->delete();
            return $this->responseWithSuccess(__('Logged Out'), [], 200);

        } catch (\Throwable $th) {
            return $this->responseWithError(__('Something Went Wrong! Please Try Again'), [], 400);
        }
    }

    public function logoutAllDevices()
    {
        try {
            auth()->user()->tokens()->delete();
            return $this->responseWithSuccess(__('Successfully Logged Out from All Devices'), [], 200);

        } catch (\Throwable $th) {
            return $this->responseWithError(__('Something Went Wrong! Please Try Again'), [], 400);
        }
    }

    public function getUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
        ]);

        $token = PersonalAccessToken::findToken($request->token);
        $user = $token->tokenable;

        return response()->json(['user' => $user]);
    }

    public function sendResetLinkEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->profile->sendEmail($request);
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }

    }

    public function changePassword(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->profile->updatePassword($request);
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }




    function testFace(Request $request){
        
       dd($request->response, $request->user_id);
        return $this->responseWithSuccess(__('Successfully data comes from regula'), [], 200);
    }
}
