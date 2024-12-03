@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        route('hrm.payroll_salary.index') => _trans('common.List'),
        '#' => @$data['title'],
    ]) !!}

    <div class="table-content table-basic">
        <div class="card" id="invoicePdf">
            <div class="card-body">

                <div class="row m-0 mt-5 px-5">
                    <div class=" mb-5 col-md-12 d-flex justify-content-between align-items-center">
                        <span class="fs-1 fw-bold">Cybertron Labs (Pvt) Ltd</span>
                        <a href="{{ route('hrm.payroll_salary.invoice_print', $data['salary']->id) }}"
                            class="btn btn-primary btn-sm">
                            <i class="fa fa-print"></i>
                        </a>
                    </div>
                    <div class="img-fluid mb-0 col-md-12">
                        <div><label>Payslip-</label>{{ $data['employee_info']->name }} -
                            {{ @date('M Y', strtotime($data['salary']->date)) }}</div>
                        <div><label>Pay Date:</label> {{ @date('10/m/Y') }}</div>
                        <div><label>Pay Period:</label> {{ @date('F Y') }}</div>
                    </div>
                </div>

                <div class="row m-0 my-4 px-5">
                    <div class="col-md-6">
                        <div> <span class="fs-5 fw-bold">Employee Details</span></div>
                        <div>{{ $data['employee_info']->name }}</div>
                        <div>{{ $data['employee_info']->designation->title }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-end"><span class="fs-5 fw-bold">Employer Details</span></div>
                        <div class="text-end"><span>Cybertron Labs (Pvt) Ltd</span></div>
                        <div class="text-end"><span>A29 KDA Scheme 1 Karsaz Road,</span></div>
                        <div class="text-end"><span>Karachi, Pakistan</span></div>
                    </div>

                </div>

                <div class="row m-0 my-4 px-5">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead class="bg-gray">
                                <tr>
                                    <th style="width:50%">Earnings</th>
                                    <th style="width:50%" class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Basic Pay</td>
                                    <td class="text-end">{{ $data['salary']->gross_salary }}</td>
                                </tr>
                                {{-- <tr>
                                    <td>Travel Allowance</td>
                                    <td class="text-end">5,000.00</td>
                                </tr>
                                <tr>
                                    <td>Medical Allowance</td>
                                    <td class="text-end">700.00</td>
                                </tr> --}}
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead class="bg-gray">
                                <tr>
                                    <th style="width:50%">Deductions</th>
                                    <th style="width:50%" class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data['salary']->absent_amount > 0)
                                    <tr>
                                        <td>{{ _trans('common.Absent Deduction') }}</td>
                                        <td class="text-end">{{ @$data['salary']->absent_amount }}</td>
                                    </tr>
                                @endif
                                @if ($data['salary']->late_deductions_amount > 0)
                                    <tr>
                                        <td>{{ _trans('common.Late Deduction') }}</td>
                                        <td class="text-end">{{ @$data['salary']->late_deductions_amount }}</td>
                                    </tr>
                                @endif
                                @if ($data['salary']->half_day_deductions_amount > 0)
                                    <tr>
                                        <td> {{ _trans('common.Half-Day Deduction') }}</td>
                                        <td class="text-end">{{ @$data['salary']->half_day_deductions_amount }}</td>
                                    </tr>
                                @endif
                                @if ($data['salary']->advance_amount > 0)
                                    <tr>
                                        <td>{{ _trans('common.Loan') }}</td>
                                        <td class="text-end">{{ @$data['salary']->advance_amount }}</td>
                                    </tr>
                                @endif
                                @if ($data['salary']->employee->tax > 0)
                                    <tr>
                                        <td>{{ _trans('common.Tax') }}</td>
                                        <td class="text-end">{{ @$data['salary']->employee->tax }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        @if ($data['salary']->adjust > 0)
                            <table class="table table-bordered">
                                <thead class="bg-gray">
                                    <tr>
                                        <th style="width:50%">Adjustment</th>
                                        <th style="width:50%" class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ _trans('common.Adjust Amount') }}</td>
                                        <td class="text-end">{{ @$data['salary']->adjust }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif

                        <table class="table table-bordered">
                            <thead class="bg-gray">
                                <tr>
                                    <th style="width:50%"> {{ _trans('common.Total Pay') }}</th>
                                    <th style="width:50%" class="text-end">PKR
                                        {{ number_format($data['salary']->net_salary, 2) }}</th>
                                </tr>
                                <tr>
                                    <th style="width:50%"> {{ _trans('common.Total Pay in Words') }}</th>
                                    <th style="width:50%" class="text-end">
                                        {{ Str::ucfirst(numberTowords_2(floor($data['salary']->net_salary))) }} <br> PKR
                                    </th>
                                </tr>

                            </thead>
                        </table>
                    </div>
                </div>

                <div class="row m-0 my-5 px-5">
                    <div class="col-md-6">
                        <div> <span class="fs-5 fw-bold">Payment Details</span></div>
                        <div>Payment made to employee's bank account.</div>
                        <div>Employee Signature</div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="text-end w-100">Employee Signature</div>
                    </div>

                    <div class="col-md-12 py-5 my-5 d-flex justify-content-center align-items-end">
                        <div>This is a system generated payslip.</div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
@section('script')
@endsection
