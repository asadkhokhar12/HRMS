@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    <div class="table-content table-basic">

        <!-- Main content -->
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">

                    <div class="col-sm-6">
                    </div>
                </div>

                <div class="row align-items-end  table-filter-data">
                    <div class="col-lg-12">
                        @if (hasPermission('role_read'))

                            <form method="GET" action="#">
                                <div class="row align-items-center">
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <select name="location_pattern" class="form-control select2 mb-3"
                                                onchange="submitForm()">
                                                <option value="1" @if (@$_GET['location_pattern'] == 1) selected @endif>
                                                    {{ _trans('common.Pattern 1') }}</option>
                                                <option value="2" @if (@$_GET['location_pattern'] == 2) selected @endif>
                                                    {{ _trans('common.Pattern 2') }}</option>
                                                <option value="3" @if (@$_GET['location_pattern'] == 3) selected @endif>
                                                    {{ _trans('common.Pattern 3') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <select name="user" class="form-control select2 mb-3"
                                                onchange="submitForm()">
                                                <option value="">{{ _trans('common.Choose One') }}</option>
                                                @foreach ($data['users'] as $user)
                                                    <option {{ @$data['user'] == $user->id ? 'selected="selected"' : '' }}
                                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <input type="date" id="start" name="date"
                                                class="form-control ot-form-control ot-input mt-3 mb-3"
                                                value="{{ isset($_GET['date']) != '' ? $_GET['date'] : date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <button type="submit"
                                                class="btn btn-gradian attendance_table_form height48">{{ _trans('common.Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>


                        @endif
                    </div>
                </div>

                <div class="row dataTable-btButtons">
                    <div class="col-lg-12">
                        <div class="ltn__map-area">
                            <div class="ltn__map-inner">
                                <div id="map" class="mapH_500"></div>
                                <div class="mt-5" id="directions_panel"></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <input type="text" hidden id="data_url"
        value="{{ route('locationReportHistory.index', 'date=' . @$data['date'] . '&user=' . @$data['user']) }}">
    <input type="text" hidden id="token" value="{{ csrf_token() }}">
@endsection
@section('script')
    @include('backend.partials.datatable')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ @settings('google') }}"></script>
    <script>
        function submitForm() {
            document.querySelector('form').submit();
        }
    </script>

 
    <script src="{{ global_asset('backend/js/__location_history.js') }}"></script>


    <style>
        .marker-label {
            color: black;
            font-weight: bold;
            background-color: rgba(255, 255, 255, 0.567);
            padding: 4px 8px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            /* Adjust the vertical offset as needed */

        }
    </style>
@endsection
