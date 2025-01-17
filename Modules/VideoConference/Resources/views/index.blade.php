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
                                    <select class="form-select d-inline-block" id="entries" onchange="conferenceTable()">
                                        @include('backend.partials.tableLimit')
                                    </select>
                                    <span class="ml-8">{{ _trans('common.Entries') }}</span>
                                </label>
                            </div>

                            <div class="align-self-center d-flex flex-wrap gap-2">
                                <!-- add btn -->
                                <div class="align-self-center">
                                    @if (hasPermission('conference_create'))
                                        <a href="{{ route('conference.create') }}" role="button" class="btn-add"
                                            data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ _trans('common.Add') }}">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                            <span class="d-none d-xl-inline">{{ _trans('common.Create') }}</span>
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
                                <input type="hidden" id="daterange-input" onchange="conferenceTable()">
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
                                                onclick="tableAction('active', `{{ route('award.statusUpdate') }}`)"><span
                                                    class="icon mr-10"><i class="fa-solid fa-eye"></i></span>
                                                {{ _trans('common.Activate') }} <span class="count">(0)</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" aria-current="true"
                                                onclick="tableAction('inactive', `{{ route('award.statusUpdate') }}`)">
                                                <span class="icon mr-8"><i class="fa-solid fa-eye-slash"></i></span>
                                                {{ _trans('common.Inactive') }} <span class="count">(0)</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                onclick="tableAction('delete', `{{ route('award.delete_data') }}`)">
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
                    <table class="table table-bordered {{ @$data['class'] }}" id="table">
                        <thead class="thead">
                            <tr>
                                @if (@$data['checkbox'])
                                    <th class="sorting_asc">
                                        <div class="check-box">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="all_check" />
                                            </div>
                                        </div>
                                    </th>
                                @endif
                    
                    
                                @if (@$data['fields'])
                                    @foreach (@$data['fields'] as $field)
                                        <th class="sorting_desc">{{ $field }}</th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                    
                    </table>
                     <input type="text" hidden id="{{ @$data['url_id'] }}" value="{{ @$data['table'] }}">
                    
                </div>
                <!--  table end -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('backend.partials.table_js')
@endsection
