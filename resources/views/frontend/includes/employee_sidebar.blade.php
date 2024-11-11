<div class="col-lg-12 col-xl-3">
    <div class="card card-primary card-outline">
        <div class="card-body ">
            <div class="dashboard-side-card-img mr-2 text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ uploaded_asset($data['user']->avatar_id) }}"
                    alt="User profile picture">
            </div>
            <div class="media-body user-info-header mt-3">
                <div
                    class="d-flex justify-content-center">
                    <div class="d-flex justify-content-center text-muted ">
                    <i class="fa fa-user"></i>
                    <p class="mb-0 text-break ml-2">
                        {{ $data['user']->name }}
                    </p>
                    </div>
                </div>
                <div
                    class="d-flex justify-content-center text-muted mt-2">
                    <i class="fa fa-envelope"></i>
                    <p class="mb-0 text-break ml-2">
                        {{ $data['user']->email }}
                    </p>
                </div>
                <div
                    class="d-flex justify-content-center text-muted mt-2">
                    <i class="fa fa-phone"></i>
                    <p class="mb-0 ml-2">
                        {{ $data['user']->phone }}
                    </p>
                </div>

                <div
                    class="d-flex justify-content-center text-muted mt-2">
                        @if(@$data['user']->driver->status_id == 1)
                            <button class="btn btn-secondary" onclick="GlobalApproveId('{{$data['user']->id}}',`dashboard/drivers/approve/`,'Deactivate');">
                                    {{ _trans('common.Deactivate') }}
                        @else
                            <button class="btn btn-success" onclick="GlobalApproveId('{{$data['user']->id}}',`dashboard/drivers/approve/`,'Approve');">
                                    {{ _trans('common.Approve') }}
                        @endif
                    </button>
                </div>

            </div>
        </div>
        <!-- /.card -->

        <div class="ltn__tab-menu-list">
            <div class="nav">
                <a class="show {{menu_active_by_route('employeeDashboard') }}" href="{{ route('employeeDashboard',encrypt($data['user']->id)) }}">{{ _trans('common.Dashboard') }} <i
                        class="fas fa-home"></i></a>
                <a class="show {{menu_active_by_route('employeePresent') }}" href="{{ route('employeeDashboard',encrypt($data['user']->id)) }}">{{ _trans('common.Present') }} <i
                        class="fas fa-home"></i></a>
                <a class="show {{menu_active_by_route('employeeLeave') }}" href="{{ route('employeeDashboard',encrypt($data['user']->id)) }}">{{ _trans('common.Leave') }} <i class="fas fa-home"></i></a>
                <a class="show {{menu_active_by_route('employeeBreaks') }}" href="{{ route('employeeDashboard',encrypt($data['user']->id)) }}">{{ _trans('common.Break') }} <i
                        class="fas fa-home"></i></a>
                <a class="show {{menu_active_by_route('employeeBreaks') }}" href="{{ route('employeeDashboard',encrypt($data['user']->id)) }}">{{ _trans('common.Logout') }} <i
                        class="fas fa-sign-out-alt"></i></a>


            </div>
        </div>
    </div>
</div>
