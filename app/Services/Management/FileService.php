<?php

namespace App\Services\Management;

use App\Services\Core\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Management\ProjectFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\CurrencyTrait;
use App\Models\Management\ProjectFileComment;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\InvoiceGenerateTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class FileService extends BaseService
{
    use RelationshipTrait, DateHandler, FileHandler, InvoiceGenerateTrait, CurrencyTrait, ApiReturnFormatTrait;

    public function __construct(ProjectFile $projectFile)
    {
        $this->model = $projectFile;
    }


    public function store($request)
    {

        if(pathinfo($request->attach_file->getClientOriginalName(), PATHINFO_EXTENSION) =='sql'){
            $validator = Validator::make(\request()->all(), [
                'subject' => 'required',
                'attach_file' => 'required|max:20048',
            ]);
        }else {
            $validator = Validator::make(\request()->all(), [
                'subject' => 'required',
                'attach_file' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf,csv,doc,docx,zip,rar,xls,xlsx,ppt,pptx,sql|max:20048',
            ]);
        }


        if ($validator->fails()) {
            return $this->responseWithError(_trans('message.Required file are missing'), 'id', 404);
        }
        DB::beginTransaction();
        try {
            $project = DB::table('projects')->where('id', $request->project_id)->first();
            if (!$project) {
                return $this->responseWithError(__('Project not found'), [], 400);
            }

            $project_files = new $this->model;
            $project_files->company_id = 1;
            $project_files->project_id = $request->project_id;
            $project_files->subject = $request->subject;
            $project_files->user_id = auth()->user()->id;
            $project_files->show_to_customer = @$request->show_to_customer == 1  ? 33 : 22;
            $project_files->last_activity = date('Y-m-d H:i:s');
            if ($request->hasFile('attach_file')) {
                $project_files->attachment = $this->uploadImage($request->attach_file, 'project/files')->id;
            }
            $project_files->save();

            \App\Models\Management\ProjectActivity::CreateActivityLog(1, $request->project_id, auth()->id(), 'Created File')->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Project file created successfully.'), $project_files);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    function table($request, $id)
    {
        $files =  $this->model->where([
            'project_id' => $id,
            'company_id' => 1,
        ])->with('comments');
        if ($request->search) {
            $files = $files->where('subject', 'like', '%' . $request->search . '%');
        }
        if ($request->from && $request->to) {
            $files = $files->whereBetween('created_at', start_end_datetime($request->from, $request->to));
        }
        $files = $files->paginate($request->limit ?? 10);

        return [
            'data' => $files->map(function ($data) {
                $action_button = '';
                if (hasPermission('project_file_view')) {
                    $action_button .= '<a href="' . route('project.view', [$data->project_id, 'files', 'file_id=' . $data->id]) . '" class="dropdown-item"> ' . _trans('common.View') . '</a>';
                }
                if (hasPermission('project_file_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/project/file/delete/`)', 'delete');
                }
                $button = ' <div class="dropdown dropdown-action">
                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                ' . $action_button . '
                                </ul>
                            </div>';

                return [
                    'id' => $data->id,
                    'subject' => $data->subject,
                    'date' => showDate($data->created_at),
                    'last_activity' => showDate($data->last_activity),
                    'comments' => $data->comments->count(),
                    'action'   => $button
                ];
            }),
            'pagination' => [
                'total' => $files->total(),
                'count' => $files->count(),
                'per_page' => $files->perPage(),
                'current_page' => $files->currentPage(),
                'total_pages' => $files->lastPage(),
                'pagination_html' =>  $files->links('backend.pagination.custom')->toHtml(),
            ],
        ];

       
    }

    // comment store the
    public function commentStore($request)
    {
        // Log::info($request->all());

        $validator = Validator::make(\request()->all(), [
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 400);
        }
        DB::beginTransaction();
        try {
            $project_file = $this->model->where([
                'id' => $request->file_id,
                'company_id' => 1,
            ])->first();
            if (!$project_file) {
                return $this->responseWithError(__('File not found'), [], 400);
            }

            if ($request->comment_id == 0 || $request->comment_id == null) {
                $comment_id = null;
            }else {
                $comment_id = $request->comment_id;
            }

            $comment = new ProjectFileComment();
            $comment->company_id = 1;
            $comment->project_file_id = $request->file_id;
            $comment->comment_id = $comment_id ?? null;
            $comment->description = $request->comment;
            $comment->user_id = auth()->user()->id;
            $comment->save();
            \App\Models\Management\ProjectActivity::CreateActivityLog(1, $project_file->project_id, auth()->id(), 'Created File Comments')->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Comment created successfully.'), $comment);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    function delete($id)
    {
        $file = $this->model->where(['id' => $id, 'company_id' => 1])->first();
        if (!$file) {
            return $this->responseWithError(_trans('message.File not found'), 'id', 404);
        }
        try {
            if (@$file->attachment) {
                $this->deleteImage(asset_path($file->attachment));
            }
            $file->comments()->delete();
            $file->delete();            
            \App\Models\Management\ProjectActivity::CreateActivityLog(1, $file->project_id, auth()->id(), 'Deleted File')->save();
            return $this->responseWithSuccess(_trans('message.File Delete successfully.'), $file);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroyAll($request)
    {
        try {
            if (@$request->ids) {
                $category = $this->model->where('company_id', 1)->whereIn('id', $request->ids)->get();
                foreach ($category as $file){
                    if (@$file->attachment) {
                        $this->deleteImage(asset_path($file->attachment));
                    }
                    $file->comments()->delete();
                    $file->delete(); 
                }
                return $this->responseWithSuccess(_trans('message.Project File delete successfully.'), $category);
            } else {
                return $this->responseWithError(_trans('message.Project File not found'), [], 400);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
