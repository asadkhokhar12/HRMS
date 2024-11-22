<?php

namespace App\Http\Controllers\Backend\Payroll;

use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Http\Request;
use App\Exports\SalaryExport;
use App\Models\SalarySheetReport;
use App\Models\Payroll\Commission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Hrm\Leave\LeaveRequest;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Hrm\Payroll\SalaryRepository;
use App\Repositories\Hrm\Finance\AccountRepository;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Hrm\Department\DepartmentRepository;
use App\Repositories\Hrm\Expense\ExpenseCategoryRepository;
use Barryvdh\DomPDF\Facade\Pdf;


class SalaryController extends Controller
{
    use ApiReturnFormatTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $accountRepository;
    protected $salaryRepository;
    protected $department;
    protected $incomeExpenseCategoryRepository;
    protected $companyRepository;
    protected $employeeRepository;

    public function __construct(
        AccountRepository $accountRepository,
        SalaryRepository $salaryRepository,
        DepartmentRepository $department,
        ExpenseCategoryRepository $incomeExpenseCategoryRepository,
        CompanyRepository $companyRepository,
        UserRepository $employeeRepository
    ) {
        $this->accountRepository  = $accountRepository;
        $this->salaryRepository  = $salaryRepository;
        $this->department        = $department;
        $this->incomeExpenseCategoryRepository = $incomeExpenseCategoryRepository;
        $this->companyRepository = $companyRepository;
        $this->employeeRepository = $employeeRepository;
    }

