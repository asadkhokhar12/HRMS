<?php

namespace App\Http\Controllers\Backend\Task;

use Illuminate\Http\Request;
use App\Services\Task\TaskService;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Services\Task\TaskFileService;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;

class TaskFileController extends Controller
{
    use FileHandler, ApiReturnFormatTrait;

    protected $fileService;
    protected $taskService;

    public function __construct(TaskFileService $fileService, TaskService $taskService)
    {
        $this->fileService = $fileService;
        $this->taskService    = $taskService;
    }
    // file table 
    public function table(Request $request, $id)
    {
        return $this->fileService->table($request, $id);
    }

    public function create(Request $request)
    {
        try {
            $result       = $this->taskService->where([
                'id' => $request->task_id,
                'company_id' => 1,
            ])->first();
            if (@$result) {
                $data['title']    = _trans('project.Create File');
                $data['view']     = $result;
                $data['url']      = (hasPermission('task_file_store')) ? route('task.file.store', 'task_id=' . $request->task_id) : '';
                $data['button']   = _trans('common.Submit');
                return view('backend.project.file.createModal', compact('data'));
            } else {
                return response()->json('fail');
            }
        } catch (\Throwable $th) {
            return response()->json('fail');
        }
    }

    public function store(Request $request)
    {
        try {
            $result = $this->fileService->store($request);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('task.view', [$request->task_id, 'files']);
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function comment(Request $request)
    {
        try {
            return $this->fileService->commentStore($request);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }


    // file download
    public function download(Request $request)
    {
        try {
            $result = $this->fileService->where([
                'id' => $request->file_id,
                'company_id' => 1,
                'task_id' => $request->task_id,
            ])->first();
            if (@$result) {
                return $this->downloadFile($result->attachment ?? null, $result->subject);
            } else {
                Toastr::error(_trans('response.Something went wrong.'), 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->fileService->delete($id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('task.view', [$result->original['data']->task_id, 'files']);
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    // destroy all selected data

    public function deleteData(Request $request)
    {
        if (demoCheck()) {
            return $this->responseWithError(_trans('message.You cannot delete for demo'), [], 400);
        }
        return $this->fileService->destroyAll($request);
    }
}
