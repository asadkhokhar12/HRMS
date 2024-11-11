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
                <form method="POST" action="{{ route('contact.store') }}" class="" enctype="multipart/form-data">
                    @csrf
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">{{ _trans('common.Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control ot-input ot-form-control mt-0"
                                            placeholder="{{ _trans('common.Name') }}" value="{{ old('name') }}" required>
                                    @if ($errors->has('name'))
                                        <div class="error">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">{{ _trans('common.Email') }} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" placeholder={{ _trans('common.Email') }} autocomplete="off"
                                            class="form-control ot-input ot-form-control mt-0" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <div class="error">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">{{ _trans('common.Phone') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="phone" placeholder={{ _trans('common.Phone') }} autocomplete="off"
                                            class="form-control ot-input ot-form-control mt-0" value="{{ old('phone') }}" required>
                                    @if ($errors->has('phone'))
                                        <div class="error">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ _trans('common.Contact For') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2" name="contact_for" required>
                                        <option value="" disabled selected>{{ _trans('common.Choose One') }}</option>
                                        <option value="1">Support</option> 
                                        <option value="0">Query</option> 
                                    </select>
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ _trans('common.Message') }} <span
                                            class="text-danger">*</span></label>
                                    <textarea name="message" class="form-control ot-input mt-0" placeholder="{{ _trans('common.Message') }} " rows="6" required></textarea>
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