    function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->salaryRepository->table($request);
            }
            $data['class']  = 'salary_table';
            $data['fields'] = $this->salaryRepository->fields();
            $data['table']  = route('hrm.payroll_salary.index');
            $data['url_id']    = 'salary_table_url';

            $data['salary_generate']  = (hasPermission('salary_generate')) ? route('hrm.payroll_salary.generate_modal') : '';
            $data['title']            = _trans('payroll.Salary');
            $data['departments'] = $this->department->getAll();
            return view('backend.payroll.salary.index', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_translate('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function datatable(Request $request)
    {
        return $this->salaryRepository->datatable($request);
    }

    public function generateModal()
    {
        try {
            $data['title']         = _trans('payroll.Salary Generate');
            $data['url']           = (hasPermission('salary_generate')) ? route('hrm.payroll_salary.generate') : '';
            $data['button']        = _trans('common.Generate');

            $data['departments'] = $this->department->getAll();
            return view('backend.payroll.salary.generate_modal', compact('data'));
        } catch (\Throwable $e) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function generate(Request $request)
    {
        try {
            return $this->salaryRepository->generate($request);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }

    public function calculateModal($id)
    {
        try {
            $data['title']         = _trans('payroll.Salary Calculation');
            $data['url']           = (hasPermission('salary_calculate')) ? route('hrm.payroll_salary.calculate', $id) : '';
            $data['button']        = _trans('common.Generate');
            $params                = [
                'id' => $id,
                'company_id' => $this->companyRepository->company()->id,
            ];

            $data['salary'] = $this->salaryRepository->model($params)->first();
            if ($data['salary']) {
                $data['info'] = $this->salaryRepository->infoNew($params);
                return view('backend.payroll.salary.calculate_modal', compact('data'));
            } else {
                return response()->json('fail');
            }
        } catch (\Throwable $e) {
            return response()->json('fail');
        }
    }
    public function calculate(Request $request, $id)
    {
        try {
            $params                = [
                'id' => $id,
                'company_id' => $this->companyRepository->company()->id,
            ];
            // $result = $this->salaryRepository->calculate($request, $params);
            $result = $this->salaryRepository->calculateNew($request, $params);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('hrm.payroll_salary.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->route('hrm.payroll_salary.index');
            }
        } catch (\Throwable $e) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->route('hrm.payroll_salary.index');
        }
    }


    public function pay($id)
    {
        try {
            $data['title']         = _trans('payroll.Make Payment');
            $params                = [
                'id' => $id,
                'company_id' => $this->companyRepository->company()->id,
            ];
            if (auth()->user()->role->slug == 'staff') {
                $params['user_id'] = auth()->user()->id;
            }
            $data['advance']       = $this->salaryRepository->model($params)->first();
            $data['category'] = $this->incomeExpenseCategoryRepository->model(
                [
                    'is_income' => 0,
                    'status_id' => 1,
                    'company_id' => $this->companyRepository->company()->id
                ]
                )->get();
                $data['payment_method'] = DB::table('payment_methods')->where(
                [
                    'company_id' => $this->companyRepository->company()->id
                    ]
                    )->get();
                    $data['url']           = (hasPermission('salary_pay')) ? route('hrm.payroll_salary.pay_store', $id) : '';
                    if (auth()->user()->role->slug == 'staff' && $data['advance']->status_id != 2) {
                        $data['url'] = '';
                    }
                    $data['accounts']      = $this->accountRepository->model(
                        [
                            'company_id' => $this->companyRepository->company()->id,
                            'status_id' => 1,
                            ]
                            )->get();

            return view('backend.payroll.salary.payment_modal', compact('data'));
        } catch (\Throwable $e) {
            return response()->json('fail');
        }
    }

    function payStore(Request $request, $id)
    {
        if (!$request->category) {
            Toastr::error('Please select category!', 'Error');
            return redirect()->back();
        }
        if (!$request->account) {
            Toastr::error('Please select account!', 'Error');
            return redirect()->back();
        }
        try {
            $params                = [
                'id' => $id,
                'company_id' => $this->companyRepository->company()->id,
            ];
            if (auth()->user()->role->slug == 'staff') {
                $params['user_id'] = auth()->user()->id;
            }
            $salary       = $this->salaryRepository->model($params)->first();
            if (!$salary) {
                Toastr::error('Salary not found!', 'Error');
                return redirect()->route('hrm.payroll_salary.index');
            }
            $result = $this->salaryRepository->pay($request, $salary);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('hrm.payroll_salary.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $e) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    // function invoice($id)
    // {

    //     try {
    //         $data['title'] = _trans('payroll.Payslip');
    //         $params                = [
    //             'id' => $id,
    //             'company_id' => $this->companyRepository->company()->id,
    //         ];
    //         if (auth()->user()->role->slug == 'staff') {
    //             $params['user_id'] = auth()->user()->id;
    //         }
    //         $data['salary']       = $this->salaryRepository->model($params)->first();
    //         return view('backend.payroll.salary.payslip', compact('data'));
    //     } catch (\Throwable $e) {
    //         Toastr::error(_trans('response.Something went wrong.'), 'Error');
    //         return redirect()->back();
    //     }
    // }
    function invoice($id)
    {

        try {
            $data['title'] = _trans('payroll.Payslip');
            $params                = [
                'id' => $id,
                'company_id' => $this->companyRepository->company()->id,
            ];
            if (auth()->user()->role->slug == 'staff') {
                $params['user_id'] = auth()->user()->id;
            }
            $data['salary']       = $this->salaryRepository->model($params)->first();
            $data['employee_info']= $this->employeeRepository->getByIdWithDetails(['id' => $data['salary']->user_id]);
            // return $data['salary'];
            return view('backend.payroll.salary.payslip', compact('data'));
        } catch (\Throwable $e) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }
    function invoice_print($id)
    {

        try {
            $data['title'] = _trans('payroll.Payslip');
            $params                = [
                'id' => $id,
                'company_id' => $this->companyRepository->company()->id,
            ];
            if (auth()->user()->role->slug == 'staff') {
                $params['user_id'] = auth()->user()->id;
            }
            $data['salary']       = $this->salaryRepository->model($params)->first();
            $data['employee_info']= $this->employeeRepository->getByIdWithDetails(['id' => $data['salary']->user_id]);
            
            // return view('backend.payroll.salary.payslip_print', compact('data'));
            //landscape pdf view
            $pdf = PDF::loadView('backend.payroll.salary.payslip_print',[ 
                'data' => $data
            ])->setPaper('a4', 'landscape');


            $file_name=date('F', strtotime($data['salary']->date)).' '.date('Y', strtotime($data['salary']->date)).'-'.$data['employee_info']->name.'-Payslip.pdf';

            return $pdf->stream($file_name);
        } catch (\Throwable $e) {
            dd($e);
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    function show($id)
    {
        try {
            $data['title']     = _trans('payroll.Salary details');
            $params                = [
                'id' => $id,
                'company_id' => $this->companyRepository->company()->id,
            ];
            if (auth()->user()->role->slug == 'staff') {
                $params['user_id'] = auth()->user()->id;
            }
            $data['salary']       = $this->salaryRepository->model($params)->first();
            return view('backend.payroll.salary.show', compact('data'));
        } catch (\Throwable $e) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    function delete($id)
    {
        try {
            $result = $this->salaryRepository->delete($id, $this->companyRepository->company()->id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('hrm.payroll_salary.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->route('hrm.payroll_salary.index');
            }
        } catch (\Throwable $th) {
            Toastr::error(_translate('response.Something went wrong!'), 'Error');
            return redirect()->route('hrm.payroll_salary.index');
        }
    }

    public function userProfileTable(Request $request, $user_id)
    {
        if ($request->ajax()) {
            return $this->salaryRepository->table($request);
        }
    }

    public function getSalaryGeneratedDepartment(Request $request){

        $departments= $this->salaryRepository->getSalaryGeneratedDepartment($request);
        return $departments;
        return response()->json($departments);
    }
    

    public function exportExcel($sub_title)
    {

        try {
            // dd($sub_title);
            ob_end_clean();
            ob_start();
            // return Excel::download(new SalaryExport('test'), 'users.xlsx');
            return Excel::download(new SalaryExport($sub_title), $sub_title.'.xlsx');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    // Salary Table
    public function salaryTable(Request $request){
        
        $data['title']         = _trans('payroll.Salary Table');
        $data['departments'] = $this->department->getAll();
        if ($request->method() == 'POST') {
            $month=date('m',strtotime($request->month));
            $year=date('Y',strtotime($request->month));
            $data['month'] = date('F', mktime(0, 0, 0, $month, 10));
            $this->salaryRepository->generate($request);

            $data['last_day'] = date('t', strtotime($request->month));
            $data['sub_title'] = 'From 1 '.$data['month'].' to '.$data['last_day'] .' '.$data['month'].' '.$year;
            $data['commissions']=$commission = Commission::where('status_id', 1)->where('company_id', auth()->user()->company_id)->get();
            $salarySheet= $this->salaryRepository->salarySheet($request);
            $data['salarySheet'] = $salarySheet;
            SalarySheetReport::where('company_id', auth()->user()->company_id)->delete();
            foreach ($data['salarySheet'] as $key => $salarySheet) {
               try {
                    $db_salary_sheet=new SalarySheetReport();

                    $db_salary_sheet->sl_no=$salarySheet['user_id'];
                    $db_salary_sheet->name_of_the_employee=$salarySheet['user_name'];
                    $db_salary_sheet->employee_id=$salarySheet['employee_id'];
                    $db_salary_sheet->designation=$salarySheet['user_designation'];
                    $db_salary_sheet->w_days=$salarySheet['total_working_days'];
                    $db_salary_sheet->present=$salarySheet['total_present'];
                    $db_salary_sheet->absent=$salarySheet['total_absent'];
                    $db_salary_sheet->tardy=$salarySheet['total_late'];
                    $db_salary_sheet->tardy_days=$salarySheet['late_dates'];
                    $db_salary_sheet->gross_salary=$salarySheet['gross_salary'];

                    foreach ($salarySheet['addition_detail'] as $key => $addition) {
                        switch ($addition['name']) {
                            case 'Basic':
                                $db_salary_sheet->basic_50=$addition['amount'];
                                break;
                            case 'Medical':
                                $db_salary_sheet->medical_10=$addition['amount'];
                                break;
                            case 'Hra':
                                $db_salary_sheet->hra_40=$addition['amount'];
                                break;
                            case 'HRA':
                                $db_salary_sheet->hra_40=$addition['amount'];
                                break;
                            case 'Performance Incentive':
                                $db_salary_sheet->performance_incentive=$addition['amount'];
                                break;
                            
                            default:

                                break;
                        }
                    }

                    $db_salary_sheet->absent_amount=0;
                    $db_salary_sheet->advance=0;
                    $db_salary_sheet->tardy_amount=0;
                    $db_salary_sheet->incentive=0;
                    $db_salary_sheet->net_salary=$salarySheet['net_salary'];
                    $db_salary_sheet->save();
               } catch (\Throwable $th) {
                   dd($th);
               }
            }
            return  $this->exportExcel($data['sub_title']);
        }
        return view('backend.payroll.salary.salary_table', compact('data'));
    }
}
