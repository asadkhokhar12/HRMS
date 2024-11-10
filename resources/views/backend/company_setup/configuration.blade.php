@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
{!! breadcrumb([ 'title' => @$data['title'], route('admin.dashboard') => _trans('common.Dashboard'), '#' => @$data['title']]) !!}
<div class="table-content table-basic">
    <div class="card">
        <div class="card-body">
            <div class="">
                <div class="vertical-tab">
                    <div class="row no-gutters mt-4">
                        <div class="col-md-12 pl-md-3 pt-md-0 pt-sm-4 pt-4">
                                <div class="tab-content px-primary">
                                    <div id="General" class="tab-pane active  ">
                                        <div class="content py-primary">
                                            <div id="General-0">
                                                <form action="{{ route('company.settings.update') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <span
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Date and time setting') }}
                                                            </span>
                                                            <div class="col-md-12">
                                                                <div class="form-group row mb-3"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.TimeZone') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div><select id="timezone" name="timezone"
                                                                                class="custom-select form-select ot-form-control select2">
                                                                                @foreach ($data['timezones'] as $key =>
                                                                                $timezone)
                                                                                <option
                                                                                    value="{{ $timezone->time_zone }}"
                                                                                    {{
                                                                                    @$data['configs']['timezone']==$timezone->time_zone ? 'selected'
                                                                                    :'' }}>
                                                                                    {{ $timezone->time_zone }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Date format') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <select id="date_format" name="date_format"
                                                                                class="custom-select form-select ot-form-control select2">

                                                                                @foreach ($data['date_formats'] as $date_format)
                                                                                <option {{
                                                                                    @$data['configs']['date_format']==$date_format->format ? 'selected' :'' }} value="{{
                                                                                    $date_format->format }}">{{
                                                                                    $date_format->normal_view }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="row">
                                                            <div
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Language setting') }}
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Select Language') }} 
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <select name="lang" id="language"
                                                                                class="form-select ot-form-control select2">
                                                                                <option value="">{{
                                                                                    _trans('common.Select') }} {{
                                                                                    _trans('settings.Language') }}
                                                                                </option>
                                                                                @foreach($data['hrm_languages'] as $language)
                                                                                <option
                                                                                    value="{{ @$language->code }}"
                                                                                    {{
                                                                                    @$data['configs']['lang']===$language->code ? 'selected' :''
                                                                                    }}>{{ $language->name }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @if ($errors->has('lang'))
                                                                            <div class="error">{{ $errors->first('lang')
                                                                                }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>

                                                    @if (!isMainCompany())
                                                        <div class="row">
                                                            <div
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Attendance setting') }}
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Attendance Method') }} <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <select name="attendance_method" class="form-select ot-form-control select2">
                                                                                @foreach($data['attendance_method'] as $value => $label)
                                                                                    @php
                                                                                        $enumValue = constant("App\Enums\AttendanceMethod::$value");
                                                                                    @endphp
                                                                                    <option value="{{ $enumValue }}" {{ @$data['configs']['attendance_method'] == $enumValue ? 'selected' : '' }}>
                                                                                        {{ $label }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @if ($errors->has('attendance_method'))
                                                                                <div class="error">{{ $errors->first('attendance_method') }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Max Work Hours') }} <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                           <input type="text" class="form-control ot-form-control ot-input" name="max_work_hours" value="{{ @$data['configs']['max_work_hours'] ? @$data['configs']['max_work_hours'] : 16 }}"
                                                                                placeholder="{{ _trans('settings.Max Work Hours') }}" autocomplete="off">
                                                                            @if ($errors->has('max_work_hours'))
                                                                            <div class="error">{{ $errors->first('max_work_hours')
                                                                                }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if (isModuleActive('LiveTracking'))
                                                            @include('livetracking::partials.configuration', ['data' => $data])
                                                        @endif
                                                    @endif

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <span
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Api Key') }}
                                                            </span>
                                                            <div class="col-md-12">
                                                                <div class="form-group row mb-3">
                                                                    <label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Google Map Key') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div>
                                                                                    <input type="text"
                                                                                        class="form-control ot-form-control ot-input"
                                                                                        name="google"
                                                                                        value="{{ !appMode()? @$data['configs']['google'] : '' }}"
                                                                                        placeholder="{{ _trans('settings.Google Map Key') }}"
                                                                                        autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row mb-3"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Google Firebase Key') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div>
                                                                                    <input type="text"
                                                                                        class="form-control ot-form-control ot-input"
                                                                                        name="firebase"
                                                                                        value="{{ !appMode() ? settings('firebase'):'' }}"
                                                                                        placeholder="{{ _trans('settings.Google Firebase Key') }}"
                                                                                        autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <span
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Employee') }}
                                                            </span>
                                                            <div class="col-md-12">
                                                                <div class="form-group row mb-3">
                                                                    <label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Employee Passport Required') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div>
                                                                                    <select name="is_employee_passport_required" class="form-select ot-form-control select2" required>
                                                                                        <option 
                                                                                            value="1"
                                                                                            {{ old('is_employee_passport_required', @$data['configs']['is_employee_passport_required']) == 1 ? 'selected' : '' }}
                                                                                        >
                                                                                            {{ _trans('settings.Yes') }}
                                                                                        </option>
                                                                                        <option 
                                                                                            value="0"
                                                                                            {{ old('is_employee_passport_required', @$data['configs']['is_employee_passport_required']) == 0 ? 'selected' : '' }}
                                                                                        >
                                                                                            {{ _trans('settings.No') }}
                                                                                        </option>
                                                                                    </select>
                                                                                    @if ($errors->has('is_employee_passport_required'))
                                                                                        <div class="error">
                                                                                            {{ $errors->first('is_employee_passport_required') }}
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row mb-3">
                                                                    <label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Employee EID Required') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div>
                                                                                    <select name="is_employee_eid_required" class="form-select ot-form-control select2" required>
                                                                                        <option 
                                                                                            value="1"
                                                                                            {{ old('is_employee_eid_required', @$data['configs']['is_employee_eid_required']) == 1 ? 'selected' : '' }}
                                                                                        >
                                                                                            {{ _trans('settings.Yes') }}
                                                                                        </option>
                                                                                        <option 
                                                                                            value="0"
                                                                                            {{ old('is_employee_eid_required', @$data['configs']['is_employee_eid_required']) == 0 ? 'selected' : '' }}
                                                                                        >
                                                                                            {{ _trans('settings.No') }}
                                                                                        </option>
                                                                                    </select>
                                                                                    @if ($errors->has('is_employee_eid_required'))
                                                                                        <div class="error">
                                                                                            {{ $errors->first('is_employee_eid_required') }}
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Min Phone no digit') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div >
                                                                                    <input type="number"
                                                                                        class="form-control ot-form-control ot-input"
                                                                                        name="min_phone_no_digit"
                                                                                        value="{{ @$data['configs']['min_phone_no_digit'] }}"
                                                                                        placeholder="{{ _trans('settings.Min Phone no digit') }}"
                                                                                        autocomplete="off"
                                                                                        required
                                                                                    >
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Max Phone no digit') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-4">
                                                                        <div>
                                                                            <div class="radio-button-group">
                                                                                <div >
                                                                                    <input type="number"
                                                                                        class="form-control ot-form-control ot-input"
                                                                                        name="max_phone_no_digit"
                                                                                        value="{{ @$data['configs']['max_phone_no_digit'] }}"
                                                                                        placeholder="{{ _trans('settings.Max Phone no digit') }}"
                                                                                        autocomplete="off"
                                                                                        required
                                                                                    >
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <div class="row">
                                                            <span
                                                                class="col-12 col-form-label text-primary pt-0 mb-3">
                                                                {{ _trans('settings.Currency setting') }}
                                                            </span>
                                                            <div class="col-md-12">
                                                                <div class="form-group row g-3"><label
                                                                        class="col-sm-3 col-form-label">
                                                                        {{ _trans('settings.Currency') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="col-sm-3">
                                                                        <div><select id="select_currency_symbol"
                                                                                name="currency" class="custom-select form-select ot-form-control select2">
                                                                                @foreach ($data['currencies'] as $key =>$currency)
                                                                                <option value="{{ $currency->id }}" {{
                                                                                    @$data['configs']['currency']==$currency->
                                                                                    id ? 'selected' :'' }}>
                                                                                    {{ $currency->name }}
                                                                                </option>

                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="currency_symbol"
                                                                            value="{{ @$data['configs']['currency_symbol']}}"
                                                                            readonly class="form-control ot-form-control ot-input"
                                                                            id="currencySymbol">
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="currency_code"
                                                                            value="{{ @$data['configs']['currency_code']}}"
                                                                            readonly class="form-control ot-form-control ot-input"
                                                                            id="currency_code">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
    
                                                            <div class="col-md-12 mt-3">
                                                                
                                                                @if(hasPermission('company_settings_update'))
                                                                <div class="d-flex justify-content-end">
                                                                    <button class="btn btn-gradian mr-2 height48"><span class="w-100">
                                                                    </span> {{ _trans('common.Save') }}
                                                                </button>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="currencyInfo" value="{{ route('company.settings.currencyInfo') }}">
@endsection
@section('script')
<script src="{{url('backend/js/image_preview.js') }}"></script>
@endsection