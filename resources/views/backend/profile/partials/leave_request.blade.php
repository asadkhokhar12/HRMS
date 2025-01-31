<div class="profile-body p-0">
    <!-- profile body nav start -->
    <div class="table-content table-basic">
        <div class="card">
            <input type="text" value="{{ $data['id'] }}" hidden id="__user_id">
            <div class="card-body">
                <!-- toolbar table start -->
                <div
                    class="table-toolbar d-flex flex-wrap gap-2 flex-column flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3">
                    <div class="align-self-center">
                        <div
                            class="d-flex flex-wrap gap-2 flex-column flex-lg-row justify-content-center align-content-center">
                            <!-- show per page -->
                            <div class="align-self-center">
                                <label>
                                    <span class="mr-8">{{ _trans('common.Show') }}</span>
                                    <select class="form-select d-inline-block" id="entries"
                                        onchange="leaveRequestDatatable()">
                                        <option selected value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span class="ml-8">{{ _trans('common.Entries') }}</span>
                                </label>
                            </div>

                            @if (hasPermission('leave_request_create'))
                                <div class="align-self-center">
                                    <a href="{{ route('leaveRequest.create') }}" role="button" class="btn-add"
                                        data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ _trans('common.Add') }}">
                                        <span><i class="fa-solid fa-plus"></i> </span>
                                        <span class="d-none d-xl-inline">{{ _trans('common.Create') }}</span>
                                    </a>
                                </div>
                            @endif



                            <div class="align-self-center d-flex flex-wrap gap-2">
                                <div class="align-self-center">
                                    <button type="button" class="btn-daterange" id="daterange" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="{{ _trans('common.Date Range') }}">
                                        <span class="icon"><i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                        <span class="d-none d-xl-inline">{{ _trans('common.Date Range') }}</span>
                                    </button>
                                    <input type="hidden" id="daterange-input" onchange="leaveRequestDatatable()">
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
    <!-- profile body form end -->
</div>
