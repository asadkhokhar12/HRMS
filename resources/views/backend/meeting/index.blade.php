@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
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
                                    <select class="form-select d-inline-block" id="entries" onchange="meetingTable()">
                                        @include('backend.partials.tableLimit')
                                    </select>
                                    <span class="ml-8">{{ _trans('common.Entries') }}</span>
                                </label>
                            </div>

                            <div class="align-self-center d-flex flex-wrap gap-2">
                                <!-- add btn -->
                                <div class="align-self-center">
                                    @if (hasPermission('meeting_create'))
                                        <a href="{{ route('meeting.create') }}" role="button" class="btn-add"
                                            data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ _trans('common.Add') }}">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                            <span class="d-none d-xl-inline">{{ _trans('common.Create') }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="align-self-center d-flex flex-wrap gap-2">

                                <div class="align-self-center">
                                    <button type="button" class="btn-daterange" id="daterange" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="Date Range">
                                        <span class="icon"><i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                        <span class="d-none d-xl-inline">{{ _trans('common.Date Range') }}</span>
                                    </button>
                                    <input type="hidden" id="daterange-input" onchange="meetingTable()">
                                </div>
                                <!-- search -->
                                <div class="align-self-center">
                                    <div class="search-box d-flex">
                                        <input class="form-control" placeholder="{{ _trans('common.Search') }}"
                                            name="search" onkeyup="meetingTable()" autocomplete="off">
                                        <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                    <!-- export -->
                    <div class="align-self-center">
                        <div class="d-flex justify-content-center justify-content-xl-end align-content-center">

                            <div class="dropdown dropdown-export" data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-title="{{ _trans('common.Export') }}">
                                <button type="button" class="btn-export" data-bs-toggle="dropdown" aria-expanded="false">
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
