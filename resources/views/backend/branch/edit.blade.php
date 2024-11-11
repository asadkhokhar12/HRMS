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
                <form action="{{ route('roles.update', $data['branch']->id) }}" class="form-validate" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                @if (hasPermission('role_read'))
                                    <a href="{{ route('user.index') }}" class="btn btn-gradian "> <i
                                            class="fa fa-arrow-left"></i> {{ _trans('common.Back') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12 mt-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fv-full-name">{{ _trans('common.Name') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control ot-form-control ot-input"
                                            id="fv-full-name" name="name" required
                                            placeholder="{{ _trans('common.Name') }}" value="{{ $data['branch']->name }}">
                                    </div>
                                    @if ($errors->has('name'))
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fv-full-name">{{ _trans('common.Phone') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control ot-form-control ot-input"
                                            id="fv-full-name" name="phone" required
                                            placeholder="{{ _trans('common.Phone') }}" value="{{ $data['branch']->phone }}">
                                    </div>
                                    @if ($errors->has('phone'))
                                        <p class="text-danger">{{ $errors->first('phone') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fv-full-name">{{ _trans('common.Email') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="form-control-wrap">
                                        <input type="email" class="form-control ot-form-control ot-input"
                                            id="fv-full-name" name="email" required
                                            placeholder="{{ _trans('common.Email') }}"
                                            value="{{ $data['branch']->email }}">
                                    </div>
                                    @if ($errors->has('email'))
                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fv-full-name">{{ _trans('common.Address') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control ot-form-control ot-input"
                                            id="fv-full-name" name="address" required
                                            placeholder="{{ _trans('common.Address') }}"
                                            value="{{ $data['branch']->address }}">
                                    </div>
                                    @if ($errors->has('address'))
                                        <p class="text-danger">{{ $errors->first('address') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="fv-email">{{ _trans('common.Status') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select name="status_id" id="status_id" class="form-select ot-input" required>
                                            <option value="" disabled>{{ _trans('common.Choose One') }}
                                            </option>
                                            <option value="1" {{ $data['branch']->status_id == 1 ? 'selected' : '' }}>
                                                {{ _trans('common.Active') }}</option>
                                            <option value="4" {{ $data['branch']->status_id == 4 ? 'selected' : '' }}>
                                                {{ _trans('common.In-active') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-right mt-3 mb-3">
                            <div class="d-flex justify-content-end">
                                @if (hasPermission('role_update'))
                                    <button type="submit" class="btn btn-gradian">{{ _trans('common.Update') }}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ global_asset('backend/js/_roles.js') }}"></script>
@endsection
