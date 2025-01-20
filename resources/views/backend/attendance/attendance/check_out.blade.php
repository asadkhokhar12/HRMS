@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    <div class="table-basic table-content">
        <div class="row">
            <div class=" col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('attendance.update', $data['show']->id) }}" enctype="multipart/form-data"
                            method="post" id="attendanceForm">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <input type="text" name="shift_id" value="{{ $data['show']->shift_id }}" hidden>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="#" class="form-label">{{ _trans('attendance. Employee') }}
                                            <span class="text-danger">*</span></label>
                                        <select name="user_id" class="form-control select2" required="required" disabled>
                                            <option value="" disabled selected>{{ _trans('common.Choose One') }}
                                            </option>
                                            @foreach ($data['users'] as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ $data['show']->user_id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('user_id'))
                                            <div class="error">{{ $errors->first('user_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ _trans('common.Date') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="date" class="form-control ot-form-control ot-input"
                                            value="{{ @$data['show']->date }}" required readonly >
                                        @if ($errors->has('date'))
                                            <div class="error">{{ $errors->first('date') }}</div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row">



                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="#" class="form-label">{{ _trans('common.In Time') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="time" class="form-control ot-form-control ot-input" name="check_in"
                                            value="{{ \Carbon\Carbon::parse($data['show']->check_in)->format('H:i') }}"
                                            required>
                                        @if ($errors->has('check_in'))
                                            <div class="error">{{ $errors->first('check_in') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="#" class="form-label">{{ _trans('common.Location') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="check_in_location"
                                            class="form-control ot-form-control ot-input" placeholder="{{ _trans('check.Check in location') }}"
                                            value="{{ $data['show']->check_in_location }}" required>
                                        @if ($errors->has('check_in_location'))
                                            <div class="error">{{ $errors->first('check_in_location') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ _trans('common.Late reason') }}</label>
                                        <textarea type="text" name="late_in_reason" class="form-control ot-input mt-0" placeholder="{{ _trans('Reason') }}">{{ @$data['show']->lateInReason->reason }}</textarea>
                                        @if ($errors->has('late_in_reason'))
                                            <div class="error">{{ $errors->first('late_in_reason') }}</div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="#" class="form-label">{{ _trans('common.Out time') }}</label>
                                        <input type="time" class="form-control ot-form-control ot-input" name="check_out"
                                            value="{{ $data['show']->check_out ? \Carbon\Carbon::parse($data['show']->check_out)->format('H:i') : '' }}"
                                            required>
                                        @if ($errors->has('check_out'))
                                            <div class="error">{{ $errors->first('check_out') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="#" class="form-label">{{ _trans('common.Location') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="check_out_location"
                                            class="form-control ot-form-control ot-input" placeholder="{{ _trans('check.Check in location') }}"
                                            value="{{ $data['show']->check_out_location }}" required>
                                        @if ($errors->has('check_out_location'))
                                            <div class="error">{{ $errors->first('check_out_location') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ _trans('attendance.Early leave reason') }}</label>
                                        <textarea type="text" name="early_leave_reason" class="form-control ot-input mt-0" placeholder="{{ _trans('Reason') }}">{{ @$data['show']->earlyOutReason->reason }}</textarea>
                                        @if ($errors->has('early_leave_reason'))
                                            <div class="error">{{ $errors->first('early_leave_reason') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row  mt-20">
                                <div class="col-md-12">
                                    <div class="text-right d-flex justify-content-end">
                                        <button class="btn btn-gradian">{{ _trans('common.Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
