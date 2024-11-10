<?php

namespace App\Repositories\Hrm\Leave;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Hrm\Leave\LeaveType;
use App\Models\Hrm\Leave\LeaveYear;
use Illuminate\Support\Facades\Log;
use App\Models\Hrm\Leave\AssignLeave;
use App\Models\Hrm\Department\Department;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class AssignLeaveRepository
{
    use RelationshipTrait, ApiReturnFormatTrait;

    protected AssignLeave $assignLeave;
    protected LeaveYear $leaveYear;

    public function __construct(AssignLeave $assignLeave, LeaveYear $leaveYear)
    {
        $this->assignLeave  = $assignLeave;
        $this->leaveYear    = $leaveYear;
    }

    public function index()
    {
    }

    public function dataTable($request, $id = null)
    {
        $assignLeave = $this->assignLeave->query()->where('company_id', $this->companyInformation()->id);
        if (@$request->department_id) {
            $assignLeave = $assignLeave->where('department_id', $request->department_id);
        }
        if (@$id) {
            $assignLeave = $assignLeave->where('id', $id);
        }

        return datatables()->of($assignLeave->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                if (hasPermission('leave_assign_update')) {
                    $action_button .= '<a href="' . route('assignLeave.edit', $data->id) . '" class="dropdown-item"> ' . $edit . '</a>';
                }
                if (hasPermission('leave_assign_delete')) {
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/leave/assign/delete/`)', 'delete');
                }
                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';
                return $button;
            })
            ->addColumn('days', function ($data) {
                return @$data->days;
            })
            ->addColumn('department', function ($data) {
                return @$data->department->title;
            })
            ->addColumn('type', function ($data) {
                return @$data->type->name;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('days', 'department', 'type', 'status', 'action'))
            ->make(true);
    }

    public function store($request)
    {
        try {
            if(settings('leave_assign')==1){  // employee
                if ($this->isExistsWhenStoreMultipleColumn($this->assignLeave, 'user_id', 'type_id', $request->user_id, $request->type_id)) {
                    
                    $assign_leave = new $this->assignLeave;
                    $assign_leave->days = $request->days;
                    $assign_leave->type_id = $request->type_id;
                    $assign_leave->user_id = $request->user_id;
                    $assign_leave->company_id = auth()->user()->company_id;
                    $assign_leave->status_id = $request->status_id;
                    $assign_leave->save();

                    // Leave year (employee)
                    if (settings('leave_carryover')) { 
                        $leave_year = new $this->leaveYear;
                        $leave_year->type_id            = $request->type_id;
                        $leave_year->user_id            = $request->user_id;
                       // $leave_year->department_id	    = $request->department_id;
                        $leave_year->leave_days         = $request->days;
                        $leave_year->leave_available    = $request->days;
                        $leave_year->leave_used         = 0;
                        $leave_year->year               = now()->format('Y');
                        $leave_year->status_id          = 1;
                        $leave_year->save();
                    }

                    return $this->responseWithSuccess(_trans('message.Assign leave store successfully.'), 200);
                } else {
                    return $this->responseWithError(_trans('message.Data already exists'), [], 400);
                }
            } else{
                if ($this->isExistsWhenStoreMultipleColumn($this->assignLeave, 'department_id', 'type_id', $request->department_id, $request->type_id)) {
                    $assign_leave = new $this->assignLeave;
                    $assign_leave->days = $request->days;
                    $assign_leave->type_id = $request->type_id;
                    $assign_leave->department_id = $request->department_id;
                    $assign_leave->company_id = auth()->user()->company_id;
                    $assign_leave->status_id = $request->status_id;
                    $assign_leave->save();

                    // Leave year (department)
                    if (settings('leave_carryover')) { 
                        $leave_year = new $this->leaveYear;
                        $leave_year->type_id            = $request->type_id;
                        $leave_year->department_id	    = $request->department_id;
                        $leave_year->leave_days         = $request->days;
                        $leave_year->leave_available    = $request->days;
                        $leave_year->leave_used         = 0;
                        $leave_year->year               = now()->format('Y');
                        $leave_year->status_id          = 1;
                        $leave_year->save();
                    }

                    return $this->responseWithSuccess(_trans('message.Assign leave store successfully.'), 200);
                } else {
                    return $this->responseWithError(_trans('message.Data already exists'), [], 400);
                }
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function show($id): object
    {
        return $this->assignLeave->query()->find($id);
    }

    public function pre_update($request, $id)
    {
        $assignLeaveModel = $this->assignLeave->where('company_id', auth()->user()->company_id)->where('id', $id)->first();
        // $assign_leave = $assignLeaveModel;
        if (!empty($assignLeaveModel)) {
            $assignLeaveModel->days = $request->days;
            $assignLeaveModel->type_id = $request->type_id;
            $assignLeaveModel->department_id = $request->department_id;
            $assignLeaveModel->status_id = $request->status_id;
            $assignLeaveModel->save();
            return $this->responseWithSuccess(_trans('message.Assign leave update successfully.'), 200);
        }
        return $this->responseWithSuccess(_trans('message.Assign leave does not update successfully.'), 400);
    }
    public function update($request, $id)
    {
        try {
            $assignLeaveModel = $this->assignLeave->where('company_id', auth()->user()->company_id)->where('id', $id)->first();
            if (!empty($assignLeaveModel)) {
                $oldTypeID = $assignLeaveModel->type_id;
                if(settings('leave_assign')==1){  // employee
                    if ($this->isExistsWhenUpdateMultipleColumn($assignLeaveModel, $id, 'user_id', 'type_id', $assignLeaveModel->user_id, $request->type_id)) {
                        
                    
                        $assign_leave = $assignLeaveModel;
                        $assign_leave->days = $request->days;
                        $assign_leave->type_id = $request->type_id;
                        $assign_leave->status_id = $request->status_id;
                        $assign_leave->save();

                        // Leave year (employee)
                        if (settings('leave_carryover')) { 
                            $leaveYearData = $this->leaveYear->where(['type_id' => $oldTypeID, 'user_id' => $assignLeaveModel->user_id, 'year' => now()->format('Y'), 'company_id'=> auth()->user()->company_id])->first();
                            $leaveYearData->type_id             = $request->type_id;
                            $leaveYearData->leave_days          = $request->days;
                            $leaveYearData->leave_available     = $request->days - $leaveYearData->leave_used;
                            $leaveYearData->save();
                        }
                        return $this->responseWithSuccess(_trans('message.Assign leave update successfully.'), 200);
                    } else {
                        return $this->responseWithError(_trans('message.Data already exists'), [], 400);
                    }
                } else{
                    if ($this->isExistsWhenUpdateMultipleColumn($assignLeaveModel, $id, 'department_id', 'type_id', $request->department_id, $request->type_id)) {
                        $assign_leave = $assignLeaveModel;
                        $assign_leave->days = $request->days;
                        $assign_leave->type_id = $request->type_id;
                        $assign_leave->department_id = $request->department_id;
                        $assign_leave->status_id = $request->status_id;
                        $assign_leave->save();

                        // Leave year (department)
                        if (settings('leave_carryover')) { 
                            $leaveYearData = $this->leaveYear->where(['type_id' => $oldTypeID, 'department_id' => $request->department_id, 'year' => now()->format('Y'), 'company_id'=> auth()->user()->company_id])->first();
                            $leaveYearData->type_id             = $request->type_id;
                            $leaveYearData->leave_days          = $request->days;
                            $leaveYearData->leave_available     = $request->days - $leaveYearData->leave_used;
                            $leaveYearData->save();
                        }
                        return $this->responseWithSuccess(_trans('message.Assign leave update successfully.'), 200);
                     } else {
                         return $this->responseWithError(_trans('message.Data already exists'), [], 400);
                     }
                }
            }else{
                return $this->responseWithError(_trans('message.Company not found'),[], 400);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        $table_name = $this->assignLeave->getTable();
        $foreign_id = \Illuminate\Support\Str::singular($table_name) . '_id';

        if(settings('leave_carryover')){
            $leave = $this->assignLeave->where('id', $id)->first();
            if(settings('leave_assign')==1){  // employee
                $this->leaveYear->where(['type_id' => $leave->type_id, 'user_id' => $leave->user_id])->delete();
            } else{
                $this->leaveYear->where(['type_id' => $leave->type_id, 'department_id' => $leave->department_id])->delete();
            }
        }
        return \App\Services\Hrm\DeleteService::deleteData($table_name, $foreign_id, $id);
    }



    // new functions 

    function fields()
    {
         // employee
        if(settings('leave_assign')==1){
            return [
                _trans('common.ID'),
                _trans('common.Employee'),
                _trans('common.Type'),
                _trans('common.Days'),
                _trans('common.Status'),
                _trans('common.Action')
            ];
        }else{
            return [
                _trans('common.ID'),
                _trans('common.Department'),
                _trans('common.Type'),
                _trans('common.Days'),
                _trans('common.Status'),
                _trans('common.Action')
            ];
        }
    }

    function table($request)
    {
        Log::info($request->all());
        $data =  $this->assignLeave->query()->where('company_id', auth()->user()->company_id);

        // leave assign 1 = employee
        if(settings('leave_assign')==1){
            $data = $data->where('user_id', '!=', null);
        } else{
            $data = $data->where('department_id', '!=', null);
        }

        if (@$request->department_id) {
            $data = $data->where('department_id', $request->department_id);
        }

        if (@$request->employee_id) {
            $data = $data->where('user_id', $request->employee_id);
        }
        if ($request->search) {
            $data = $data->whereHas('department', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }
        $data = $data->paginate($request->limit ?? 2);
        return [
            'data' => $data->map(function ($data) {
                $action_button = '';
                if(settings('leave_carryover')){
                    $action_button .= '<a href="' . route('assignLeave.leave_summery', $data->id) . '" class="dropdown-item"> ' ._trans('common.Annual leave summary') . '</a>';
                }
                if (hasPermission('leave_assign_update')) {
                    $action_button .= actionButton(_trans('common.Edit'), 'mainModalOpen(`' . route('assignLeave.edit', $data->id) . '`)', 'modal');
                }
                if (hasPermission('leave_assign_delete')) {
                    $action_button .= actionButton(_trans('common.Delete'), '__globalDelete(' . $data->id . ',`hrm/leave/assign/delete/`)', 'delete');
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
                $leave_assign_for= settings('leave_assign')== 1 ? $data->user? @$data->user->name : '...' : $data->department->title;

                return [
                    'id'         => $data->id,
                    'days'       => $data->days,
                    'department' => @$leave_assign_for,
                    'type'       => @$data->type->name,
                    'status'     => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
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

    // annual leave summery
    public function leaveSummaryFields(){
        return [
            _trans('common.ID'),
            _trans('common.Department'),
            _trans('common.Type'),
            _trans('common.Leave Days'),
            _trans('common.Leave Available'),
            _trans('common.Leave Used'),
            _trans('common.Year'),
            _trans('common.Action')
        ];
    }

    function leaveSummaryTable($request, $id)
    {
        //dd($request);
        Log::info($request->all());
        $data =  $this->leaveYear->query()->where(['company_id' => auth()->user()->company_id, 'type_id' => $request->leave_type])->latest();

        // leave assign 1 = employee
        if(settings('leave_assign')==1){
            $data = $data->where('user_id', '!=', null);
        } else{
            $data = $data->where('department_id', '!=', null);
        }

        if (@$request->department_id) {
            $data = $data->where('department_id', $request->department_id);
        }

        if (@$request->employee_id) {
            $data = $data->where('user_id', $request->employee_id);
        }
        
        $data = $data->paginate($request->limit ?? 2);
        return [
            'data' => $data->map(function ($data) {
                $action_button = '';
                if (hasPermission('leave_assign_update')) {
                    $action_button .= actionButton(_trans('common.Carryover Leave'), 'mainModalOpen(`' . route('assignLeave.transfer.add', $data->id) . '`)', 'modal');
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
                $leave_assign_for= settings('leave_assign')== 1 ? $data->user? @$data->user->name : '...' : $data->department->title;
                return [
                    'id'                => $data->id,
                    'department'        => @$leave_assign_for,
                    'type'              => @$data->type->name,
                    'leave_days'        => @$data->leave_days,
                    'leave_available'   => @$data->leave_available,
                    'leave_used'        => @$data->leave_used,
                    'year'              => $data->year,
                    'action'            => $button
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

    public function updateAnnualLeaveCount($request, $days){
        $update = $this->leaveYear->where(['type_id' => $request->type_id, 'user_id' => $request->user_id, 'year' => now()->format('Y'), 'company_id'=> auth()->user()->company_id])->first();
        if($update) {
            $update->leave_available    = $update->leave_available - $days;
            $update->leave_used         = $update->leave_used + $days;
            $update->save();
        }
    }

    function editLeaveSummaryAttributes($updateModel)
    {
        return [
            'year_from' => [
                'field' => 'select',
                'type' => 'select',
                'required' => true,
                'id'    => 'year_from',
                'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                'col' => 'col-md-12 form-group mb-3 ',
                'label' => _trans('common.Year From'),
                'options' => DB::table('leave_years')->where(['company_id' => auth()->user()->company_id, 'type_id' => @$updateModel->type_id, 'user_id' => @$updateModel->user_id])->get()->map(function ($data) use ($updateModel) {
                    return [
                        'text' => $data->year,
                        'value' => $data->year,
                    ];
                })->toArray()
            ],
            'year_to' => [
                'field' => 'input',
                'type' => 'text',
                'required' => true,
                'id'    => 'year_to',
                'class' => 'form-control ot-form-control ot-input',
                'col' => 'col-md-12 form-group mb-3 ',
                'label' => _trans('common.Year To'),
                'value' => @$updateModel->year,
                'readonly' => true,
            ],
            'days' => [
                'field' => 'input',
                'type' => 'number',
                'required' => true,
                'id'    => 'days',
                'class' => 'form-control ot-form-control ot-input',
                'col'   => 'col-md-12 form-group mb-3',
                'value' => @$updateModel->days,
                'label' => _trans('common.Carryover days'),
            ],
        ];
    }

    public function updateLeaveSummary($request, $id)
    {
        try {
            DB::beginTransaction();
            $leaveYearData = $this->leaveYear->where('id', $id)->first();

            $transferred = $this->leaveYear->where(['type_id' => $leaveYearData->type_id, 'user_id' => $leaveYearData->user_id, 'year' => $request->year_from,  'company_id'=> auth()->user()->company_id])->first();
            
            if ($request->days === "") {
                return $this->responseWithError(_trans('message.Enter days'), [], 400);
            }
            if(@$transferred && $transferred->leave_available < $request->days){
                return $this->responseWithError(_trans('message.Days are not available for carryover'), [], 400);
            }
            if($request->year_to === $request->year_from){
                return $this->responseWithError(_trans('message.Same year is not allowed'), [], 400);
            }
            if (!empty($leaveYearData)) {
                $leaveYearData->leave_days += $request->days;
                $leaveYearData->leave_available += $request->days;
                $leaveYearData->save();

                $transferred->leave_days -= $request->days;
                $transferred->leave_available -= $request->days;
                $transferred->save();

                $assign = $this->assignLeave->where(['type_id' => $leaveYearData->type_id, 'user_id' => $leaveYearData->user_id])->first();
                $assign->days += $request->days;
                $assign->save();
                DB::commit();
                return $this->responseWithSuccess(_trans('message.Leave carryover successfully'),[], 200);
            } else{
                return $this->responseWithError(_trans('message.Leave year not found'),[], 400);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }  
    }

    // annual leave summery end

    // statusUpdate
    public function statusUpdate($request)
    {
        try {
            // Log::info($request->all());
            if (@$request->action == 'active') {
                $assign_leave = $this->assignLeave->where('company_id', auth()->user()->company_id)->whereIn('id', $request->ids)->update(['status_id' => 1]);
                return $this->responseWithSuccess(_trans('message.Leave Assign activate successfully.'), $assign_leave);
            }
            if (@$request->action == 'inactive') {
                $assign_leave = $this->assignLeave->where('company_id', auth()->user()->company_id)->whereIn('id', $request->ids)->update(['status_id' => 4]);
                return $this->responseWithSuccess(_trans('message.Leave Assign inactivate successfully.'), $assign_leave);
            }
            return $this->responseWithError(_trans('message.Leave Assign inactivate failed'), [], 400);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }


    public function destroyAll($request)
    {
        try {
            if (@$request->ids) {
                $assign_leave = $this->assignLeave->where('company_id', auth()->user()->company_id)->whereIn('id', $request->ids)->update(['deleted_at' => now()]);
                return $this->responseWithSuccess(_trans('message.Assign leave delete successfully.'), $assign_leave);
            } else {
                return $this->responseWithError(_trans('message.Assign leave not found'), [], 400);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    function createAttributes()
    {
        return [
            'days' => [
                'field' => 'input',
                'type' => 'number',
                'required' => true,
                'id'    => 'days',
                'class' => 'form-control ot-input ot-form-control',
                'col'   => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Days')
            ],
            'department_id' => [
                'field' => 'select',
                'type' => 'select',
                'required' => true,
                'id'    => 'department_id',
                'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                'col' => 'col-md-12 form-group mb-3 ',
                'label' => _trans('common.Department'),
                'options' => Department::where('company_id', auth()->user()->company_id)->where('status_id', 1)->get()->map(function ($data) {
                    return [
                        'text' => $data->title,
                        'value' => $data->id,
                        'active' => false
                    ];
                })->toArray()
            ],
            'type_id' => [
                'field' => 'select',
                'type' => 'select',
                'required' => true,
                'id'    => 'type_id',
                'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                'col' => 'col-md-12 form-group mb-3 ',
                'label' => _trans('leave.Leave Type'),
                'options' => LeaveType::where('company_id', auth()->user()->company_id)->where('status_id', 1)->get()->map(function ($data) {
                    return [
                        'text' => $data->name,
                        'value' => $data->id,
                        'active' => false
                    ];
                })->toArray()
            ],
            'status_id' => [
                'field' => 'select',
                'type' => 'select',
                'required' => true,
                'id'    => 'status_id',
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
    function createUserAttributes()
    {
        return [
            'days' => [
                'field' => 'input',
                'type' => 'number',
                'required' => true,
                'id'    => 'days',
                'class' => 'form-control ot-input ot-form-control',
                'col'   => 'col-md-12 form-group mb-3',
                'label' => _trans('common.Days')
            ],
            'user_id' => [
                'field' => 'select',
                'type' => 'select',
                'required' => true,
                'id'    => 'user_id',
                'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                'col' => 'col-md-12 form-group mb-3 ',
                'label' => _trans('common.Employee'),
                'options' => User::where('company_id', auth()->user()->company_id)->where('branch_id',userBranch())->where('status_id', 1)->get()->map(function ($data) {
                    return [
                        'text' => $data->name,
                        'value' => $data->id,
                        'active' => false
                    ];
                })->toArray()
            ],
            'type_id' => [
                'field' => 'select',
                'type' => 'select',
                'required' => true,
                'id'    => 'type_id',
                'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                'col' => 'col-md-12 form-group mb-3 ',
                'label' => _trans('leave.Leave Type'),
                'options' => LeaveType::where('company_id', auth()->user()->company_id)->where('status_id', 1)->get()->map(function ($data) {
                    return [
                        'text' => $data->name,
                        'value' => $data->id,
                        'active' => false
                    ];
                })->toArray()
            ],
            'status_id' => [
                'field' => 'select',
                'type' => 'select',
                'required' => true,
                'id'    => 'status_id',
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

    function editAttributes($updateModel)
    {
        if(settings('leave_assign')==0){
            return [
                'days' => [
                    'field' => 'input',
                    'type' => 'number',
                    'required' => true,
                    'id'    => 'days',
                    'class' => 'form-control ot-form-control ot-input',
                    'col'   => 'col-md-12 form-group mb-3',
                    'value' => @$updateModel->days,
                    'label' => _trans('common.Days')
                ],
                'department_id' => [
                    'field' => 'select',
                    'type' => 'select',
                    'required' => true,
                    'id'    => 'department_id',
                    'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                    'col' => 'col-md-12 form-group mb-3 ',
                    'label' => _trans('common.Department'),
                    'options' => DB::table('departments')->where('company_id', auth()->user()->company_id)->where('status_id', 1)->get()->map(function ($data) use ($updateModel) {
                        return [
                            'text' => $data->title,
                            'value' => $data->id,
                            'active' =>  $updateModel->department_id == $data->id ? true : false,
                        ];
                    })->toArray()
                ],
                'type_id' => [
                    'field' => 'select',
                    'type' => 'select',
                    'required' => true,
                    'id'    => 'type_id',
                    'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                    'col' => 'col-md-12 form-group mb-3',
                    'label' => _trans('leave.Leave Type'),
                    'options' => DB::table('leave_types')->where('company_id', auth()->user()->company_id)->where('status_id', 1)->get()->map(function ($data) use ($updateModel) {
                        return [
                            'text' => $data->name,
                            'value' => $data->id,
                            'active' =>  $updateModel->type_id == $data->id ? true : false,
                        ];
                    })->toArray()
                ],
                'status_id' => [
                    'field' => 'select',
                    'type' => 'select',
                    'required' => true,
                    'id'    => 'status_id',
                    'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                    'col' => 'col-md-12 form-group mb-3',
                    'label' => _trans('common.Status'),
                    'options' => [
                        [
                            'text' => _trans('payroll.Active'),
                            'value'  => 1,
                            'active' => $updateModel->status_id == 1 ? true : false,
                        ],
                        [
                            'text' => _trans('payroll.Inactive'),
                            'value'  => 4,
                            'active' => $updateModel->status_id == 4 ? true : false,
                        ]
                    ]
                ]
            ];
        } else{
            return [
                'days' => [
                    'field' => 'input',
                    'type' => 'number',
                    'required' => true,
                    'id'    => 'days',
                    'class' => 'form-control ot-form-control ot-input',
                    'col'   => 'col-md-12 form-group mb-3',
                    'value' => @$updateModel->days,
                    'label' => _trans('common.Days')
                ],
                'type_id' => [
                    'field' => 'select',
                    'type' => 'select',
                    'required' => true,
                    'id'    => 'type_id',
                    'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                    'col' => 'col-md-12 form-group mb-3',
                    'label' => _trans('leave.Leave Type'),
                    'options' => DB::table('leave_types')->where('company_id', auth()->user()->company_id)->where('status_id', 1)->get()->map(function ($data) use ($updateModel) {
                        return [
                            'text' => $data->name,
                            'value' => $data->id,
                            'active' =>  $updateModel->type_id == $data->id ? true : false,
                        ];
                    })->toArray()
                ],
                'status_id' => [
                    'field' => 'select',
                    'type' => 'select',
                    'required' => true,
                    'id'    => 'status_id',
                    'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                    'col' => 'col-md-12 form-group mb-3',
                    'label' => _trans('common.Status'),
                    'options' => [
                        [
                            'text' => _trans('payroll.Active'),
                            'value'  => 1,
                            'active' => $updateModel->status_id == 1 ? true : false,
                        ],
                        [
                            'text' => _trans('payroll.Inactive'),
                            'value'  => 4,
                            'active' => $updateModel->status_id == 4 ? true : false,
                        ]
                    ]
                ]
            ];
        }
    }
}
