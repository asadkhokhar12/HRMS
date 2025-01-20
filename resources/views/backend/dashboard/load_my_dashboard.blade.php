<div class="row">
    {{-- @foreach ($data['dashboardMenus']['today'] as $key => $item)
        <!-- Single Dashboard Summery Card Start -->
        <div class="col-12 col-md-4 col-lg-4 col-xl-4 pb-24">
            <div class="card summery-card ot-card h-100">
                <div class="card-heading d-flex align-items-center">
                    <div class="card-icon dashboard-card-icon">
                            <img style="max-height: 42px; max-width: 38px;" src="{{ @$item['image'] }}" alt="">
                        
                    </div>
                    <div class="card-content">
                        <h4> {{ @$item['title'] }}</h4>
                        <h1 class="custom"> {{ @$item['number'] }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Dashboard Summery Card End -->
    @endforeach --}}
</div>

<div class="row">
    <div class="col-12 col-md-4 col-lg-4 col-xl-4 pb-24">
        <div class="card summery-card ot-card h-100">
            <div class="card-heading d-flex align-items-center">
                <h1>Work In progress...</h1>
            </div>
        </div>
    </div>
    <!-- Dashboard Summery Card Start -->
    {{-- <div class="col-md-6 pb-30">
        <div class="card ot-card">
            <div class="card-header d-flex flex-row justify-content-between align-items-baseline">
                <div class="card-title">
                    <h3>{{ _trans('dashboard.Project Status') }}</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div id="project_summary_chart" class="custom-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 pb-30">
        <div class="card ot-card">
            <div class="card-header d-flex flex-row justify-content-between align-items-baseline">
                <div class="card-title">
                    <h3>{{ _trans('dashboard.Task Status') }}</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div id="task_summary_chart" class="custom-chart"></div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="col-md-6 pb-30">
        <div class="card ot-card">
            <div class="card-header d-flex flex-row justify-content-between align-items-baseline">
                <div class="card-title">
                    <h3>{{ _trans('dashboard.Appointment Schedule') }}</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="custom-chart table-content table-basic">
                    <div class="card-body">
                        <div class="table-responsive  min-height-500">
                            <table class="table table-bordered">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-left">{{ _trans('common.Title') }}</th>
                                        <th>{{ _trans('common.With') }}</th>
                                        <th>{{ _trans('common.Location') }}</th>
                                        <th>{{ _trans('common.Date Time') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody" id="appointment_schedule">
                                </tbody>
                            </table>
                        </div>
                        <!--  table end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 pb-30">
        <div class="card ot-card">
            <div class="card-header d-flex flex-row justify-content-between align-items-baseline">
                <div class="card-title">
                    <h3>{{ _trans('dashboard.Meeting schedule') }}</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="custom-chart table-content table-basic">
                    <div class="card-body">
                        <div class="table-responsive  min-height-500">
                            <table class="table table-bordered">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-left">{{ _trans('common.Title') }}</th>
                                        <th>{{ _trans('common.With') }}</th>
                                        <th>{{ _trans('common.Location') }}</th>
                                        <th>{{ _trans('common.Date Time') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody" id="meeting_schedule">
                                </tbody>
                            </table>
                        </div>
                        <!--  table end -->
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>
