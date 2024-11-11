<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Hrm\Payroll\SalaryRepository;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;

class PayslipReportController extends Controller
{
    use ApiReturnFormatTrait;

    protected $salaryRepository;
    protected $companyRepository;
    protected $employeeRepository;

    public function __construct(SalaryRepository $salaryRepository, CompanyRepository $companyRepository, UserRepository $employeeRepository)
    {
        $this->salaryRepository = $salaryRepository;
        $this->companyRepository = $companyRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function getList(Request $request)
    {
        try {
            return $this->salaryRepository->getPayslipList($request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 500);
        }
    }

    public function getUserInfoFronJWTToken($token)
    {
        // $user = JWTAuth::user($token);
        // return $user;
    }

    public function showPaySlipHtml(Request $request, $payslip_id, $user_id)
    {
        try {
            $payslip_id = decrypt($payslip_id);
            $user_id = decrypt($user_id);
            $user=User::find($user_id);
            if ($user) {
                $data['title'] = _trans('payroll.Payslip');
                $params = [
                    'id' => $payslip_id,
                    'company_id' => $user->company_id,
                ];
                $params['user_id'] = $user_id;

                $data['salary'] = $this->salaryRepository->model($params)->first();
                $data['employee_info'] = $this->employeeRepository->getByIdWithDetails(['id' => $data['salary']->user_id]);

                return view('backend.payroll.salary.payslip_print', [
                    'data' => $data,
                ]);

                $file_name = date('F', strtotime($data['salary']->date)) . ' ' . date('Y', strtotime($data['salary']->date)) . '-' . $data['employee_info']->name . '-Payslip.pdf';

                return $pdf->stream($file_name);
            } else {
                return $this->responseWithError(_trans('message.User Not Found'), [], 500);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(_trans('message.Payslip Not Found'), [], 500);
        }
    }
    public function showPaySlip(Request $request, $payslip_id, $user_id)
    {
        try {
            $payslip_id = decrypt($payslip_id);
            $user_id = decrypt($user_id);
            $user=User::find($user_id);
            Auth::login($user);
            if ($user) {
                $data['title'] = _trans('payroll.Payslip');
                $params = [
                    'id' => $payslip_id,
                    'company_id' => $user->company_id,
                ];
                $params['user_id'] = $user_id;

                $data['salary'] = $this->salaryRepository->model($params)->first();
                $data['employee_info'] = $this->employeeRepository->getByIdWithDetails(['id' => $data['salary']->user_id]);

                $pdf = PDF::loadView('backend.payroll.salary.payslip_print', [
                    'data' => $data,
                ])->setPaper('a4', 'landscape');

                $file_name = date('F', strtotime($data['salary']->date)) . ' ' . date('Y', strtotime($data['salary']->date)) . '-' . $data['employee_info']->name . '-Payslip.pdf';

                return $pdf->download($file_name);
            } else {
                return $this->responseWithError(_trans('message.User Not Found'), [], 500);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(_trans('message.Payslip Not Found'), [], 500);
        }
    }
}
