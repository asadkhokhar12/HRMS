@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    <input type="text" hidden id="is_income" value="{{ @$data['is_income'] }}">
    <div class="table-content table-basic">
        <div class="card">

            <div class="card-body">
                <!-- toolbar table start -->
                <div
                    class="table-toolbar d-flex flex-wrap gap-2 flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3">
                    <div class="align-self-center">
                        <div class="d-flex flex-wrap gap-2  flex-lg-row justify-content-center align-content-center">
                            <!-- show per page -->
                            <div class="align-self-center">
                                <label>
                                    <span class="mr-8">{{ _trans('common.Show') }}</span>
                                    <select class="form-select d-inline-block" id="entries" onchange="projectListTable()">
                                        @include('backend.partials.tableLimit')
                                    </select>
                                    <span class="ml-8">{{ _trans('common.Entries') }}</span>
                                </label>
                            </div>

                            <div class="align-self-center d-flex flex-wrap gap-2">
                                <!-- add btn -->
                                <div class="align-self-center">
                                    @if (hasPermission('project_create'))
                                        <a href="{{ route('project.create') }}" role="button" class="btn-add"
                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                            data-bs-title="{{ _trans('common.Create') }}">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                            <span class="d-none d-xl-inline"> {{ _trans('common.Create') }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="align-self-center">
                                <button type="button" class="btn-daterange" id="daterange" data-bs-toggle="tooltip"
                                    data-bs-placement="right" data-bs-title="{{ _trans('common.Date Range') }}">
                                    <span class="icon"><i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                    <span class="d-none d-xl-inline">{{ _trans('common.Date Range') }}</span>
                                </button>
                                <input type="hidden" id="daterange-input" onchange="projectListTable()">
                            </div>

                            <div class="align-self-center">
                                <div class="dropdown dropdown-designation" data-bs-toggle="tooltip"
                                    data-bs-placement="right" data-bs-title="{{ _trans('common.Status') }}">
                                    <button type="button" class="btn-designation" data-bs-toggle="dropdown"
                                        aria-expanded="false" data-bs-auto-close="false">
                                        <span class="icon"><i class="fa-solid fa-tag"></i>
                                        </span>
                                        <span class="d-none d-xl-inline">{{ _trans('common.Status') }}</span>
                                    </button>

                                    <div class="dropdown-menu align-self-center ">
                                        <select name="status" id="status" onchange="projectListTable()"
                                            class="form-control select2 custom-select-width">
                                            <option value="0" disabled selected>{{ _trans('common.Select Status') }}
                                            </option>
                                            <option value="24">{{ _trans('common.Not Started') }}</option>
                                            <option value="25">{{ _trans('common.On Hold') }}</option>
                                            <option value="26">{{ _trans('common.In Progress') }}</option>
                                            <option value="27">{{ _trans('common.Completed') }}</option>
                                            <option value="28">{{ _trans('common.Cancelled') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="align-self-center">
                                <div class="dropdown dropdown-designation" data-bs-toggle="tooltip"
                                    data-bs-placement="right" data-bs-title="{{ _trans('common.Priority') }}">
                                    <button type="button" class="btn-designation" data-bs-toggle="dropdown"
                                        aria-expanded="false" data-bs-auto-close="false">
                                        <span class="icon"><i class="fa fa-arrow-up" aria-hidden="true"></i>
                                        </span>
                                        <span class="d-none d-xl-inline">{{ _trans('common.Priority') }}</span>
                                    </button>
                                    <div class="dropdown-menu align-self-center ">
                                        <select name="priority" id="priority"
                                            class="form-control select2 custom-select-width" onchange="projectListTable()">
                                            <option value="0" disabled selected>{{ _trans('common.Select Priority') }}
                                            </option>
                                            <option value="32">{{ _trans('project.Low') }}</option>
                                            <option value="31">{{ _trans('project.Medium') }}</option>
                                            <option value="30">{{ _trans('project.High') }}</option>
                                            <option value="29">{{ _trans('project.Urgent') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="align-self-center">
                                <div class="dropdown dropdown-designation" data-bs-toggle="tooltip"
                                    data-bs-placement="right" data-bs-title="{{ _trans('common.Payment') }}">
                                    <button type="button" class="btn-designation" data-bs-toggle="dropdown"
                                        aria-expanded="false" data-bs-auto-close="false">
                                        <span class="icon"><i class="fa fa-credit-card-alt"
                                                aria-hidden="true"></i></span>
                                        <span class="d-none d-xl-inline">{{ _trans('common.Payment') }}</span>
                                    </button>

                                    <div class="dropdown-menu align-self-center ">
                                        <select name="payment" id="payment"
                                            class="form-control select2 custom-select-width"
                                            onchange="projectListTable()">
                                            <option value="0" disabled selected>{{ _trans('common.Payment Status') }}
                                            </option>
                                            <option value="9">{{ _trans('common.Unpaid') }}</option>
                                            <option value="8">{{ _trans('common.Paid') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- search -->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <input class="form-control" placeholder="{{ _trans('common.Search') }}"
                                        name="search" onkeyup="projectListTable()" autocomplete="off" />
                                    <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                            </div>

                            <!-- dropdown action -->
                            <div class="align-self-center">
                                <div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="right"
                                    data-bs-title="{{ _trans('common.Action') }}">
                                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                onclick="tableAction('complete', `{{ $data['status_url'] }}`)"><span
                                                    class="icon mr-10"><i class="fa-solid fa-check-circle"></i>
                                                </span>
                                                {{ _trans('common.Complete') }} <span class="count">(0)</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                onclick="tableAction('delete', `{{ $data['delete_url'] }}`)">
                                                <span class="icon mr-16"><i class="fa-solid fa-trash-can"></i></span>
                                                {{ _trans('common.Delete') }} <span class="count">(0)</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- export -->
                    <div class="align-self-center">
                        <div class="d-flex justify-content-center justify-content-xl-end align-content-center">

                            <div class="dropdown dropdown-export" data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-title="{{ _trans('common.Export') }}">
                                <button type="button" class="btn-export" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="icon"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>

                                    <span class="d-none d-xl-inline">{{ _trans('common.Export') }}</span>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="selectElementContents(document.getElementById('table'))">
                                            <span class="icon mr-8"><i class="fa-solid fa-copy"></i>
                                            </span>
                                            {{ _trans('common.Copy') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportJSON">
                                            <span class="icon mr-8">
                                                <i class="fa-solid fa-code"></i>
                                            </span>
                                            {{ _trans('common.Json File') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="btnExcelExport" href="#"
                                            aria-current="true"><span class="icon mr-10"><i
                                                    class="fa-solid fa-file-excel"></i></span>
                                            {{ _trans('common.Excel File') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportCSV">
                                            <span class="icon mr-14"><i class="fa-solid fa-file-csv"></i></span>
                                            {{ _trans('common.Csv File') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="exportPDF">
                                            <span class="icon mr-14"><i class="fa-solid fa-file-pdf"></i></span>
                                            {{ _trans('common.Pdf File') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- toolbar table end -->
                <!--  table start -->
                <div class="table-responsive  min-height-500">

                    @include('backend.partials.table')

                </div>
                <!--  table end -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('backend.partials.table_js')
@endsection
