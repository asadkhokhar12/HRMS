<?php

namespace Modules\MultiBranch\Repositories;

use App\Models\Branch;
use App\Models\Role\Role;
use Illuminate\Support\Str;
use App\Services\Hrm\DeleteService;
use App\Models\Traits\RelationCheck;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Permission\Permission;

use Illuminate\Support\Facades\Cache;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class BranchRepository
{
    use AuthorInfoTrait, RelationshipTrait, RelationCheck, ApiReturnFormatTrait;

    protected $branch;

    public function __construct(Branch $branch)
    {
        $this->branch = $branch;
    }

    public function get($id)
    {
        return $this->branch->query()->where('company_id', $this->companyInformation()->id)->findOrFail($id);
    }

    public function getAll()
    {
        return $this->branch->query()->where('company_id', $this->companyInformation()->id)->where('status_id', 1)->get();
    }

    public function getPermission()
    {
        return Permission::get();
    }

    public function index()
    {
        // TODO: Implement index() method.
    }

  
    // public function store($request)
    // {
    //     $request['slug'] = Str::slug($request->name, '-');
    //     $this->role->query()->create($request->all());
    // }

    // public function show($id)
    // {
    //     return $this->role->query()->find($id);
    // }

    public function update($request,$branch)
    {
        $branch = $this->branch->where(['id' => $branch->id, 'company_id' => $branch->company_id])->first();
        if (!$branch) {
            return $this->responseWithError(_trans('message.Data not found'), 'id', 404);
        }
        try {
            $branch->name = $request->name;
            $branch->phone = $request->phone;
            $branch->email = $request->email;
            $branch->address = $request->address;
            $branch->status_id = $request->status;
            $branch->save();
            $this->updatedBy($branch);
            return $this->responseWithSuccess(_trans('message.Branch Update successfully.'), $branch);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try{
            $branch = $this->branch->where(['id' => $id, 'company_id' => 1])->first();
            $branch->delete();
            return $this->responseWithSuccess(_trans('message.Branch Delete successfully.'), $branch);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }


    // new functions

    function fields()
    {
        return [
            _trans('common.ID'),
            _trans('common.Name'),
            _trans('common.Phone'),
            _trans('common.Email'),
            _trans('common.Address'),
            _trans('common.Status'),
            _trans('common.Action')

        ];
    }


    // data table functions
    function table($request)
    {
        $data =  $this->branch->query()->with('status')
            ->where('company_id', 1)
            ->where('name','!=','Head Office');
        $where = array();
        if ($request->search) {
            $where[] = ['name', 'like', '%' . $request->search . '%'];
        }
        $data = $data
            ->where($where)
            ->orderBy('id', 'DESC')
            ->paginate($request->limit ?? 2);
        return [
            'data' => $data->map(function ($data) {
                $action_button = '';
                    if (hasPermission('branch_update')) {
                        // $action_button .= '<a href="' . route('branches.edit', $data->id) . '" class="dropdown-item"> ' . _trans('common.Edit') . '</a>';
                        $action_button .= actionButton(_trans('common.Edit'), 'mainModalOpen(`' . route('branches.edit', $data->id) . '`)', 'modal');
                    }
                    if (hasPermission('branch_delete')) {
                        $action_button .= actionButton(_trans('common.Delete'), '__globalDelete(' . $data->id . ',`branches/delete/`)', 'delete');
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
                    'name' => $data->name,
                    'phone' => $data->phone,
                    'email' => $data->email,
                    'address' => $data->address,
                    'status' => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
                    'action'   => $button
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

    // statusUpdate
    public function statusUpdate($request)
    {
        try {
            // Log::info($request->all());
            if (@$request->action == 'active') {
                $branch = $this->branch->where('company_id', 1)->whereIn('id', $request->ids)->update(['status_id' => 1]);
                return $this->responseWithSuccess(_trans('message.Branch activate successfully.'), $branch);
            }
            if (@$request->action == 'inactive') {
                $branch = $this->branch->where('company_id', 1)->whereIn('id', $request->ids)->update(['status_id' => 4]);
                return $this->responseWithSuccess(_trans('message.Branch inactivate successfully.'), $branch);
            }
            return $this->responseWithError(_trans('message.branch inactivate failed'), [], 400);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }


    public function destroyAll($request)
    {
        try {
            if (@$request->ids) {
                $branch = $this->branch->where('company_id', 1)->whereIn('id', $request->ids)->update(['deleted_at' => now()]);
                return $this->responseWithSuccess(_trans('message.Branch activate successfully.'), $branch);
            } else {
                return $this->responseWithError(_trans('message.Branch not found'), [], 400);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    //new functions

    function createAttributes()
    {
        return [
            'name' => [
                'field' => 'input',
                'type' => 'text',
                'required' => true,
                'id'    => 'name',
                'class' => 'form-control ot-form-control ot-input',
                'col'   => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Name')
            ],
            'phone' => [
                'field' => 'input',
                'type' => 'text',
                'required' => true,
                'id'    => 'phone',
                'class' => 'form-control ot-form-control ot-input',
                'col'   => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Phone')
            ],
            'email' => [
                'field' => 'input',
                'type' => 'text',
                'required' => true,
                'id'    => 'email',
                'class' => 'form-control ot-form-control ot-input',
                'col'   => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Email')
            ],
            'address' => [
                'field' => 'input',
                'type' => 'text',
                'required' => true,
                'id'    => 'address',
                'class' => 'form-control ot-form-control ot-input',
                'col'   => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Address')
            ],
            'status' => [
                'field' => 'select',
                'type' => 'select',
                'required' => true,
                'id'    => 'status',
                'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                'col' => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Status'),
                'options' => [
                    [
                        'text' => _trans('payroll.Active'),
                        'value'  => 1,
                        'active' => true,
                    ],
                    [
                        'text' => _trans('payroll.Inactive'),
                        'value'  => 4,
                        'active' => false,
                    ]
                ]
            ]

        ];
    }
    function editAttributes($branchModel)
    {
        return [
            'name' => [
                'field' => 'input',
                'type' => 'text',
                'required' => true,
                'id'    => 'name',
                'class' => 'form-control ot-form-control ot-input',
                'col'   => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Name'),
                'value' => $branchModel->name
            ],
            'phone' => [
                'field' => 'input',
                'type' => 'text',
                'required' => true,
                'id'    => 'phone',
                'class' => 'form-control ot-form-control ot-input',
                'col'   => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Phone'),
                'value' => $branchModel->phone
            ],
            'email' => [
                'field' => 'input',
                'type' => 'text',
                'required' => true,
                'id'    => 'email',
                'class' => 'form-control ot-form-control ot-input',
                'col'   => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Email'),
                'value' => $branchModel->email
            ],
            'address' => [
                'field' => 'input',
                'type' => 'text',
                'required' => true,
                'id'    => 'address',
                'class' => 'form-control ot-form-control ot-input',
                'col'   => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Address'),
                'value' => $branchModel->address
            ],
            'status' => [
                'field' => 'select',
                'type' => 'select',
                'required' => true,
                'id'    => 'status',
                'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                'col' => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Status'),
                'options' => [
                    [
                        'text' => _trans('payroll.Active'),
                        'value'  => 1,
                        'active' => $branchModel->status_id == 1 ? true : false,
                    ],
                    [
                        'text' => _trans('payroll.Inactive'),
                        'value'  => 4,
                        'active' => $branchModel->status_id == 4 ? true : false,
                    ]
                ]
            ]

        ];
    }


    function newStore($request)
    {
        try {
            if ($this->isExistsWhenStore($this->branch, 'name', $request->name)) {
                $branch = new $this->branch;
                $branch->name = $request->name;
                $branch->phone = $request->phone;
                $branch->email = $request->email;
                $branch->address = $request->address;
                $branch->status_id = $request->status;
                $branch->company_id = 1;
                $branch->save();
                $this->createdBy($branch);
                return $this->responseWithSuccess(_trans('message.Branch Created successfully.'), 200);
            } else {
                return $this->responseWithError(_trans('message.Data already exists'), [], 400);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
