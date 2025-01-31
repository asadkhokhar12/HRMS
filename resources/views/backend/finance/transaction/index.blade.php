@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    

    <div class="row mb-3">
        @foreach($data['accounts'] as $account)
        
        <div class="col-sm-4 col-xl-2 mb-2 mb-xl-0">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <div class="p-1">
                            <label class="fw-bold fs-6">Name:</label>
                            <span class="fw-bold">{{$account->name}}</span>
                        </div>
                        <div class="p-1">
                            <label class="fw-bold fs-6">Acc name:</label>
                            <span class="fw-bold">{{$account->ac_name}}</span>
                        </div>
                        <div class="p-1">
                            <label  class="fw-bold fs-6">Balance:</label>
                            <span class="fw-bold">{{ number_format($account->amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
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
                                    <select class="form-select d-inline-block" id="entries"
                                        onchange="transactionDatatable()">
                                        @include('backend.partials.tableLimit')
                                    </select>
                                    <span class="ml-8">{{ _trans('common.Entries') }}</span>
                                </label>
                            </div>



                            <div class="align-self-center d-flex flex-wrap gap-2">
                                <div class="align-self-center">
                                    <button type="button" class="btn-daterange" id="daterange" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="{{ _trans('common.Date Range') }}">
                                        <span class="icon"><i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                        <span class="d-none d-xl-inline">{{ _trans('common.Date Range') }}</span>
                                    </button>
                                    <input type="hidden" id="daterange-input" onchange="transactionDatatable()">
                                </div>

                                <div class="align-self-center">
                                    <div class="dropdown dropdown-designation" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="{{ _trans('account.Accounts') }}">
                                        <button type="button" class="btn-designation" data-bs-toggle="dropdown"
                                            aria-expanded="false" data-bs-auto-close="false">
                                            <span class="icon"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                                            <span class="d-none d-xl-inline">{{ _trans('account.Accounts') }}</span>
                                        </button>

                                        <div class="dropdown-menu align-self-center ">
                                            <select name="account" id="account" class="form-control select2 "
                                                onchange="transactionDatatable()">
                                                <option value="0">{{ _trans('common.Choose Account') }}</option>
                                                @if (@$data['accounts'])
                                                    @foreach ($data['accounts'] as $account)
                                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-self-center">
                                    <div class="dropdown dropdown-designation" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="{{ _trans('common.Type') }}">
                                        <button type="button" class="btn-designation" data-bs-toggle="dropdown"
                                            aria-expanded="false" data-bs-auto-close="false">
                                            <span class="icon"><i class="fa fa-tag" aria-hidden="true"></i></span>
                                            <span class="d-none d-xl-inline">{{ _trans('common.Type') }}</span>
                                        </button>

                                        <div class="dropdown-menu align-self-center ">
                                            <select name="transaction_type" id="transaction_type"
                                                class="form-control select2 " onchange="transactionDatatable()">
                                                <option value="0">{{ _trans('common.Select Transaction') }}</option>
                                                <option value="18">{{ _trans('common.Paid') }}</option>
                                                <option value="19">{{ _trans('common.Received') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>



                                <!-- search -->
                                <div class="align-self-center">
                                    <div class="search-box d-flex">
                                        <input class="form-control" placeholder="{{ _trans('common.Search') }}"
                                            name="search" onkeyup="transactionDatatable()" autocomplete="off">
                                        <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- export -->
                    @include('backend.partials.buttons')
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
