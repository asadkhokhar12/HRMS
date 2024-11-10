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
            <form method="POST" action="{{ route('daily_leave.store') }}" class="" enctype="multipart/form-data">
                @csrf
                <input type="text" hidden value="{{ auth()->id() }}" name="user_id">
                <div class="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">{{ _trans('common.Leave Type') }} <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="leave_type" required>
                                    <option value="" disabled selected>{{ _trans('common.Choose One') }}</option>
                                    <option value="late_arrive">{{ _trans('common.Late Arrive') }}</option>
                                    <option value="early_leave">{{ _trans('common.Early Leave') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">{{ _trans('common.Date') }}<span class="text-danger">*</span></label>
                                <input type="datetime-local" name="datetime" class="form-control ot-form-control ot-input date" value="{{ now()->format('Y-m-d\TH:i') }}" required />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">{{ _trans('common.Reason') }} <span class="text-danger">*</span></label>
                                <textarea name="reason" class="form-control ot-input mt-0" placeholder="{{ _trans('common.Reason') }} " rows="6" required></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.card-body -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-gradian ">{{ _trans('common.Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
@endsection
