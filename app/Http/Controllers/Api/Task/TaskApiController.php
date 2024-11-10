<?php

namespace App\Http\Controllers\Api\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Api\V1\HrmAppRepository;
class TaskApiController extends Controller
{
    use ApiReturnFormatTrait;
    protected $appSettings;
 
    public function __construct(HrmAppRepository $appSettingsRepository)
    {
        $this->appSettings = $appSettingsRepository;
    }

    public function AppTaskScreen(Request $request)
    {
        return $this->appSettings->GetAppTaskScreen($request);
    }
    public function AppTaskChangeStatus(Request $request)
    {
        return $this->appSettings->AppTaskChangeStatus($request);
    }
    public function AppTaskDelete(Request $request)
    {
        return $this->appSettings->AppTaskDelete($request);
    }
    public function AppTaskList(Request $request)
    {
        return $this->appSettings->AppTaskList($request);
    }
    public function AppTaskCreate(Request $request)
    {
        return $this->appSettings->AppTaskCreate($request);
    }
    public function AppTaskDetails(Request $request, $task_id)
    {
        return $this->appSettings->AppTaskDetails($request, $task_id);
    }
    public function AppTaskStore(Request $request)
    {
        return $this->appSettings->AppTaskStore($request);
    }
    public function AppTaskUpdate(Request $request)
    {
        return $this->appSettings->AppTaskUpdate($request);
    }
    public function AppTaskStoreComment(Request $request)
    {
        return $this->appSettings->AppTaskStoreComment($request);
    }
    public function AppTaskDeleteComment(Request $request, $id)
    {
        return $this->appSettings->AppTaskDeleteComment($id);
    }
    public function AppTaskUpdateComment(Request $request)
    {
        return $this->appSettings->AppTaskUpdateComment($request);
    }
    public function AppTaskLikeFeedback(Request $request)
    {
        return $this->appSettings->AppTaskLikeFeedback($request);
    }

}
