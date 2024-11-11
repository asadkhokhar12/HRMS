@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('style')
    <style>
        /* Style for order track step */
        .order-track-step {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        /* Style for order track status dot */
        .order-track-status-dot {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            width: 12px;
            height: 12px;
            background-color: #3498db;
            border-radius: 50%;
            z-index: 1;
        }

        /* Style for order track status line */
        .order-track-status-line {
            position: absolute;
            top: 50%;
            left: 6px;
            transform: translateY(-50%);
            height: 100%;
            width: 2px;
            background-color: #3498db;
            z-index: 0;
        }

        /* Style for order track text */
        .order-track-text {
            flex: 3;
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .timeline-info {
            padding: 12px;
        }
    </style>
@endsection
@section('content')

    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    <div class="content-wrapper dashboard-wrapper mt-30">
        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30">
                <div class="row  mb-15">

                    <div class="col-md-4 col-xl-4 col-lg-4 ">
                        <div class="card border-0">
                            <div class="breadcrumb-warning d-flex justify-content-between ot-card">
                                <h3>{{ _trans('common.Schedules') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="order-track">
                                    <div class="profile-menu mb-3">
                                        <div class="table-basic table-content ">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="profile-menu-head">
                                                        <h4>{{ _trans('common.Created By') }}</h4>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 me-3 w-60 h-60">
                                                                <img class="img-fluid rounded-circle w-100 h-100"
                                                                    src="{{ uploaded_asset(@$data['visit']->user->avatar_id) }}"
                                                                    width="60" alt="profile image" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="body">
                                                                    <h2 class="title">{{ @$data['visit']->user->name }}
                                                                    </h2>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($data['visit']->schedules as $item)
                                        <div class="order-track-step">
                                            {{-- <div class="timeline-info">
                                                <p class="timeline-info__date"></p>
                                                <p class="timeline-info__time"></p>
                                            </div>
                                            <div class="order-track-status">
                                                <span class="order-track-status-dot"></span>
                                                <span class="order-track-status-line"></span>
                                            </div> --}}
                                            <div class="w-100">
                                                <div class="table-content table-basic">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="javascript:void(0)"
                                                                onclick="getRouteInfo(`{{ $item->latitude }},{{ $item->longitude }}`)">
                                                                <div class="">
                                                                    <div class="d-flex justify-content-between mb-3">

                                                                        <div>{{ $item->title }}</div>
                                                                        <div class="badge badge-success">{{ $item->status }}
                                                                        </div>
                                                                    </div>


                                                                    <p class="order-track-text-sub">latitude:
                                                                        {{ $item->latitude }}
                                                                    </p>
                                                                    <p class="order-track-text-sub">longitude:
                                                                        {{ $item->longitude }}</p>
                                                                    <p class="order-track-text-sub">Location:
                                                                        {{ $item->location }}
                                                                    </p>
                                                                    @if ($item->reached_at)
                                                                        <p class="order-track-text-sub">Started
                                                                            At:{{ $item->started_at }}</p>
                                                                    @endif
                                                                    @if ($item->reached_at)
                                                                        <p class="order-track-text-sub">Reached At:
                                                                            {{ $item->reached_at }} </p>
                                                                    @endif
                                                                    @if ($item->note)
                                                                        <p class="order-track-text-sub">Note:
                                                                            {{ $item->note }}</p>
                                                                    @endif
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4 col-xl-4 col-lg-4 ">
                        <div class="table-content table-basic">
                            <div class="card">
                                <div class="card-header">
                                    <h3>{{ _trans('common.Notes') }}</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="thead">
                                            <th>SL</th>
                                            <th>Note</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['visit']->notes as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->note }}</td>
                                                    <td>{{ $item->status }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 col-xl-4 col-lg-4 ">
                        <div class="table-content table-basic">
                            <div class="card">
                                <div class="card-header">
                                    <h3>{{ _trans('common.Images') }}</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="thead">
                                            <th>SL</th>
                                            <th>Image</th>
                                            <th>Cteated At</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['visit']->visitImages as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td class="w-50"><img
                                                            src="{{ uploaded_asset(@$item->imageable_id) }}" alt=""
                                                            class="staff-profile-image-small"></td>
                                                    <td>{{ $item->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-7 col-xl-7 col-lg-7 ">

                        <div class="card d-none">
                            <div class="card-body">
                                <div class="ltn__map-area">
                                    <div class="ltn__map-inner">
                                        <div id="map" class="height_600"></div>
                                        <div id="directions_panel"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <input type="text" hidden id="data_url" value="{{ @$data['url'] }}">
@endsection
@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ @api_setup('google', 'key') }}" async defer></script>
    <script src="{{ global_asset('js/googleMap.js') }}"></script>
@endsection
