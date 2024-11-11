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
                @php
                $company_configs = DB::table('company_configs')
                ->where('key', 'google')
                ->first();
                $company_configs = $company_configs ? $company_configs->value : '';
                @endphp
                @if ($company_configs != '')
                <div class="col-lg-4">
                    @if ($data['timeline'] != '' && $data['timeline']->count() > 0)
                    <h2>{{ $data['input']['date'] }}</h2>
                    <hr>
                    <div class="scroll-step">
                        @if (isset($_GET['location_pattern']) && isset($_GET['user']) && isset($_GET['date']))
                        @foreach ($data['timeline'] as $key => $timeline)
                        <div class="step active">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 data-step-id="">{{ @$timeline->address }}</h2>
                                <p>{{ @$timeline->created_at->format('H:i:s') }}</p>
                            </div>
                            <p class="text-center mt-3">{{ @$timeline->created_at->diffForHumans() }}</p>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    @else
                    <h2 class="text-center">No Record Found !</h2>
                    @endif

                </div>
                <div class="col-lg-8">
                    <div class="row align-items-end  table-filter-data">
                        <div class="col-lg-12">
                            @if (hasPermission('role_read'))

                            <form method="GET" action="#">
                                <div class="row align-items-center">
                                    <div class="col-xl-3 d-none">
                                        <div class="form-group">
                                            <select name="location_pattern" class="form-control select2 mb-3"
                                                onchange="submitForm()">
                                                <option value="3" @if (@$_GET['location_pattern']==3) selected @else
                                                    selected @endif>
                                                    {{ _trans('common.Pattern 3') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <select name="user" class="form-control select2 mb-3"
                                                onchange="submitForm()">
                                                <option value="">{{ _trans('common.Choose One') }}
                                                </option>
                                                @foreach ($data['users'] as $user)
                                                <option {{ @$data['user']==$user->id ? 'selected="selected"' : '' }}
                                                    value="{{ $user->id }}">{{ $user->name }}
                                                </option>
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
                                                class="btn btn-gradian attendance_table_form height48">{{
                                                _trans('common.Submit') }}</button>
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
                @else
                <div class="row p-5">
                    <div class="col-lg-12">
                        <h3 class="danger text-danger"> {{ _trans('error.Please set google map API Key') }}</h3>
                        <a href="{{ url('admin/company-setup/configuration') }}" class="btn btn-primary">{{
                            _trans('common.Update Configuration') }}</a>
                    </div>
                </div>
                <div class="row mt-3 mb-3  p-5">
                    <h3>Create a Google Cloud Platform (GCP) Project:</h3>
                    <div class="col-lg-12">
                        <ol>
                            <li>Go to the <a href="https://console.cloud.google.com/" target="_blank"
                                    class="text-info">Google Cloud Console</a>.</li>
                            <li>If you're not already signed in, sign in with your Google account.</li>
                            <li>Click the project drop-down at the top left of the page and then click "New
                                Project".
                            </li>
                            <li>Enter a name for your project, select an organization (if applicable), and choose a
                                billing account. Click "Create" to create the project.</li>
                        </ol>

                        <h3>Enable the Google Maps JavaScript API:</h3>
                        <ol>
                            <li>In the GCP Console, navigate to the "APIs &amp; Services" &gt; "Library" section.
                            </li>
                            <li>Search for "Google Maps JavaScript API" and click on it.</li>
                            <li>Click the "Enable" button.</li>
                        </ol>

                        <h3>Create an API Key:</h3>
                        <ol>
                            <li>In the "APIs &amp; Services" &gt; "Credentials" section, click on "Create
                                Credentials".
                            </li>
                            <li>Select "API key" from the drop-down menu.</li>
                            <li>Your API key will be displayed on the next screen. Make sure to restrict the usage
                                of
                                your API key for security purposes (optional but recommended).</li>
                        </ol>
                    </div>

                </div>
                @endif
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
<script>
    // JS for setting the "active" step class

        // 'Next' buttons:
        $(".next").click(function() {
            var oParent = $(this).closest(".step");
            setActiveStep(oParent.next());
        });

        // 'Back' buttons:
        $(".back").click(function() {
            var oParent = $(this).closest(".step");
            setActiveStep(oParent.prev());
        });


        function setActiveStep(p_oDiv) {

            // Set styles:  
            $(".step.active").removeClass("active");
            $(".step.inactive").removeClass("inactive");
            $(p_oDiv).addClass("active");
            $(p_oDiv).nextAll().addClass("inactive");

            // Scroll to active step:
            $('html, body').animate({
                scrollTop: $(p_oDiv).offset().top
            }, 500);
        }

        //Init the first step:
        setActiveStep($(".step")[0]);
</script>

@if (@$_GET['location_pattern'] == 1)
<script src="{{ global_asset('backend/js/__location_history.js') }}"></script>
@elseif (@$_GET['location_pattern'] == 2)
<script src="{{ global_asset('backend/js/__location_history2.js') }}"></script>
@elseif (@$_GET['location_pattern'] == 3)
<script src="{{ global_asset('backend/js/__location_history3.js') }}"></script>
@else
<script src="{{ global_asset('backend/js/__location_history.js') }}"></script>
@endif


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