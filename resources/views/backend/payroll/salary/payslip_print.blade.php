<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payslip</title>

    <style>
        /* General Styles */
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #343a40;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        .brand {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .text-end {
            text-align: right;
        }

        .payslip-info div {
            margin-bottom: 4px;
        }

        /* Row and Column */
        .row {
            display: table;
            width: 100%;
        }

        .col-md-6 {
            display: table-cell;
            width: 50%;
            padding: 0 5px;
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px;
        }

        .table th,
        .table td {
            padding: 4px 6px;
            font-size: 12px;
            text-align: left;
            border: 1px solid #adb5bd;
        }

        .table th {
            background-color: #e9ecef;
            font-weight: bold;
            /* border-left: none; */
            border: none
                /* border-right: none; */
        }

        .table td.amount,
        .table th.amount {
            text-align: right;
            width: 30%;
        }

        /* Footer */
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
        }

        .title {
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="title">Cybertron Labs (Pvt) Ltd</div>
        <div class="payslip-info">
            <div><label>Payslip: </label> {{ $data['employee_info']->name }} -
                {{ date('M Y', strtotime($data['salary']->date)) }}</div>
            <div><label>Pay Date: </label> {{ date('10/m/Y') }}</div>
            <div><label>Pay Period: </label> {{ date('F Y') }}</div>
        </div>

        <!-- Employee and Employer Details -->
        <div class="row">
            <div class="col-md-6">
                <div><strong>Employee Details</strong></div>
                <div>{{ $data['employee_info']->name }}</div>
                <div>{{ $data['employee_info']->designation->title }}</div>
            </div>
            <div class="col-md-6 text-end">
                <div><strong>Employer Details</strong></div>
                <div>Cybertron Labs (Pvt) Ltd</div>
                <div>A29 KDA Scheme 1, Karsaz Road</div>
                <div>Karachi, Pakistan</div>
            </div>
        </div>

        <!-- Earnings Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Earnings</th>
                    <th class="amount">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic Pay</td>
                    <td class="amount">{{ $data['salary']->gross_salary }}</td>
                </tr>
                {{-- <tr>
                    <td>Travel Allowance</td>
                    <td class="amount">5,000.00</td>
                </tr>
                <tr>
                    <td>Medical Allowance</td>
                    <td class="amount">700.00</td>
                </tr> --}}
            </tbody>
        </table>

        <!-- Deductions Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Deductions</th>
                    <th class="amount">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['salary']->absent_amount > 0)
                    <tr>
                        <td>Absent Deduction</td>
                        <td class="amount">{{ $data['salary']->absent_amount }}</td>
                    </tr>
                @endif
                @if ($data['salary']->late_deductions_amount > 0)
                    <tr>
                        <td>Late Deduction</td>
                        <td class="amount">{{ $data['salary']->late_deductions_amount }}</td>
                    </tr>
                @endif
                @if ($data['salary']->half_day_deductions_amount > 0)
                    <tr>
                        <td>Half-Day Deduction</td>
                        <td class="amount">{{ $data['salary']->half_day_deductions_amount }}</td>
                    </tr>
                @endif
                @if ($data['salary']->advance_amount > 0)
                    <tr>
                        <td>Loan</td>
                        <td class="amount">{{ $data['salary']->advance_amount }}</td>
                    </tr>
                @endif
                @if ($data['salary']->employee->tax > 0)
                    <tr>
                        <td>Tax</td>
                        <td class="amount">{{ $data['salary']->employee->tax }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @if ($data['salary']->adjust > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Adjustment</th>
                        <th class="amount">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Adjust Amount</td>
                        <td class="amount">{{ $data['salary']->adjust }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        <!-- Total Pay -->
        <table class="table">
            <thead>
                <tr>
                    <th colspan="12">Total Pay</th>
                    <th colspan="12" class="amount">PKR {{ number_format($data['salary']->net_salary, 2) }}</th>
                </tr>
                <tr>
                    <th colspan="12">Total Pay in Words</th>
                    <th colspan="12" class="amount">
                        {{ Str::ucfirst(numberTowords_2(floor($data['salary']->net_salary))) }} <br> PKR</th>
                </tr>
            </thead>
        </table>

        <!-- Footer Section -->
        <div class="row" style="margin-top: 20px">
            <div class="col-md-6">
                <div><strong>Payment Details</strong></div>
                <div>Payment made to employee's bank account.</div>
            </div>
            <div class="col-md-6 text-end">
                <div>Employee Signature</div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="footer">
            This is a system-generated payslip.
        </div>
    </div>
</body>

</html>
