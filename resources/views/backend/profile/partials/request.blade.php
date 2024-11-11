<div class="profile-body p-0">


    <div class="table-content table-basic mb-3 ">
        <div class="card">
            <div class="card-body p-5">
                <h3 class="mb-3">{{ _trans('common.Document Request') }}</h3>

                <form method="POST" action="{{ route('document.request.store') }}" enctype="multipart/form-data"
                    class="mt-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6  mb-3">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Select Document Type') }}
                                    <span class="text-danger">*</span></label>
                                <select name="request_type" class="form-select select2" required>
                                    <option disabled selected>{{ _trans('common.Choose One') }} </option>
                                    @foreach ($data['types'] as $key => $type)
                                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('request_type'))
                                    <span class="error text-danger">
                                        {{ $errors->first('request_type') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6  mb-3">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Request Date') }} <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="request_date" autocomplete="off"
                                    class="form-control ot-form-control ot-input" value="{{ old('request_date') }}">
                                @if ($errors->has('request_date'))
                                    <span class="error text-danger">
                                        {{ $errors->first('request_date') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12  mb-3">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Message') }} <span
                                        class="text-danger">*</span></label>
                                <textarea name="request_description" id="" rows="20" class="form-control"></textarea>
                                @if ($errors->has('request_description'))
                                    <span class="error text-danger">
                                        {{ $errors->first('request_description') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12 ">
                        <div class="d-flex justify-content-end">
                            <div class="form-group mt-3 mb-3">
                                <button type="submit"
                                    class="btn btn-gradian mr-3">{{ _trans('common.Submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                                    <select class="form-select d-inline-block" id="entries" onchange="awardTable()">
                                        <option selected value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
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
                                    <input type="hidden" id="daterange-input" onchange="awardTable()">
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
