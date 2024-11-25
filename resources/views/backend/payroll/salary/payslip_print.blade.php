<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ @date('F', strtotime($data['salary']->date)).' '.@date('Y', strtotime($data['salary']->date)) }}</title>
    <style>
        .container{
            width:90%;
            height:100%;
            padding: 4%;
            font-family:Arial, Helvetica, sans-serif;
            color:#343a40;
        }
        
        .brand{
            width:100%;
            text-align:left;
            font-size:42px;
            font-weight:bold;
        }

        .payslip-info{
            margin:2% 0;
        }

        .row{
            display:flex;
        }

        .col-md-6{
            width:50%;
        }
        .col-md-12{
            width:100%;
        }

        .fw-bold{
            font-weight: bold;
        }

        .text-start{text-align:start;}
        .text-center{ text-align:center;}
        .text-end{ text-align:end;}
        .table{
            width:100%;
            border-collapse: collapse;
        }
        .table-bordered tr th{
            border:1px solid #adb5bd ;
            padding:8px;
            background-color:#e9ecef  ;
        }

        .table-bordered tr td{
            border:1px solid #adb5bd;
            padding:8px;
        }

        .my-5{
            margin-top: 5%;
            margin-bottom: 5%;
        }

        .mx-5{
            margin-left: 5%;
            margin-right: 5%;
        }

    </style>
</head>
<body>
    
    <div class="container">
        <div class="">
            <div class=" mb-5 col-md-12 brand">
                <span class="brand-name">Cybertron Labs (Pvt) Ltd</span>
            </div>
            <div class="payslip-info">
                <div><label>Payslip-</label>{{$data['employee_info']->name}} - {{@date('M Y', strtotime($data['salary']->date))}}</div>
                <div><label>Pay Date:</label> {{@date('d/m/Y')}}</div>
                <div><label>Pay Period:</label> {{@date('F Y')}}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div> <span class="fs-5 fw-bold">Employee Details</span></div>
                <div>{{$data['employee_info']->name}}</div>
                <div>{{$data['employee_info']->designation->title}}</div>
            </div>

            <div class="col-md-6">
                <div class="text-end"><span class="fs-5 fw-bold">Employer Details</span></div>
                <div class="text-end"><span>Cybertron Labs (Pvt) Ltd</span></div>
                <div class="text-end"><span>A29 KDA Scheme 1 Karsaz Road,</span></div>
                <div class="text-end"><span>Karachi, Pakistan</span></div>
            </div>

        </div>

        <div class="row" style="margin-top:2%;">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead class="bg-gray">
                        <tr>
                            <th style="width:50%" class="text-start">Earnings</th>
                            <th style="width:50%" class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic Pay</td>
                            <td class="text-end">64,300.00</td>
                        </tr>
                        <tr>
                            <td>Travel Allowance</td>
                            <td class="text-end">5,000.00</td>
                        </tr>
                        <tr>
                            <td>Medical Allowance</td>
                            <td class="text-end">700.00</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead class="bg-gray">
                        <tr>
                            <th style="width:50%" class="text-start">Deductions</th>
                            <th style="width:50%" class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ _trans('common.Absent Deduction') }}</td>
                            <td class="text-end">{{ (@$data['salary']->absent_amount) }}</td>
                        </tr>
                        <tr>
                            <td>{{ _trans('common.Late Deduction') }}</td>
                            <td class="text-end">{{ (@$data['salary']->late_deductions_amount) }}</td>
                        </tr>
                        <tr>
                            <td> {{ _trans('common.Half-Day Deduction') }}</td>
                            <td class="text-end">{{ (@$data['salary']->half_day_deductions_amount) }}</td>
                        </tr>
                        <tr>
                            <td>{{ _trans('common.Loan') }}</td>
                            <td class="text-end">{{ (@$data['salary']->advance_amount) }}</td>
                        </tr>
                        <tr>
                            <td>{{ _trans('common.Tax') }}</td>
                            <td class="text-end">{{ (@$data['salary']->employee->tax) }}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead class="bg-gray">
                        <tr>
                            <th style="width:50%" class="text-start"> {{ _trans('common.Total Pay') }}</th>
                            <th style="width:50%" class="text-end">PKR {{ (number_format($data['salary']->net_salary, 2)) }}</th>
                        </tr>
                        <tr>
                            <th style="width:50%" class="text-start"> {{ _trans('common.Total Pay in Words') }}</th>
                            <th style="width:50%" class="text-end">{{ numberTowords($data['salary']->net_salary) }} PKR</th>
                        </tr>

                    </thead>
                </table>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-md-6">
                <div> <span class="fs-5 fw-bold">Payment Details</span></div>
                <div>Payment made to employee's bank account.</div>
                <div>Employee Signature</div>
            </div>
            <div class="col-md-6" style="display:flex; justify-content:end; align-items:center;">
                <div class="text-end w-100">Employee Signature</div>
            </div>

            
        </div>

        <div class="col-md-12" style="display:flex; justify-content:center; align-items:center;">
            <div>This is a system generated payslip.</div>
        </div>
    </div>

</body>
</html>