<?php

namespace App\Services\Request;

use App\Models\User;
use App\Services\Core\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\UserDocumentRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\CurrencyTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\InvoiceGenerateTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class RequestService extends BaseService
{
    use RelationshipTrait, DateHandler, FileHandler, InvoiceGenerateTrait, CurrencyTrait, ApiReturnFormatTrait;

    public function __construct(UserDocumentRequest $request)
    {
        //request::call 6
        $this->model = $request;
    }

    public function fields()
    {
        // SELECT `id`, `user_id`, `request_type`, `request_description`, `approved`, `request_date`, `created_at`, `updated_at`, `branch_id` FROM `user_document_requests` WHERE 1
        return [
            _trans('common.ID'),
            _trans('common.Type'),
            _trans('common.Description'),
            _trans('common.Date'),
            _trans('common.Status'),
            // _trans('common.Action'),

        ];
    }

    public function userDatatable($request, $user_id)
    {
        $request = $this->model->with('user', 'status', 'type')->where(['company_id' => 1]);

        $request = $request->where('user_id', $user_id)->paginate($request->limit ?? 10);

        return $this->generateDatatable($request);
    }
    public function table($request)
    {
        /*
         * Example of an incoming $request object:
         * $request->input('page');
         * $request->input('from');
         * $request->input('to');
         * $request->input('user_id');
         * $request->input('limit');
         */

        try {
            $query = $this->model->with('user', 'status')->where(['company_id' => 1]);
         

            if (!is_Admin()) {
                $query = $query->whereHas('user', function (Builder $query) {
                    $query->where('user_id', auth()->user()->id);
                });
            }

            if ($request->input('user_id')) {
                $query = $query->where('user_id', $request->input('user_id'));
            }

            if ($request->input('from') && $request->input('to')) {
                $query = $query->whereBetween('created_at', start_end_datetime($request->input('from'), $request->input('to')));
            }

            $query = $query->orderBy('created_at', 'DESC')->paginate($request->input('limit', 10));

            return $this->generateDatatable($query);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function generateDatatable($request)
    {
        // _trans('common.ID'),
        // _trans('common.Type'),
        // _trans('common.Description'),
        // _trans('common.Date'),
        // _trans('common.Status'),
        // _trans('common.Action'),
        // SELECT `id`, `user_id`, `request_type`, `request_description`, `approved`, `request_date`, `created_at`, `updated_at`, `branch_id` FROM `user_document_requests` WHERE 1
        return [
            'data' => $request->map(function ($data) {
                $action_button = '';
                    // $action_button .= '<a href="' . route('request.edit', [$data->id]) . '" class="dropdown-item"> ' . _trans('common.Edit') . '</a>';
                    $action_button .= actionButton(_trans('common.Approve'), 'mainModalOpen(`' . route('document.request.approve', $data->id) . '`)', 'modal');
                    // $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/request/delete/`)', 'delete');
                $button = '<div class="dropdown dropdown-action">
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
                    'type' => '<span class="text-muted">' . $data->request_type . '</span>',
                    'description' => '<span class="text-muted">' . $data->request_description . '</span>',
                    'date' => '<span class="text-muted">' . showDate($data->request_date) . '</span>',
                    'status' => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
                    'action' => $button,
                ];
            }),
            'pagination' => [
                'total' => $request->total(),
                'count' => $request->count(),
                'per_page' => $request->perPage(),
                'current_page' => $request->currentPage(),
                'total_pages' => $request->lastPage(),
                'pagination_html' => $request->links('backend.pagination.custom')->toHtml(),
            ],
        ];
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $request = new $this->model;
            $request->user_id = $request->user_id;
            $request->request_type_id = $request->request_type;
            $request->purpose = $request->motive;
            $request->place = $request->place;
            $request->start_date = $request->start_date;
            $request->end_date = $request->end_date;
            $request->mode = $request->mode;
            $request->expect_amount = $request->expect_amount;
            $request->description = $request->content;
            $request->amount = $request->actual_amount;
            $request->status_id = 2;
            $request->company_id = 1;
            $request->created_by = auth()->id();
            if ($request->hasFile('attachment')) {
                $request->attachment = $this->uploadImage($request->attachment, 'request/files')->id;
            }
            $request->save();
            DB::commit();

            return $this->responseWithSuccess(_trans('message.Request created successfully.'), $request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }



    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $request = $this->model->find($id);
            $request->user_id = $request->user_id;
            $request->request_type_id = $request->request_type;
            $request->purpose = $request->motive;
            $request->place = $request->place;
            $request->start_date = $request->start_date;
            $request->end_date = $request->end_date;
            $request->mode = $request->mode;
            $request->expect_amount = $request->expect_amount;
            $request->description = $request->content;
            $request->amount = $request->actual_amount;
            $request->goal_id = @$request->goal_id;
            if ($request->hasFile('attachment')) {
                $this->deleteImage(asset_path($request->attachment));
                $request->attachment = $this->uploadImage($request->attachment, 'request/files')->id;
            }
            $request->save();
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Request Updated successfully.'), $request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    public function delete($id)
    {
        $request = $this->model->where(['id' => $id, 'company_id' => 1])->first();
        if (!$request) {
            return $this->responseWithError(_trans('message.Request not found'), 'id', 404);
        }
        try {
            if (@$request->attachment) {
                $this->deleteImage(asset_path($request->attachment));
            }
            $request->delete();
            return $this->responseWithSuccess(_trans('message.Request Delete successfully.'), $request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    public function approve($request, $id)
    {
        $request = $this->model->where(['id' => $id, 'company_id' => 1])->first();
        if (!$request) {
            return $this->responseWithError(_trans('message.Request not found'), 'id', 404);
        }
        try {
            $request->status_id = $request->status;
            $request->save();
            return $this->responseWithSuccess(_trans('message.Request Approved successfully.'), $request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    // statusUpdate
    public function statusUpdate($request)
    {
        try {
            // Log::info($request->all());
            if (@$request->action == 'active') {
                $request = $this->model->where('company_id', 1)->whereIn('id', $request->ids)->update(['status_id' => 1]);
                return $this->responseWithSuccess(_trans('message.Request activate successfully.'), $request);
            }
            if (@$request->action == 'inactive') {
                $request = $this->model->where('company_id', 1)->whereIn('id', $request->ids)->update(['status_id' => 4]);
                return $this->responseWithSuccess(_trans('message.Request inactivate successfully.'), $request);
            }
            return $this->responseWithError(_trans('message.Request failed'), [], 400);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroyAll($request)
    {
        try {
            if (@$request->ids) {
                $requests = $this->model->where('company_id', 1)->whereIn('id', $request->ids)->get();
                foreach ($requests as $request) {
                    if (@$request->attachment) {
                        $this->deleteImage(asset_path($request->attachment));
                    }
                    $request->delete();
                }
                return $this->responseWithSuccess(_trans('message.Request delete successfully.'), $requests);
            } else {
                return $this->responseWithError(_trans('message.Request not found'), [], 400);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
