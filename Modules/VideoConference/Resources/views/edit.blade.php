@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    <div class="table-content table-basic ">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{ $data['url'] }}" enctype="multipart/form-data" method="post" id="attendanceForm">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data['conference']->id }}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ _trans('conference.Conference Title') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control ot-form-control ot-input"
                                            id="title" placeholder="{{ _trans('conference.Conference Title') }}"
                                            value="{{ @$data['conference']->name }}" required>
                                        @if ($errors->has('title'))
                                            <div class="error">{{ $errors->first('title') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ _trans('project.Employee') }} <span
                                                class="text-danger">*</span></label>
                                        <input hidden value="{{ _trans('project.Select Employee') }}" id="select_members">
                                        <select name="user_id[]" class="form-control" multiple id="user_id" required>
                                            @foreach ($data['conference']->members as $member)
                                                <option value="{{ $member->user_id }}" selected>{{ $member->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('user_id'))
                                            <div class="error">{{ $errors->first('user_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ _trans('conference.Start Time') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="time" name="start_at" class="form-control ot-form-control ot-input"
                                            value="{{ separateDateAndTime(@$data['conference']->start_at, 'time') }}"
                                            required>
                                        @if ($errors->has('start_at'))
                                            <div class="error">{{ $errors->first('start_at') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ _trans('conference.End Time') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="time" name="end_at" class="form-control ot-form-control ot-input"
                                            value="{{ separateDateAndTime(@$data['conference']->end_at, 'time') }}"
                                            required>
                                        @if ($errors->has('end_at'))
                                            <div class="error">{{ $errors->first('end_at') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ _trans('conference.Date') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="date" class="form-control ot-form-control ot-input"
                                            value="{{ separateDateAndTime(@$data['conference']->start_at, 'date') }}"
                                            required>
                                        @if ($errors->has('date'))
                                            <div class="error">{{ $errors->first('date') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ _trans('conference.Status') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="status" class="form-control select2" required>
                                            <option value="1"
                                                {{ $data['conference']->status_id == 1 ? 'selected' : '' }}>
                                                {{ _trans('payroll.Active') }}</option>
                                            <option value="4"
                                                {{ $data['conference']->status_id == 4 ? 'selected' : '' }}>
                                                {{ _trans('payroll.Inactive') }}</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <div class="error">{{ $errors->first('status') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ _trans('conference.Description') }} <span
                                                class="text-danger">*</span></label>
                                        <textarea type="text" name="content" class="form-control content" required
                                            placeholder="{{ _trans('conference.Enter Description') }}">{!! $data['conference']->description !!}</textarea>
                                        @if ($errors->has('content'))
                                            <div class="error">{{ $errors->first('content') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if (@$data['url'])
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="text-right d-flex justify-content-end">
                                            <button class="btn btn-gradian">{{ _trans('conference.Update') }}</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
@endsection
@section('script')
    <script src="{{ global_asset('backend/js/pages/__award.js') }}"></script>
    <script src="{{ global_asset('frontend/assets/js/iziToast.js') }}"></script>
    <script src="{{ global_asset('backend/js/image_preview.js') }}"></script>
    <script src="{{ global_asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ global_asset('ckeditor/config.js') }}"></script>
    <script src="{{ global_asset('ckeditor/styles.js') }}"></script>
    <script src="{{ global_asset('ckeditor/build-config.js') }}"></script>
    <script src="{{ global_asset('backend/js/global_ckeditor.js') }}"></script>
@endsection
