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
                                    <select class="form-select d-inline-block" id="entries" onchange="roleDatatable()">
                                        <option selected value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span class="ml-8">{{ _trans('common.Entries') }}</span>
                                </label>
                            </div>

                            <div class="align-self-center d-flex flex-wrap gap-2">
                                <!-- add btn -->
                                @if (hasPermission('role_create'))
                                    <div class="align-self-center">
                                        <a href="javascript:;" role="button" class="btn-add" data-bs-toggle="tooltip"
                                            onclick="mainModalOpen(`{{ route('branch.create_modal') }}`)"
                                            data-bs-placement="right" data-bs-title="{{ _trans('common.Add') }}">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                            <span class="d-none d-xl-inline">{{ _trans('common.Create') }}</span>
                                        </a>
                                    </div>
                                @endif
                                <!-- daterange -->
                            </div>
                            <!-- search -->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <input class="form-control" placeholder="{{ _trans('common.Search') }}" name="search"
                                        onkeyup="roleDatatable()" autocomplete="off" />
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
                                                onclick="tableAction('active', `{{ route('roles.statusUpdate') }}`)"><span
                                                    class="icon mr-10"><i class="fa-solid fa-eye"></i></span>
                                                {{ _trans('common.Activate') }} <span class="count">(0)</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" aria-current="true"
                                                onclick="tableAction('inactive',`{{ route('roles.statusUpdate') }}`)">
                                                <span class="icon mr-8"><i class="fa-solid fa-eye-slash"></i></span>
                                                {{ _trans('common.Inactive') }} <span class="count">(0)</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                onclick="tableAction('delete', `{{ route('roles.delete_data') }}`)">
                                                <span class="icon mr-16"><i class="fa-solid fa-trash-can"></i></span>
                                                {{ _trans('common.Delete') }} <span class="count">(0)</span>
                                            </a>
                                        </li>
                                    </ul>
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
