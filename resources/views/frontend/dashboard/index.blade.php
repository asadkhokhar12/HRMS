@extends('frontend.includes.master')
@section('style')
    <style>
        body:not(.sidebar-mini-md) .content-wrapper,
        body:not(.sidebar-mini-md) .main-footer,
        body:not(.sidebar-mini-md) .main-header {
            margin-left: 0px !important;
        }


        .card-box .icon img {
            max-width: 30px;
            max-height: 30px;
        }

        .card-header.row.gutters-5 {
            border: 0;
            background-color: transparent;
        }


        .apexcharts-menu-icon {
            display: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $data['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ _trans('common.Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ $data['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">

                <div class="ltn__product-tab-area">
                    <div class="row">
                        @include('frontend.includes.employee_sidebar')


                        <div class="col-lg-12 col-xl-9">
                            <div class="card">
                                <div class="card-header row gutters-5">
                                    <div class="col-6 col-md-6 col-lg-8 col-xl-8">
                                        <h5 class="mb-0 mt-2 h6">{{ _trans('common.Statistics') }} &amp;
                                            {{ _trans('common.Analysis') }}</h5>
                                    </div>

                                </div>

                                <div class="card-body row gutters-10">
                                    @foreach ($data['dashboardMenus']['today'] as $item)
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                            <div class="card-box style-2 mb-4 rounded-lg new-rounded white-bg">
                                                <div class="icon badge-circle-bg-ash">
                                                    <img src="{{ $item['image'] }}" alt="sale">
                                                </div>
                                                <div class="inner">
                                                    <div class="card-box-title">
                                                        <p class="">{{ $item['title'] }}</p>
                                                        <h3 class="all-amount mb-0" id="totalSaleAmount">
                                                            {{ $item['number'] }}</h3>
                                                    </div>
                                                    <!-- Average report percentage growth up -->

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <h3>{{ _trans('common.Current month') }}</h3>
                                    @foreach ($data['dashboardMenus']['current_month'] as $item)
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                            <div class="card-box style-2 mb-4 rounded-lg new-rounded white-bg">
                                                <div class="icon badge-circle-bg-ash">
                                                    <img src="{{ $item['image'] }}" alt="sale">
                                                </div>
                                                <div class="inner">
                                                    <div class="card-box-title">
                                                        <p class="">{{ $item['title'] }}</p>
                                                        <h3 class="all-amount mb-0" id="totalSaleAmount">
                                                            {{ $item['number'] }}</h3>
                                                    </div>
                                                    <!-- Average report percentage growth up -->

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="card">
                                <div class="card-header row gutters-5">
                                    <div class="col-6 col-md-6 col-lg-8 col-xl-8">
                                        <h5 class="mb-0 mt-2 h6">{{ _trans('common.Employee Activity') }}</h5>
                                    </div>

                                </div>
                                <div class="card-body row gutters-10 align-items-baseline">
                                    <div class="col-md-12 col-sm-12 col-lg-7 col-xl-7">
                                        <div id="employeeActivityChart1"></div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-lg-5 col-xl-5">
                                        <div id="employeeActivityChart2"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ global_asset('frontend/js/dashboard.js') }}"></script>
@endsection
