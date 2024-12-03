<?php

namespace Modules\SingleDeviceLogin\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\UserRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use App\Repositories\Hrm\Designation\DesignationRepository;

class SingleDeviceLoginController extends Controller
{
    protected $user;
    protected $designation;

    public function __construct(UserRepository $user, DesignationRepository $designation)
    {
        $this->user = $user;
        $this->designation = $designation;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    function device_table($request){
        try {
            $data = User::where('branch_id', userBranch())
                ->select('id', 'company_id', 'role_id', 'department_id', 'designation_id',
                    'name', 'device_id', 'device_info')
                ->where('company_id', 1);
            $where = array();
            if ($request->search) {
                $where[] = ['name', 'like', '%' . $request->search . '%'];
            }
            if (@$request->designation) {
                $where[] = ['designation_id', $request->designation];
            }
            $data = $data
                ->where($where)
                ->paginate($request->limit ?? 10);
            return [
                'data' => $data->map(function ($data) {
                    $action_button = '';
                    if($data->device_id!=null){
                        // $action_button .= '<a href="'.route('user.resetDevice',[$data->id,'app']).'" class="btn btn-primary reset_btn">'._trans('common.Remove').'</a>';
                        $action_button .= '<a href="'.route('user.resetDevice',[$data->id,$data->last_login_device??'mobile']).'" class="btn btn-primary ">
                        <i class="fas fa-eraser"></i>
                        </a>';
                    }
                    return [
                        'id' => $data->id,
                        'name' => $data->name,
                        'device_id' => $data->device_id ?? 'N/A',
                        'device_name' => @$data->device_data[0]!=""?$data->device_data[0]:'N/A',
                        'brand' => @$data->device_data[2]!=""?$data->device_data[2]:'N/A',
                        'model' => @$data->device_data[1]!=""?$data->device_data[1]:'N/A',
                        'last_login_device' => @$data->last_login_device??'--',
                        // 'status' => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
                        'action' => $action_button,
                    ];
                }),
                'pagination' => [
                    'total' => $data->total(),
                    'count' => $data->count(),
                    'per_page' => $data->perPage(),
                    'current_page' => $data->currentPage(),
                    'total_pages' => $data->lastPage(),
                    'pagination_html' => $data->links('backend.pagination.custom')->toHtml(),
                ],
            ];
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    function device_fields(){
        return [
            _trans('common.ID'),
            _trans('common.Name'),
            _trans('common.Device ID'),
            _trans('common.Device Name'),
            _trans('common.Brand'),
            _trans('common.Model'),
            _trans('common.Last Login Device'),
            _trans('common.Action'),

        ];
    }
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->device_table($request);
            }
            $data['title'] = _trans('common.Employee Device List');
            $data['designations'] = $this->designation->getActiveAll();
            $data['class']  = 'users_device_table';
            $data['fields'] = $this->device_fields();
            $data['checkbox'] = true;


            return view('singledevicelogin::index', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return back();
        }
    }

    public function resetDevice($user_id,$device){
        try {
            $result=$this->user->resetDevice($user_id,$device);
            if ($result) {
                Toastr::success('Device Reset Successfully.', 'success');
                return redirect()->back();
            } else {
                Toastr::error('Something went wrong.', 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error('Something went wrong.', 'Error');
            return redirect()->back();
        }
    }
}
