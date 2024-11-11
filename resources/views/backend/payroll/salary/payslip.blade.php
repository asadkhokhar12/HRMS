@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        route('hrm.payroll_salary.index') =>  _trans('common.List'),
        '#' => @$data['title'],
    ]) !!}
    <div class="table-content table-basic">
        <div class="card" id="invoicePdf">
            <div class="card-body">
                <div id="General-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            @include('backend.auth.backend_logo')
                        </h4>
                        <div class="text-center">
                            <h2>
                                {{ @date('F', strtotime($data['salary']->date)).' '.@date('Y', strtotime($data['salary']->date)) }}
                            </h2>
                            @if ($data['salary']->is_calculated==0)
                                <small class="text-danger">
                                    {{ _trans('message.Please complete salary calculation to get the final salary.') }}
                                </small>
                            @endif
                        </div>
                        {{-- <a href="javascript:window.print()" class="btn btn-primary btn-sm">
                            <i class="fa fa-print"></i>
                        </a> --}}
                        <a href="{{ route('hrm.payroll_salary.invoice_print', $data['salary']->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-print"></i>
                        </a>
                    </div>
                    <hr>

                            <tr>
                                <td align="left" valign="middle" class="black12">
                                    {{ _trans('common.Gross Salary') }}</td>
                                <td align="center" valign="middle" class="black12">:</td>
                                <td align="left" valign="middle">
                                    {{ currency_format(@$data['salary']->employee->basic_salary) }}</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle" class="black12">
                                    {{ _trans('common.Total Working Day') }}</td>
                                <td align="center" valign="middle" class="black12">:</td>
                                <td align="left" valign="middle">
                                    {{ @$data['salary']->total_working_day }}</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle" class="black12">
                                    {{ _trans('common.Total Present') }}</td>
                                <td align="center" valign="middle" class="black12">:</td>
                                <td align="left" valign="middle">{{ @$data['salary']->present }}</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle" class="black12">
                                    {{ _trans('common.Total Absent') }}</td>
                                <td align="center" valign="middle" class="black12">:</td>
                                <td align="left" valign="middle">{{ @$data['salary']->absent }}</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle" class="black12">
                                    {{ _trans('common.Total Late') }}</td>
                                <td align="center" valign="middle" class="black12">:</td>
                                <td align="left" valign="middle">{{ @$data['salary']->late }}</td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle" class="black12">
                                    {{ _trans('common.Total Early Leave') }}</td>
                                <td align="center" valign="middle" class="black12">:</td>
                                <td align="left" valign="middle">{{ @$data['salary']->left_early }}
                                </td>
                            </tr>
                            <tr>
                                <td align="left" valign="middle" class="black12">
                                    {{ _trans('common.Date') }}</td>
                                <td align="center" valign="middle" class="black12">:</td>
                                <td align="left" valign="middle">
                                    {{ main_date_format(@$data['salary']->date) }}</td>
                            </tr>
                        </tbody>
                    </table>


                                            <div class="row mt-20">
                                                <div class="col-lg-6">
                                                    <h4>
                                                        {{ _trans('common.Total') }}
                                                    </h4>
                                                </div>
                                                <div class="col-lg-6">
                                                    <h4>
                                                        :  {{ currency_format(@$data['salary']->absent_amount+$data['salary']->deduction_amount) }}
                                                    </h4>
                                                </div>
                                            </div>
                                     
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 d-flex">
                            <div class="col-lg-4" style=" border-right: 1px dotted; margin-right: 15px; ">
                                <fieldset>
                                    <legend>
                                        <h3>
                                            {{ _trans('payroll.Addition') }}
                                        </h3>
                                        <hr>
                                    </legend>
                                    <div class="row mt-20">
                                        <div class="col-lg-6">
                                            <p>
                                                {{ _trans('payroll.Adjust Salary') }}
                                            </p>
                                        </div>
                                        <div class="col-lg-6">
                                            <p>
                                                : {{ currency_format(number_format(@$data['salary']->adjust, 2)) }}
                                            </p>
                                        </div>
                                    </div>
                                    @if ($data['salary']->allowance_details != null)
                                        @forelse (@$data['salary']->allowance_details as $key => $value)
                                            <div class="row mt-4">
                                                <div class="col-lg-6">
                                                    <p>
                                                        {{ @$value['name'] }}
                                                    </p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <p>
                                                        : {{ currency_format($value['amount']) }}
                                                    </p>
                                                </div>
                                            </div>
                                        @empty
                                            {{-- <p class="text-center">--- No Allowance ---</p> --}}
                                        @endforelse
                                    @endif
                                    <div class="row mt-20">
                                        <div class="col-lg-6">
                                            <h4>
                                                {{ _trans('common.Total') }}
                                            </h4>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4>
                                                :  {{ currency_format(@$data['salary']->allowance_amount+$data['salary']->adjust) }}
                                            </h4>
                                        </div>
                                    </div>  
                                        
                                </fieldset>
                            </div>
                            <div class="col-lg-4" style=" border-right: 1px dotted; margin-right: 15px; ">
                                 <fieldset>
                                    <legend>
                                        <h3>
                                            {{ _trans('common.Payment') }}
                                        </h3>
                                        <hr>
                                    </legend>
                                        <div class="row mt-20">
                                            <div class="col-lg-6">
                                                <p>
                                                    {{ _trans('common.Gross Salary') }}
                                                </p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>
                                                    : {{ currency_format(@$data['salary']->employee->basic_salary) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-6">
                                                <p>
                                                    {{ _trans('common.Total Deduction') }}
                                                </p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>
                                                    : {{ currency_format(@$data['salary']->absent_amount+$data['salary']->deduction_amount) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-6">
                                                <p>
                                                    {{ _trans('common.Total Addition') }}
                                                </p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>
                                                    : {{ currency_format(@$data['salary']->allowance_amount+$data['salary']->adjust) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-6">
                                                <p>
                                                    {{ _trans('common.Total Payable') }}
                                                </p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>
                                                    : {{ currency_format(number_format(@$data['salary']->net_salary, 2)) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mt-20">
                                            <div class="col-lg-6">
                                                <p>
                                                    {{ _trans('common.Total Paid') }} 
                                                </p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>
                                                    : {{ currency_format(number_format(@$data['salary']->net_salary - $data['salary']->due_amount, 2)) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-6">
                                                <p>
                                                    {{ _trans('common.Total Due') }}
                                                </p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>
                                                    : {{ currency_format(number_format($data['salary']->due_amount, 2)) }}
                                                </p>
                                            </div>
                                        </div>
                                     
                                </fieldset>

                            </div>
                            <div class="col-lg-4">
                                <fieldset>
                                    <legend>
                                        <h3>
                                            {{ _trans('common.Net Pay') }}
                                        </h3>
                                        <hr>
                                    </legend>
                                    <h2 class="text-center mt-20">
                                        {{ currency_format(number_format($data['salary']->due_amount, 2)) }}
                                    </h2>
                                     
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
@section('script')
@endsection
