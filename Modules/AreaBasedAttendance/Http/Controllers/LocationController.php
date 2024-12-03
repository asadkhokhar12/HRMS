<?php

namespace Modules\AreaBasedAttendance\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use Modules\AreaBasedAttendance\Http\Repositories\locationRepository;

class LocationController extends Controller
{
    use ApiReturnFormatTrait;
    protected $locationRepository;

    public function __construct(locationRepository $locationRepository)
    {
        if (!isModuleActive('AreaBasedAttendance')) {
            abort('404');
        }

        $this->locationRepository = $locationRepository;
    }

    function location(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->locationRepository->table($request);
            }
            $data['table'] = route('company.settings.location');
            $data['url_id'] = 'location_table_url';
            $data['class'] = 'table_class';
            $data['delete_url'] = route('location.delete_data');
            $data['status_url'] = route('location.statusUpdate');
            $data['checkbox'] = true;
            $data['fields'] = $this->locationRepository->fields();
            $data['title'] = _trans('settings.Location Binding');
            return view('areabasedattendance::location.index', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    function datatable()
    {
        return $this->locationRepository->datatable();
    }

    function locationCreate()
    {
        $data['title'] = _trans('settings.Location Binding Create');
        $data['url'] = (hasPermission('location_create')) ? route('company.settings.locationStore') : '';
        return view('areabasedattendance::location.create', compact('data'));
    }

    function locationPicker(Request $request)
    {
        try {
            return view('areabasedattendance::location.location_picker_modal');
        } catch (\Throwable $e) {
            return response()->json('fail');
        }
    }

    function locationStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'distance' => 'required',
                'status' => 'required',
                'location' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
        }
        try {
            $result = $this->locationRepository->create($request);
            if (@$result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], route('company.settings.location'));
            } else {
                return $this->responseWithError($result->original['message'], 422);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $data['location'] = $this->locationRepository->model([
                'id' => $id,
                'company_id' => 1,
            ])->first();
            $data['title'] = _trans('settings.Edit Location Binding');
            $data['url'] = (hasPermission('location_update')) ? route('company.settings.locationUpdate', $id) : '';
            return view('areabasedattendance::location.edit', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    function locationUpdate(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'distance' => 'required',
                'status' => 'required',
                'location' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
        }
        try {
            $result = $this->locationRepository->update($request, $id);
            if (@$result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], route('company.settings.location'));
            } else {
                return $this->responseWithError($result->original['message'], 422);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage());
        }
    }

    public function locationDestroy($id)
    {
        try {
            $result = $this->locationRepository->delete($id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('company.settings.location');
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->route('company.settings.location');
            }
        } catch (\Throwable $th) {
            Toastr::error(_translate('response.Something went wrong!'), 'Error');
            return redirect()->route('company.settings.location');
        }
    }

    public function statusUpdate(Request $request)
    {
        if (demoCheck()) {
            return $this->responseWithError(_trans('message.You cannot do it for demo'), [], 400);
        }
        return $this->locationRepository->statusUpdate($request);
    }

    public function deleteData(Request $request)
    {
        if (demoCheck()) {
            return $this->responseWithError(_trans('message.You cannot delete for demo'), [], 400);
        }
        return $this->locationRepository->destroyAll($request);
    }
}
