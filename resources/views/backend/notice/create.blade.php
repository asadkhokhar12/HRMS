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
                        <form action="{{ route('notice.store') }}" enctype="multipart/form-data" method="post"
                            id="attendanceForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">{{ _trans('common.Subject') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="subject" class="form-control ot-form-control ot-input"
                                            placeholder="{{ _trans('common.Subject') }}" value="{{ old('subject') }}"
                                            required>
                                        @if ($errors->has('subject'))
                                            <div class="error">{{ $errors->first('subject') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="date" class="form-label">{{ _trans('common.Date') }} <span
                                            class="text-danger">*</span></label>
                                        <input type="date" name="date" id="date"
                                            class="form-control ot-form-control ot-input" placeholder="{{ _trans('common.Date') }}"
                                            required>
                                        @if ($errors->has('date'))
                                            <div class="error">{{ $errors->first('date') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">{{ _trans('common.Department') }} <span
                                            class="text-danger">*</span></label>
                                        <select name="department_id[]" class="form-control select2" multiple="multiple"
                                            required="required">
                                            <option value="" disabled>{{ _trans('common.Choose One') }}</option>
                                            <option value="0">{{_trans('common.All Department')}}</option>
                                            @foreach ($data['departments'] as $key => $department)
                                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('department_id'))
                                            <div class="error">{{ $errors->first('department_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="description"
                                            class="form-label">{{ _trans('common.Description') }} <span
                                            class="text-danger">*</span></label>
                                        <textarea name="description" id="description" class="form-control mt-0 ot-input" cols="30" rows="5"
                                            placeholder="{{ _trans('common.Description') }}" required></textarea>
                                        @if ($errors->has('description'))
                                            <div class="error">{{ $errors->first('description') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="status">{{ _trans('common.Attachment') }}</label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ _trans('common.Attachment') }}" name="" readonly="" id="placeholder">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary m-0" for="fileBrouse">{{ _trans('common.Browse') }}</label>
                                                <input type="file" class="d-none form-control" name="file" id="fileBrouse">
                                            </button>
                                        </div>
                                        @if ($errors->has('file'))
                                            <div class="invalid-feedback d-block">{{ $errors->first('file') }}</div>
                                        @endif
                                        
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="float-right d-flex justify-content-end">
                                        <button type="submit"
                                            class="btn btn-gradian action-btn">{{ _trans('common.Send') }}</button>
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
