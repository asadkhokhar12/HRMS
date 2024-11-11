@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '' => _trans('common.Payroll'),
        '#' => @$data['title'],
    ]) !!}

    <div class="table-content table-basic">

        <div class="card">
            <div class="card-header">
                <h3>
                    {{ _trans('common.Download Salary Sheet') }}
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('hrm.monthly.salary.table') }}" method="post">
                    @csrf
                    <div class="" data-select2-id="698">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"> {{ _trans('common.Month') }}
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="month" id="salary_month"
                                            class="form-control ot-form-control ot-input date" name="month"
                                            value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"> {{ _trans('common.Department') }} </label>
                                    {{-- <span class="" id="dipertment_loading" style="display: none"  disabled>
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Loading...
                                        </span> --}}
                                    <select name="department" id="department_id"
                                        class="form-control ot-form-control ot-input select2">
                                        <option value="0">{{ _trans('Common.All Department') }} </option>
                                        @foreach ($data['departments'] as $department)
                                            <option value="{{ $department->id }}">{{ $department->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 justify-content-end" style="margin-top:27px">
                                <button type="submit" class="btn btn-gradian">
                                    {{ _trans('common.Download') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .salary_input {
            background-color: transparent;
            width: 100px;
            border: none;
        }

        .shadow_input {
            color: transparent;
        }
    </style>
    @if (isset($data['salarySheet']))
        <div class="table-content table-basic">

            <div class="card mt-20">
                <div class="card-header">
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2">
                            <button id="export_button" class="btn btn-md btn-primary" onclick="tableToCSV()"><i
                                    class="fa fa-csv"></i> Export</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="company_name" value="{{ base_settings('company_name') }}">
                <input type="hidden" id="sub_title" value="{{ @$data['sub_title'] }}">
                <div class="card-body">
                    <div class="table-responsive  min-height-500">

                        <table class="table table-striped table-bordered text-center align-middle">
                            <thead class="thead-dark">
                                <tr>
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td colspan="9">

                                    </td>
                                    <th colspan="5">
                                        Addition
                                    </th>
                                    <th colspan="3">
                                        Deduction
                                    </th>
                                    <th>

                                    </th>
                                </tr> --}}
                                <tr>
                                    <th>Sl.</th>
                                    <th>Name of Employee</th>
                                    <th>Designation</th>
                                    <th>Work Days</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Tardy</th>
                                    <th>Tardy Dates</th>
                                    <th>Gross Salary</th>
                                    @php
                                        $additions = $data['commissions']->where('type', 1);
                                    @endphp
                                    @foreach ($additions as $addition)
                                        <th>{{ @$addition->name }}
                                            @if ($addition->mode == 2)
                                                {{ @$addition->amount != 0 ? $addition->amount : '' }}(%)
                                            @endif
                                        </th>
                                    @endforeach

                                    <th>Incentives</th>

                                    <th>Absent</th>
                                    <th>Advance</th>
                                    <th>Tardy Amount</th>

                                    <th>Net Payable</th>
                                </tr>
                                @forelse ($data['salarySheet'] as $key => $salary)
                                    <tr>
                                        <td> {{ @$salary['user_id'] }}</td>
                                        <td> {{ @$salary['user_name'] }}</td>
                                        <td> {{ @$salary['user_designation'] }}</td>
                                        <td>
                                            <span style="display:none"
                                                id="total_working_days{{ @$salary['user_id'] }}">{{ @$salary['total_working_days'] }}</span>
                                            {{ @$salary['total_working_days'] }}
                                        </td>
                                        <td> {{ @$salary['total_present'] }}</td>
                                        <td> {{ @$salary['total_absent'] }}</td>
                                        <td>
                                            <span class="shadow_input " data-id="{{ @$salary['user_id'] }}"
                                                id="s_tardy_input_{{ @$salary['user_id'] }}"></span>
                                            <input class="salary_input tardy_input" type="number" {{-- value="{{ @$salary['total_late'] }}" --}}
                                                data-id="{{ @$salary['user_id'] }}"
                                                data-shadow="s_tardy_input_{{ @$salary['user_id'] }}" step="any"
                                                id="tardy_{{ @$salary['user_id'] }}">
                                        </td>
                                        <td> {{ @$salary['late_dates'] }}</td>
                                        <td>
                                            <span
                                                style="display:none"id="gross_salary{{ @$salary['user_id'] }}">{{ @$salary['gross_salary'] }}</span>
                                            {{ @$salary['gross_salary'] }}
                                        </td>
                                        @foreach ($salary['addition_detail'] as $addition)
                                            <td> {{ @$addition['amount'] }} </td>
                                        @endforeach
                                        <td>
                                            <span class="shadow_input addition_input" data-id="{{ @$salary['user_id'] }}"
                                                data-addition_input="{{ @$salary['user_id'] }}"
                                                id="s_incenntive_{{ @$salary['user_id'] }}"></span>
                                            <input class="salary_input" type="number" data-id="{{ @$salary['user_id'] }}"
                                                data-shadow="s_incenntive_{{ @$salary['user_id'] }}" step="any"
                                                id="incenntive_{{ @$salary['user_id'] }}">
                                        </td>
                                        <td>
                                            <span class="shadow_input deduction_input" data-id="{{ @$salary['user_id'] }}"
                                                data-deduction_input="{{ @$salary['user_id'] }}"
                                                id="s_absent_{{ @$salary['user_id'] }}"></span>
                                            <input class="salary_input" type="number" data-id="{{ @$salary['user_id'] }}"
                                                data-shadow="s_absent_{{ @$salary['user_id'] }}" step="any"
                                                id="absent_{{ @$salary['user_id'] }}">
                                        </td>
                                        <td>
                                            <span class="shadow_input deduction_input" data-id="{{ @$salary['user_id'] }}"
                                                data-deduction_input="{{ @$salary['user_id'] }}"
                                                id="s_advance_{{ @$salary['user_id'] }}">
                                                {{ @$salary['installment'] }}
                                            </span>
                                            <input class="salary_input" type="number" data-id="{{ @$salary['user_id'] }}"
                                                data-shadow="s_advance_{{ @$salary['user_id'] }}"
                                                value="{{ @$salary['installment'] }}" step="any"
                                                id="advance_{{ @$salary['user_id'] }}">
                                        </td>
                                        <td>
                                            <span class="shadow_input deduction_input" data-id="{{ @$salary['user_id'] }}"
                                                data-deduction_input="{{ @$salary['user_id'] }}"
                                                id="s_tardy_amount_{{ @$salary['user_id'] }}"></span>
                                            <input class="salary_input" type="number" data-id="{{ @$salary['user_id'] }}"
                                                data-shadow="s_tardy_amount_{{ @$salary['user_id'] }}" step="any"
                                                id="tardy_amount_{{ @$salary['user_id'] }}">
                                        </td>
                                        <td>
                                            <span style="display:none"
                                                id="primary_net_salary{{ @$salary['user_id'] }}">{{ @$salary['gross_salary'] }}</span>
                                            <span id="net_salary{{ @$salary['user_id'] }}">
                                                {{ @$salary['net_salary'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="17">
                                        Salary Not Generated Yet
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection
@section('script')
    <script>
        function download_csv(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV FILE
            csvFile = new Blob([csv], {
                type: "text/csv"
            });

            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // We have to create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Make sure that the link is not displayed
            downloadLink.style.display = "none";

            // Add the link to your DOM
            document.body.appendChild(downloadLink);

            // Lanzamos
            downloadLink.click();
        }

        function export_table_to_csv(html, filename) {
            var csv = [];
            var rows = document.querySelectorAll("table tr");
            var company_name = document.getElementById('company_name').value;
            var sub_title = document.getElementById('sub_title').value;
            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll("td, th");
                // add document header to csv center align
                if (i == 0) {
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push(company_name);
                }
                if (i == 1) {
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push(sub_title);
                }
                if (i == 2) {
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("Addition");
                    row.push("");
                    row.push("");
                    row.push("");
                    row.push("Deduction");
                }
               
                for (var j = 0; j < cols.length; j++)
                    row.push(cols[j].innerText);

                csv.push(row.join(","));
            }
            // Download CSV
            download_csv(csv.join("\n"), filename);
        }

        document.querySelector("#export_button").addEventListener("click", function() {
            var html = document.querySelector("table").outerHTML;
            export_table_to_csv(html, "salary_sheet.csv");
        });

        //select all same class input
        function selectAllInput(InputclassName) {
            var inputs = document.getElementsByClassName(InputclassName);
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].select();
            }
        }



        $(".tardy_input").on('keyup', function() {
            var id = $(this).data('id');
            var shadow = $(this).data('shadow');
            var input_value = $(this).val();

            var total_working_days = $("#total_working_days" + id).text();
            var gross_salary = $("#gross_salary" + id).text();
            var tardy_amount_ = $("#tardy_amount_" + id);
            var tardy_amount_shadow = $("#s_tardy_amount_" + id);
            var tardy = $(this).val();

            var tardy_deduction = 0;
            tardy_deduction = parseFloat(gross_salary) / parseFloat(total_working_days) * tardy;
            tardy_deduction = tardy_deduction.toFixed(2);
            tardy_amount_.val(tardy_deduction);
            tardy_amount_shadow.text(tardy_deduction);
            console.log(tardy_deduction);

            calculateData(id, shadow, input_value);

        });
        $(".salary_input").on('keyup', function() {
            // $('.salary_input').change(function() {

            var id = $(this).data('id');
            var shadow = $(this).data('shadow');
            var input_value = $(this).val();
            // console.log(shadow);
            calculateData(id, shadow, input_value);

        });

        function calculateData(id, shadow, input_value) {


            var primary_net_salary = parseFloat($("#primary_net_salary" + id).text());
            // console.log(primary_net_salary);
            var net_salary = primary_net_salary;
            net_salary = parseFloat(net_salary);

            if (shadow) {
                $("#" + shadow).text(input_value);
            }

            var deduction_input = document.querySelectorAll('[data-deduction_input="' + id + '"]');

            var deduction_amount = 0;
            for (var i = 0; i < deduction_input.length; i++) {
                var deduction_id = deduction_input[i].id;
                var deduction_value = $("#" + deduction_id).text();
                if (deduction_value) {
                    deduction_amount = parseFloat(deduction_amount) + parseFloat(deduction_value);
                }
            }

            var addition_input = document.querySelectorAll('[data-addition_input="' + id + '"]');

            var addition_amount = 0;
            for (var i = 0; i < addition_input.length; i++) {
                var addition_id = addition_input[i].id;
                var addition_value = $("#" + addition_id).text();
                if (addition_value) {
                    addition_amount = parseFloat(addition_amount) + parseFloat(addition_value);
                }
            }
            // console.log(addition_amount);
            // console.log('net_salary : ' + net_salary);
            // console.log(deduction_amount);
            net_salary = parseFloat(net_salary) + parseFloat(addition_amount) - parseFloat(deduction_amount);
            net_salary = net_salary.toFixed(2);
            // console.log('calculate_net_salary : ' + net_salary);
            $("#net_salary" + id).text(net_salary);
        }

















        $(document).ajaxStart(function() {
            $("#dipertment_loading").show();
        }).ajaxStop(function() {
            $("#dipertment_loading").hide();
        });

        //check salary_month select or not
        $(document).ready(function() {
            $('#department_id').on('change', function() {
                var month = $('#salary_month').val();
                if (month == '') {
                    alert('Please Select Month');
                    $('#department_id').select2('val', '');
                }
            });
        });
    </script>
@endsection
