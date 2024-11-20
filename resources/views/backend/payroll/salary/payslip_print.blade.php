<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ @date('F', strtotime($data['salary']->date)).' '.@date('Y', strtotime($data['salary']->date)) }}</title>
    <style>
        .table{
            border-collapse: collapse;

        }
        .payslip{
            border:2px solid #000;
            padding: 4%;
        }
        .head_title{
            border: 1px dotted #000;
            text-align: center;
            width: 33%;
        }
        .pay_info_td{
            border: 1px dotted #000;
            text-align: center;
        }
        .pay_info_title{
            text-align: left;
            width: 50%;
            font-weight: bold;
        }
        .pay_info_text{
            text-align: right;
            width: 50%;
            padding-right: 20px;
        }
    </style>
</head>
<body>
    
    <div class="container">

        <div class="payslip">
            <div class="company_logo">
                <img style="width: 20%;" class="full-logo dark_logo d-none" src="{{ logo_dark(@base_settings('company_logo_frontend')) }}" alt="" >
            </div>
                <h2>
                   {{ _trans('common.Month') }} : {{ @date('F', strtotime($data['salary']->date)).' '.@date('Y', strtotime($data['salary']->date)) }}
                </h2>
            <table class="table" style="width: 100%;">
                <tr>
                    <td class="head_title">
                        <h3>
                            {{ _trans('common.Employee Details') }}
                        </h3>
                    </td>
                    <td class="head_title">
                        <h3>
                            {{ _trans('common.Attendance Details') }}
                        </h3>
                    </td>
                    <td class="head_title">
                        <h3>
                            {{ _trans('common.Deductions') }} 
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td class="pay_info_td">
                        <table style="width: 100%;">
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Employee Name') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ @$data['employee_info']->name }}
                                </td>
                            </tr>
                            <tr>
                                <td  class="pay_info_title">
                                    {{ _trans('common.Employee ID') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ @$data['employee_info']->employee_id }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Department') }} 
                                </td>
                                <td class="pay_info_text">
                                    {{ @$data['employee_info']->department->title }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Designation') }} 
                                </td>
                                <td class="pay_info_text">
                                    {{ @$data['employee_info']->designation->title }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Joining Date') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ ShowDate(@$data['employee_info']->joining_date) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.TIN') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ ShowDate(@$data['employee_info']->tin) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    
                    <td class="pay_info_td">
                        <table style="width: 100%;">
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Total Working Day') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ @$data['salary']->total_working_day ?? 0 }} {{ _trans('common.Days') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Total Present') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ @$data['salary']->present ?? 0 }} {{ _trans('common.Days') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Total Absent') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ @$data['salary']->absent ?? 0 }} {{ _trans('common.Days') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Total Late') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ @$data['salary']->late ?? 0 }} {{ _trans('common.Days') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Total Early Leave') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ @$data['salary']->left_early ?? 0 }} {{ _trans('common.Days') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="pay_info_td">
                        <table style="width: 100%;">
                                @if (@$data['salary']->deduction_details)
                                    @foreach (@$data['salary']->deduction_details as $key => $value)
                                    <tr>
                                        <td class="pay_info_title">
                                            {{ @$value['name'] }}
                                        </td>
                                        <td class="pay_info_text">
                                            {{ currency_format($value['amount']) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <td class="pay_info_title">
                                        {{ _trans('payroll.Absent') }}
                                    </td>
                                    <td class="pay_info_text">
                                        {{ currency_format(number_format(@$data['salary']->absent_amount, 2)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pay_info_title">
                                        {{ _trans('payroll.Advance') }}
                                    </td>
                                    <td class="pay_info_text">
                                         {{ currency_format($data['salary']->advance_amount) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pay_info_title">
                                        <h4>
                                            {{ _trans('common.Total') }}
                                        </h4>
                                    </td>
                                    <td class="pay_info_text">
                                         {{ currency_format(@$data['salary']->absent_amount+$data['salary']->deduction_amount) }}
                                    </td>
                                </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br>
            {{-- @dd('here') --}}
            <table class="table" style=" width: 100%;">
                <tr>
                    <td class="head_title">
                        <h3>
                            {{ _trans('payroll.Addition') }}
                        </h3>
                    </td>
                    <td class="head_title">
                        <h3>
                            {{ _trans('common.Payment') }}
                        </h3>
                    </td>
                    <td class="head_title">
                        <h3>
                            {{ _trans('common.Net Pay') }}
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td class="pay_info_td">
                        <table style="width: 100%;">
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('payroll.Adjust Salary') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ currency_format(number_format(@$data['salary']->adjust, 2)) }}
                                </td>
                            </tr>
                            @if ($data['salary']->allowance_details != null)
                                @forelse (@$data['salary']->allowance_details as $key => $value)
                                <tr>
                                    <td class="pay_info_title">
                                        {{ @$value['name'] }}
                                    </td>
                                    <td class="pay_info_text">
                                        {{ currency_format($value['amount']) }}
                                    </td>
                                </tr>
                                @empty
                                    {{-- <p class="text-center">--- No Allowance ---</p> --}}
                                @endforelse
                            @endif
                            <tr>
                                <td class="pay_info_title">
                                    <h4>
                                        {{ _trans('common.Total') }}
                                    </h4>
                                </td>
                                <td class="pay_info_text">
                                    {{ currency_format(@$data['salary']->allowance_amount+$data['salary']->adjust) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="pay_info_td">
                        <table style="width: 100%;">
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Gross Salary') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ currency_format(@$data['salary']->employee->basic_salary) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Total Deduction') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ currency_format(@$data['salary']->absent_amount+$data['salary']->deduction_amount) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Total Addition') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ currency_format(@$data['salary']->allowance_amount+$data['salary']->adjust) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Total Payable') }}
                                </td>
                                <td class="pay_info_text">
                                    {{ currency_format(number_format(@$data['salary']->net_salary, 2)) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Total Paid') }} 
                                </td>
                                <td class="pay_info_text">
                                    {{ currency_format(number_format(@$data['salary']->net_salary - $data['salary']->due_amount, 2)) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pay_info_title">
                                    {{ _trans('common.Total Due') }} 
                                </td>
                                <td class="pay_info_text">
                                    {{ currency_format(number_format($data['salary']->due_amount, 2)) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="pay_info_td">
                        <h2 class="text-center mt-20">
                            {{ currency_format(number_format($data['salary']->due_amount, 2)) }}
                        </h2>
                    </td>
                </tr>
            </table>
        </div>
        
    </div>
</body>
</html>