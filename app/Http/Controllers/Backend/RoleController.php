<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;
use App\Http\Requests\Role\RoleRequestStore;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Role\Role;
use App\Repositories\Admin\RoleRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use RelationshipTrait, ApiReturnFormatTrait;

    protected RoleRepository $role;
    protected $model;

    public function __construct(RoleRepository $roleRepository, Role $model)
    {
        $this->role = $roleRepository;
        $this->model = $model;
    }

    public function index(Request $request)
    {
        // return Role::where('company_id', 1)->get();
        // return $this->role->table($request);
        if ($request->ajax()) {
            return $this->role->table($request);
        }
        $data['title'] = _trans('common.Roles');
        $data['class'] = 'role_table';
        $data['fields'] = $this->role->fields();
        $data['checkbox'] = true;
        return view('backend.roles.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = _trans('common.Add Role');
        $data['permissions'] = $this->role->getPermission();
        return view('backend.roles.create', compact('data'));
    }

    public function dataTable(Request $request): object
    {
        return $this->role->dataTable($request);
    }

    public function show($id)
    {
        return $this->role->show($id);
    }

    public function edit(Role $role)
    {
        $data['title'] = 'Edit Role';
        $data['role'] = $role;
        $data['roles'] = $this->role->getAll();
        $data['permissions'] = $this->role->getPermission();
        return view('backend.roles.edit', compact('data'));
    }

    public function update(RoleRequest $request, Role $role): \Illuminate\Http\RedirectResponse
    {

        try {
            if ($this->isExistsWhenUpdate($role, $this->model, 'name', $request->name)) {
                $request['company_id'] = $this->companyInformation()->id;
                $request['role_id'] = $role->id;
                $request['upper_roles'] = $role->slug != 'admin' && $request->filled('upper_roles') ? json_encode($request->upper_roles) : null;
                $request['permissions'] = $request->filled('permissions') ? $request->permissions : [];

                $this->role->update($request);
              
                Toastr::success(_trans('message.Role update successfully'), 'Success');
                return redirect()->route('roles.index');
            } else {
                Toastr::error("{$request->name} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {

        try {
            $this->role->destroy($id);
            // Toastr::success(_trans('message.Role delete successfully'), 'Success');
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function changeRole(Request $request)
    {
        $data['role_permissions'] = $this->role->get($request->role_id)->permissions;
        $data['permissions'] = $this->role->getPermission();
        return view('backend.user.permissions', compact('data'));
    }

    // status change
    public function statusUpdate(Request $request)
    {
        // if (appMode()) {
        //     return $this->responseWithError(_trans('message.You cannot do it for demo'), [], 400);
        // }
        return $this->role->statusUpdate($request);
    }

    // destroy all selected data

    public function deleteData(Request $request)
    {
        // if (appMode()) {
        //     return $this->responseWithError(_trans('message.You cannot delete for demo'), [], 400);
        // }
        return $this->role->destroyAll($request);
    }

    // new functions for

    public function createModal()
    {
        try {
            $data['title'] = _trans('common.Create Role');
            $data['url'] = route('roles.store');
            $data['attributes'] = $this->role->createAttributes();
            @$data['button'] = _trans('common.Save');
            return view('backend.modal.create', compact('data'));
        } catch (\Throwable $th) {
            return response()->json('fail');
        }
    }

    public function store(RoleRequestStore $request)
    {
        try {
            if (!$request->ajax()) {
                Toastr::error(_trans('response.Please click on button!'), 'Error');
                return redirect()->back();
            }
            // if (appMode()) {
            //     return $this->responseWithError(_trans('message.You cannot do it for demo'), [], 400);
            // }
            return $this->role->newStore($request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function changeLogin(Request $request)
    {
        try {
            $result = $this->role->changeLogin($request);
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role Changed Successfully',
                ], 201);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Role Changed Failed',
                ], 201);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => '=Something went wrong',
            ], 201);
        }
    }
}
