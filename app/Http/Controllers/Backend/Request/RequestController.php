<?php

namespace App\Http\Controllers\Backend\Request;

use App\Models\Award\Award;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\StoreAwardRequest;
use App\Services\Request\RequestService;
use App\Http\Requests\UpdateAwardRequest;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;

class RequestController extends Controller
{
    use ApiReturnFormatTrait;

    protected $service;

    public function __construct(RequestService $service)
    {
        //request::call 4
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data['checkbox'] = true;
            $data['title'] = _trans('request.Request List');
            $data['table'] = route('request.table');
            $data['url_id'] = 'request_table_url';
            $data['fields'] = $this->service->fields();
            $data['class'] = 'request_table_class';
            return view('backend.request.index', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function table(Request $request)
    {
        if ($request->ajax()) {
            return $this->service->table($request);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $data['title'] = _trans('request.Create Request');
            $data['url'] = (hasPermission('request_store')) ? route('request.store') : '';
            $data['types'] = dbTable('request_types', ['name', 'id'], ['company_id' => auth()->user()->company_id])->get();
            return view('backend.request.create', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAwardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $result = $this->service->store($request);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('request.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Award\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        try {
            $data['title'] = _trans('award.View Request');
            $data['view'] = $this->service->where([
                'id' => $id,
                'company_id' => auth()->user()->company_id,
            ])->first();
            if (!$data['view']) {
                Toastr::error(_trans('response.Request not found.'), 'Error');
                return redirect()->back();
            }
            return view('backend.request.view', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Award\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data['title'] = _trans('request.Edit Request');
            $data['edit'] = $this->service->where([
                'id' => $id,
                'company_id' => auth()->user()->company_id,
            ])->first();
            if (!$data['edit']) {
                Toastr::error(_trans('response.Request not found.'), 'Error');
                return redirect()->back();
            }
            $data['url'] = (hasPermission('request_update')) ? route('request.update', $id) : '';
            $data['request_types'] = dbTable('request_types', ['name', 'id'], ['company_id' => auth()->user()->company_id])->get();
            return view('backend.request.edit', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAwardRequest  $request
     * @param  \App\Models\Award\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        try {
            $result = $this->service->update($request, $id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('request.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Award\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $result = $this->service->delete($id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('request.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $params = [
                'id' => $id,
                'company_id' => auth()->user()->company_id,
            ];
            if (!is_Admin()) {
                $params['user_id'] = auth()->user()->id;
            }
            $data['request'] = $this->service->where($params)->first();
            if (!$data['request']) {
                Toastr::error(_trans('response.Request not found.'), 'Error');
                return redirect()->back();
            }
            $data['url'] = (hasPermission('request_approve')) ? route('request.approve_store', $id) : '';
            $data['button'] = _trans('common.Approve');
            $data['title'] = _trans('request.Request Approve');
            return view('backend.request.approve_modal', compact('data'));
        } catch (\Throwable $e) {
            return response()->json('fail');
        }
    }
    public function approve_store(Request $request, $id)
    {
        try {
            $result = $this->service->approve($request, $id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('request.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    // status change
    public function statusUpdate(Request $request)
    {
        if (demoCheck()) {
            return $this->responseWithError(_trans('message.You cannot do it for demo'), [], 400);
        }
        return $this->service->statusUpdate($request);
    }

    // destroy all selected data

    public function deleteData(Request $request)
    {
        if (demoCheck()) {
            return $this->responseWithError(_trans('message.You cannot delete for demo'), [], 400);
        }
        return $this->service->destroyAll($request);
    }

    public function userProfileTable(Request $request)
    {

        //request::call 5
        if ($request->ajax()) {
            return $this->service->table($request);
        }
        return $this->service->table($request);
    }
}
