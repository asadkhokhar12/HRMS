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
        <section class="card">
            <div class="card-body">
                <form action="{{ route('supportTicket.store') }}" enctype="multipart/form-data" method="post"
                    id="attendanceForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="" class="form-label">{{ _trans('common.Type') }} <span
                                        class="text-danger">*</span></label>
                                <select name="type_id" class="form-control select2" required="required">
                                    <option value="" disabled selected>{{ _trans('common.Choose One') }}</option>
                                    <option value="12">{{ _trans('common.Open') }}</option>
                                    <option value="13">{{ _trans('common.Close') }}</option>
                                </select>
                                @if ($errors->has('type_id'))
                                    <div class="error">{{ $errors->first('type_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="#" class="form-label">{{ _trans('common.Priority') }} <span
                                        class="text-danger">*</span></label>
                                <select name="priority_id" class="form-control select2" required="required">
                                    <option value="" disabled selected>{{ _trans('common.Choose One') }}</option>
                                    <option value="14">{{ _trans('common.High') }}</option>
                                    <option value="15">{{ _trans('common.Medium') }}</option>
                                    <option value="16">{{ _trans('common.Low') }}</option>
                                </select>
                                @if ($errors->has('priority_id'))
                                    <div class="error">{{ $errors->first('priority_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="subject" class="form-label">{{ _trans('common.Subject') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control ot-form-control ot-input " name="subject"
                                    id="subject" value="{{ old('subject') }}" required
                                    placeholder="{{ _trans('common.Subject') }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">{{ _trans('common.Description') }}</label>
                                <textarea class="form-control" name="description" placeholder="{{ _trans('common.Enter Description') }}"
                                    rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" id="upload-label" for="appSettings_company_logo">
                                    {{ _trans('common.Add Attachment') }}
                                </label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control" type="text"
                                        placeholder="{{ _trans('common.Description') }}" name="" readonly=""
                                        id="placeholder">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="btn btn-lg ot-btn-primary m-0"
                                            for="fileBrouse">{{ _trans('common.Browse') }}</label>
                                        <input type="file" class="d-none form-control" name="attachment_file"
                                            id="fileBrouse">
                                    </button>
                                </div>
                                @if ($errors->has('attachment_file'))
                                    <div class="invalid-feedback d-block">{{ $errors->first('attachment_file') }}</div>
                                @endif



                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-right d-flex justify-content-end">
                                <button class="btn btn-gradian ">{{ _trans('common.Save') }}</button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ global_asset('frontend/assets/js/iziToast.js') }}"></script>
    <script src="{{ url('backend/js/image_preview.js') }}"></script>


    <script src="{{ global_asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ global_asset('ckeditor/config.js') }}"></script>
    <script src="{{ global_asset('ckeditor/styles.js') }}"></script>
    <script src="{{ global_asset('ckeditor/build-config.js') }}"></script>
    <script src="{{ global_asset('backend/js/ticket_ckeditor.js') }}"></script>

@endsection
