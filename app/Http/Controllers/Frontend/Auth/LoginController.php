<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role\Role;
use App\Models\Tenant;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Saas\Entities\UserTenantMapping;

class LoginController extends Controller
{
    public function test()
    {
        return redirect()->route('adminLogin');
    }
    public function getDemoLoginData()
    {
        $users = [];
        try {
            if (config('app.style') === 'demo' || env('APP_STYLE') === "demo") {
                $roles = Role::where('company_id', 1)->get(); // Assuming you have a Role model

                foreach ($roles as $role) {
                    $user = User::join('roles', 'users.role_id', '=', 'roles.id')
                        ->where('users.company_id', 1)
                        ->where('roles.id', $role->id)
                        ->select('users.email', 'roles.name', 'users.company_id')
                        ->first();

                    if ($user) {
                        $users[] = $user;
                    }
                }
            }

            return $users;
        } catch (\Throwable $th) { 
            return $users;
        }
    }

    public function adminLogin()
    {

        $users = [];
        try {
            if (Auth::check()) {
                return redirect('dashboard');
            }
            $users = $this->getDemoLoginData();

            return view('backend.auth.admin_login', compact('users'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            abort(500);
        }
    }

    public function LoginForm()
    {
        return view('backend.auth.admin_login');
    }

    public function centralLoginPage()
    {
        return view('backend.auth.central-login');
    }

    public function centralLogin(Request $request)
    {
        try {
            // Validate the user's email and password
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Retrieve the user's domain from the user_tenant_mappings table
            $userMapping = UserTenantMapping::where('email', $request->email)->first();

            if ($userMapping) {
                // Set the database connection for the tenant
                $tenantConnection = $this->setTenantDatabaseConnection($userMapping->tenant_id);

                // Attempt to authenticate the user against the tenant's database
                if (Auth::guard('tenant')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
                    // Authentication successful, redirect to the user's subdomain
                    return Redirect::away("http://{$userMapping->subdomain}.yourdomain.com");
                }
            }

            // If authentication fails or user mapping not found, redirect back with error
            return redirect()->back()->withInput($credentials)->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        } catch (\Throwable $th) {
            // Handle exceptions
            return redirect()->back()->withInput($credentials)->withErrors([
                'email' => 'An error occurred while processing your request.',
            ]);
        }
    }

    private function setTenantDatabaseConnection($tenantId)
    {
        // Retrieve tenant database connection details and set the connection dynamically
        $tenant = Tenant::find($tenantId);

        config([
            'database.connections.tenant' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST'),
                'port' => env('DB_PORT'),
                'database' => $tenant->tenancy_db_name,
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]
        ]);

        return $tenant;
    }
}


// $credentials = $request->validate([
//     'email' => 'required|email',
//     'password' => 'required',
// ]);

// if (Auth::attempt($credentials)) {
//     // Authentication successful
//     return redirect()->intended('/dashboard');
// }

// // Authentication failed
// return redirect()->back()->withInput($request->only('email'))->withErrors([
//     'email' => 'These credentials do not match our records.',
// ]);
