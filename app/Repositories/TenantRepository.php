<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Tenant;

class TenantRepository
{
    use FileHandler, RelationshipTrait, ApiReturnFormatTrait;

    protected Tenant $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function index()
    {
        return $this->tenant->query()->with('status')->where('company_id', $this->companyInformation()->id)->get();
    }

    public function store($request)
    {
    
        $this->tenant->query()->create($request->all());
        return true;
    }

    public function update($request)
    {
        $tenant = $this->tenant->where('id', $request->tenant_id)->first();
        $tenant->title = $request->title;
        $tenant->description = $request->description;
        $tenant->start_date = $request->start_date;
        $tenant->end_date = $request->end_date;
        $tenant->status_id = $request->status_id;
        $tenant->save();
        return true;
    }

    public function delete($model): bool
    {
        $model->delete();
        return true;
    }


    // new functions
    function fields()
    {
        return [
            _trans('common.ID'),
            _trans('common.Name'),
            _trans('common.Data'),
            _trans('common.Status'),
            _trans('common.Action'),
        ];
    }

    function table($request)
    {
        
        // Log::info($request);
        $data = $this->tenant->query()->where('company_id', $this->companyInformation()->id);

        if ($request->search) {
            $data = $data->where('name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('id', 'DESC')->paginate($request->limit ?? 2);
        return [
            'data' => $data->map(function ($data) {
                $action_button = '';
                if (hasPermission('tenant_read')) {
                    $action_button .= '<a href="' . route('holidaySetup.show', $data->id) . '" class="dropdown-item"> ' . _trans('common.Edit') . '</a>';
                }
                if (hasPermission('holiday_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`hrm/holiday/setup/delete/`)', 'delete');
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
                    'id'         => $data->id,
                    'title'       => ucfirst($data->title),
                    'description' => Str::limit($data->description, 20),
                    'file'       => $data->attachment_id ? '<a href="' . uploaded_asset($data->attachment_id) . '" download class="btn btn-white btn-sm"><i class="fas fa-download"></i></a>' : _trans('common.No File'),
                    'start_date' => showDate($data->start_date),
                    'end_date' => showDate($data->end_date),
                    'status'     => '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>',
                    'action'     => $button
                ];
            }),
            'pagination' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
                'pagination_html' =>  $data->links('backend.pagination.custom')->toHtml(),
            ],
        ];
    }

    public function destroyAll($request)
    {
        try {
            if (@$request->ids) {
                $tenants = $this->tenant->where('company_id', 1)->whereIn('id', $request->ids)->delete();
                return $this->responseWithSuccess(_trans('message.Holiday delete successfully.'), $tenants);
            }else {
                return $this->responseWithError(_trans('message.Holiday not found'), [], 400);                
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }

    }
}
