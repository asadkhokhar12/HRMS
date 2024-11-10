<?php

namespace App\Http\Controllers\Backend\Company;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Company\Company;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Hrm\Attendance\Weekend;
use App\Http\Requests\Company\CompanyRequest;
use App\Repositories\Company\CompanyRepository;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;

class CompanyController extends Controller
{
    use ApiReturnFormatTrait;
    protected CompanyRepository $company;

    public function __construct(CompanyRepository $company)
    {
        $this->company = $company;
    }

    public function index()
    {
        $data['title'] = _trans('common.Company List');
        return view('backend.company.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = _trans('common.Add new company');
        return view('backend.company.create', compact('data'));
    }




    public function dataTable(Request $request)
    {


        return $this->company->dataTable($request);
    }


    public function store(CompanyRequest $request)
    {

        try {
            $data['title'] = _trans('common.Company List');
            $data = $this->company->store($request);
            if ($data) {
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('company.index');
            } else {
                Toastr::error("Company doesn't create! try again", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            Toastr::error("Something went wrong", 'Error');
            return redirect()->back();
        }
    }

    public function show(Company $company)
    {
        $data['title'] = _trans('common.Edit Company');
        $data['show'] = $company;
        return view('backend.company.edit', compact('data'));
    }

    public function update(CompanyRequest $request, Company $company)
    {

        try {
            $this->company->update($request, $company->id);
            Toastr::success(_trans('response.Operation successful'), 'Success');
            return redirect()->route('company.index');
        } catch (\Exception $exception) {
            Toastr::error("Something went wrong", 'Error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {


        try {
            $company = Company::find($id);
            $company->delete();

            Toastr::success(_trans('response.Operation successful'), 'Success');
            return redirect()->route('company.index');
        } catch (\Throwable $th) {

            Toastr::error("Something went wrong", 'Error');
            return redirect()->back();
        }
    }

    public function changeStatus(Company $company, $status)
    {

        try {
            $this->company->changeStatus($company, $status);
            Toastr::success(_trans('response.Operation successful'), 'Success');
            return redirect()->route('company.index');
        } catch (\Exception $exception) {
            Toastr::error("Something went wrong", 'Error');
            return redirect()->back();
        }
    }
}
