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
                                    <select class="form-select d-inline-block" id="entries" onchange="salaryDatatable()">
                                        @include('backend.partials.tableLimit')
                                    </select>
                                    <span class="ml-8">{{ _trans('common.Entries') }}</span>
                                </label>
                            </div>



                            <div class="align-self-center d-flex flex-wrap gap-2">
                                <div class="align-self-center">
                                    @if (hasPermission('advance_salaries_create'))
                                        <a href="javascript:;" role="button" class="btn-add" data-bs-toggle="tooltip"
                                            data-bs-placement="right" data-bs-title="{{ _trans('common.Generate') }}"
                                            onclick="mainModalOpen(`{{ @$data['salary_generate'] }}`)">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                            <span class="d-none d-xl-inline"> {{ _trans('common.Generate') }}</span>
                                        </a>
                                    @endif
                                </div>
                                <div class="align-self-center">
                                    <button type="button" class="btn-daterange" id="daterange" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="{{ _trans('common.Date Range') }}">
                                        <span class="icon"><i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                        <span class="d-none d-xl-inline">{{ _trans('common.Date Range') }}</span>
                                    </button>
                                    <input type="hidden" id="daterange-input" onchange="salaryDatatable()">
                                </div>
                                <!-- Designation -->
                                <div class="align-self-center">
                                    <div class="dropdown dropdown-designation" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="{{ _trans('common.Designation') }}">
                                        <button type="button" class="btn-designation" data-bs-toggle="dropdown"
                                            aria-expanded="false" data-bs-auto-close="false">
                                            <span class="icon"><i class="fa-solid fa-user-shield"></i></span>

                                            <span class="d-none d-xl-inline">{{ _trans('common.Department') }}</span>
                                        </button>

                                        <div class="dropdown-menu align-self-center ">
                                            <select name="department_id" id="department_id"
                                                class="form-control pl-2 select2 w-100" onchange="salaryDatatable()">
                                                <option value="0" disabled selected>
                                                    {{ _trans('common.Select department') }}</option>
                                                @foreach ($data['departments'] as $role)
                                                    <option value="{{ $role->id }}">{{ @$role->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="align-self-center">
                                    <div class="dropdown dropdown-designation" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="{{ _trans('common.Status') }}">
                                        <button type="button" class="btn-designation" data-bs-toggle="dropdown"
                                            aria-expanded="false" data-bs-auto-close="false">
                                            <span class="icon"><i class="fa fa-tag" aria-hidden="true"></i></span>
                                            <span class="d-none d-xl-inline">{{ _trans('common.Status') }}</span>
                                        </button>

                                        <div class="dropdown-menu  align-self-center ">
                                            <select name="status" id="status" class="form-control select2"
                                                onchange="salaryDatatable()">
                                                <option value="0" selected disabled>{{ _trans('common.Status') }} </option>
                                                <option value="9">{{ _trans('common.Unpaid') }}</option>
                                                <option value="8">{{ _trans('common.Paid') }}</option>
                                                <option value="20">{{ _trans('common.Partially Paid') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <!-- search -->
                                <div class="align-self-center">
                                    <div class="search-box d-flex">
                                        <input class="form-control" placeholder="{{ _trans('common.Search') }}"
                                            name="search" onkeyup="salaryDatatable()" autocomplete="off" />
                                        <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    </div>
                                </div>
                            </div>
                            {{-- exportOnMobileDevice --}}
                            <div class="d-flex d-lg-none">
                                @include('backend.partials.buttons')
                            </div>
                            {{-- exportOnMobileDevice::end --}}
                        </div>
                    </div>
                    <!-- export -->
                    <div class="d-none d-lg-flex">
                        @include('backend.partials.buttons')
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
