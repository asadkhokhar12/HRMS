@extends('backend.layouts.app')
@section('title', @$data['title'])


@section('style')
    <style>
        .h-250 {
            height: 250px !important;
        }
    </style>
@endsection


@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    <div class="content-wrapper">
        @php
            $general_setting = request()->has('general_setting');
            $email_setup = request()->has('email_setup');
            $payment_gateway = request()->has('payment_gateway');
            $storage_setup = request()->has('storage_setup');
            $db_backup = request()->has('db_backup');
            $about_system = request()->has('about_system');
            $app_theme_setup = isModuleActive('MultiTheme') ? request()->has('app_theme_setup') : '';
            $contact_info = request()->has('contact_info');
            $website_settings = request()->has('website_settings');
            $default_tab = '';
            if (!$general_setting && !$email_setup && !$storage_setup && !$db_backup && !$about_system && !$app_theme_setup && !$contact_info && !$payment_gateway && !$website_settings) {
                $default_tab = 'active';
            } else {
                $default_tab = '';
            }
        @endphp
        <!-- Main content -->

    </div>
    <div class="table-basic table-content">
        <div class="card mb-3 ">
            <div class="card-body p-2">
                <ul class="nav ">
                    <li class="nav-item">
                        <a class="nav-link settings-nav link-secondary {{ $general_setting ? 'active' : '' }} {{ $default_tab }}"
                            id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                            href="#">{{ _trans('settings.General') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link settings-nav link-secondary {{ request()->has('footer') ? 'active' : '' }}"
                            id="footer-tab" data-bs-toggle="tab" data-bs-target="#footer"
                            href="#">{{ _trans('settings.Website Footer') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link settings-nav link-secondary {{ $email_setup ? 'active' : '' }}" id="email-tab"
                            data-bs-toggle="tab" data-bs-target="#email"
                            href="#">{{ _trans('settings.Email setup') }}</a>
                    </li>
                    @if (isMainCompany())
                        <li class="nav-item">
                            <a class="nav-link settings-nav link-secondary {{ $payment_gateway ? 'active' : '' }}"
                                id="payment_gateway-tab" data-bs-toggle="tab" data-bs-target="#payment_gateway"
                                href="#">{{ _trans('settings.Payment Gateway') }}
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link settings-nav link-secondary {{ $storage_setup ? 'active' : '' }}"
                            id="storage-tab" data-bs-toggle="tab" data-bs-target="#storage"
                            href="#">{{ _trans('settings.Storage setup') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link settings-nav link-secondary {{ $db_backup ? 'active' : '' }}" id="db-backup-tab"
                            data-bs-toggle="tab" data-bs-target="#db-backup"
                            href="#">{{ _trans('settings.Database Backup') }}</a>
                    </li>
                    @if (!isMainCompany())
                        <li class="nav-item">
                            <a class="nav-link settings-nav link-secondary {{ $about_system ? 'active' : '' }}"
                                id="about_system-tab" data-bs-toggle="tab" data-bs-target="#about_system"
                                href="#">{{ _trans('settings.About System') }}</a>
                        </li>
                    @endif
                    @if (isModuleActive('MultiTheme'))
                        @include('multitheme::partials.settings.app-theme-setup-menu', ['app_theme_setup' => $app_theme_setup])
                    @endif
                    @if (isMainCompany())
                        <li class="nav-item">
                            <a class="nav-link settings-nav link-secondary {{ $contact_info ? 'active' : '' }}"
                                id="contact_info-tab" data-bs-toggle="tab" data-bs-target="#contact_info"
                                href="#">{{ _trans('settings.Contact Info') }}
                            </a>
                        </li>
                    @endif
                    @if (isMainCompany())
                        <li class="nav-item">
                            <a class="nav-link settings-nav link-secondary {{ $website_settings ? 'active' : '' }}"
                                id="contact_info-tab" data-bs-toggle="tab" data-bs-target="#website_settings"
                                href="#">{{ _trans('settings.Website Settings') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

    </div>
    <div class="table-content table-basic">
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="tabContent">
                    <div id="general" class="tab-pane {{ $general_setting ? 'active show' : '' }}  {{ $default_tab }}">
                        <div class="d-flex justify-content-between">
                            <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                {{ _trans('settings.General') }}</h5>
                            <div class="d-flex align-items-center mb-0">
                            </div>
                        </div>
                        <hr>
                        <div class="content py-primary lol">
                            <div id="General-01">
                                <form action="{{ route('manage.settings.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <fieldset class="form-group mb-5">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row mb-3"><label class="col-sm-3 col-form-label">
                                                        {{ _trans('common.Name') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <div>
                                                            <input type="text" name="company_name" id="company_name"
                                                                required="required"
                                                                placeholder="{{ _trans('settings.Type your company name') }}"
                                                                autocomplete="off"
                                                                class="form-control ot-form-control ot-input mb-3"
                                                                value="{{ @base_settings('company_name') }}">

                                                            @if ($errors->has('company_name'))
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $errors->first('company_name') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-3">
                                                    <label class="col-sm-3 col-form-label h-fit-content">
                                                        {{ _trans('settings.Background Image') }}<br>
                                                        <small
                                                            class="text-muted font-italic">{{ _trans('settings.Recommended  size: 1920 x 1080 px)') }}</small></label>
                                                    <div class="col-sm-9">


                                                        {{-- File uplode Button --}}
                                                        <div class="ot_fileUploader left-side mb-3">
                                                            <input class="form-control" type="text"
                                                                placeholder="{{ _trans('settings.Background Image') }}"
                                                                name="" readonly="" id="placeholder">
                                                            <div class="primary-btn-small-input">
                                                                <label class="btn btn-lg ot-btn-primary"
                                                                    for="fileBrouse">{{ _trans('common.Browse') }}</label>
                                                                <input type="file" class="d-none form-control"
                                                                    name="backend_image" id="fileBrouse">
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('backend_image'))
                                                            <div class="invalid-feedback d-block">
                                                                {{ $errors->first('backend_image') }}</div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-3"><label
                                                        class="col-sm-3 col-form-label h-fit-content">
                                                        {{ _trans('settings.Logo') }}
                                                        <br> <small
                                                            class="text-muted font-italic">{{ _trans('settings.(Recommended size: 210 x 50 px)') }}</small></label>
                                                    <div class="col-sm-9">



                                                        <div class="ot_fileUploader left-side mb-3">
                                                            <input class="form-control" type="text"
                                                                placeholder="{{ _trans('settings.Company Logo Frontend') }}"
                                                                name="" readonly="" id="placeholder3">
                                                            <div class="primary-btn-small-input">
                                                                <label class="btn btn-lg ot-btn-primary"
                                                                    for="fileBrouse3">{{ _trans('common.Browse') }}</label>
                                                                <input type="file" class="d-none form-control"
                                                                    name="company_logo_frontend" id="fileBrouse3">
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('company_logo_frontend'))
                                                            <div class="invalid-feedback d-block">
                                                                {{ $errors->first('company_logo_frontend') }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3"><label
                                                        class="col-sm-3 col-form-label h-fit-content">
                                                        {{ _trans('settings.Company icon') }}<br>
                                                        <small
                                                            class="text-muted font-italic">{{ _trans('settings.(Recommended size: 50 x 50 px)') }}
                                                        </small></label>
                                                    <div class="col-sm-9">


                                                        {{-- File uplode Button --}}
                                                        <div class="ot_fileUploader left-side mb-3">
                                                            <input class="form-control" type="text"
                                                                placeholder="{{ _trans('settings.Company Icon') }}"
                                                                name="" readonly="" id="placeholder4">
                                                            <div class="primary-btn-small-input">
                                                                <label class="btn btn-lg ot-btn-primary"
                                                                    for="fileBrouse4">{{ _trans('common.Browse') }}</label>
                                                                <input type="file" class="d-none form-control"
                                                                    name="company_icon" id="fileBrouse4">
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('company_icon'))
                                                            <div class="invalid-feedback d-block">
                                                                {{ $errors->first('company_icon') }}</div>
                                                        @endif
                                                    </div>
                                                </div>


                                                @if (isMainCompany())
                                                    <h3>{{ _trans('settings.SEO') }}</h3>
                                                    <div class="form-group row mb-3">
                                                        <label class="col-sm-3 col-form-label">
                                                            {{ _trans('common.Meta Title') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <div>
                                                                <input type="text" name="meta_title" id="meta_title"
                                                                    required="required"
                                                                    placeholder="{{ _trans('settings.Meta Title') }}"
                                                                    autocomplete="off"
                                                                    class="form-control ot-form-control ot-input mb-3"
                                                                    value="{{ @base_settings('meta_title') }}">
                                                                @if ($errors->has('meta_title'))
                                                                    <div class="invalid-feedback d-block">
                                                                        {{ $errors->first('meta_title') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label class="col-sm-3 col-form-label">
                                                            {{ _trans('common.Meta Description') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <div>
                                                                <input type="text" name="meta_description"
                                                                    id="meta_description" required="required"
                                                                    placeholder="{{ _trans('settings.Meta Description') }}"
                                                                    autocomplete="off"
                                                                    class="form-control ot-form-control ot-input mb-3"
                                                                    value="{{ @base_settings('meta_description') }}">
                                                                @if ($errors->has('meta_description'))
                                                                    <div class="invalid-feedback d-block">
                                                                        {{ $errors->first('meta_description') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label class="col-sm-3 col-form-label">
                                                            {{ _trans('common.Meta Keywords') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <div>
                                                                <input type="text" name="meta_keywords" id="meta_keywords"
                                                                    required="required"
                                                                    placeholder="{{ _trans('settings.Meta Keywords') }}"
                                                                    autocomplete="off"
                                                                    class="form-control ot-form-control ot-input mb-3"
                                                                    value="{{ @base_settings('meta_keywords') }}">
                                                                @if ($errors->has('meta_keywords'))
                                                                    <div class="invalid-feedback d-block">
                                                                        {{ $errors->first('meta_keywords') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label class="col-sm-3 col-form-label h-fit-content">
                                                            {{ _trans('settings.Meta Image') }}
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <div class="ot_fileUploader left-side mb-3">
                                                                <input class="form-control" type="text"
                                                                    placeholder="{{ _trans('settings.Meta Image') }}"
                                                                    name="" readonly="" id="placeholder4">
                                                                <div class="primary-btn-small-input">
                                                                    <label class="btn btn-lg ot-btn-primary"
                                                                        for="fileBrouse5">
                                                                        {{ _trans('common.Browse') }}
                                                                    </label>
                                                                    <input type="file" class="d-none form-control"
                                                                        name="meta_image" id="fileBrouse5">
                                                                </div>
                                                            </div>
                                                            @if ($errors->has('meta_image'))
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $errors->first('meta_image') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            @if (hasPermission('general_settings_update'))
                                                <div class="d-flex justify-content-end">
                                                    <button class="btn btn-gradian mr-2"><span class="w-100">
                                                        </span> {{ _trans('common.Update') }}
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div id="footer" class="tab-pane {{ request()->has('footer') ? 'active show' : '' }}">
                        <div class="d-flex justify-content-between">
                            <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                {{ _trans('settings.Website Footer') }}
                            </h5>
                            <div class="d-flex align-items-center mb-0">
                            </div>
                        </div>
                        <hr>
                        <div class="content py-primary">
                            <div id="General-0">
                                <form action="{{ route('manage.settings.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <fieldset class="form-group mb-5">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row mb-3"><label class="col-sm-3 col-form-label">
                                                        {{ _trans('common.Short Description') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <div><input type="text" name="company_description"
                                                                id="company_description" required="required"
                                                                placeholder="{{ _trans('settings.Type your company short description') }}"
                                                                autocomplete="off"
                                                                class="form-control ot-form-control ot-input mb-3"
                                                                value="{{ @base_settings('company_description') }}">
                                                            @if ($errors->has('company_description'))
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $errors->first('company_description') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- @if (!isMainCompany()) --}}
                                                <div class="form-group row mb-3"><label class="col-sm-3 col-form-label">
                                                        {{ _trans('settings.Android url') }}
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <div>
                                                            <input type="url"
                                                                class="form-control ot-form-control ot-input mb-3"
                                                                name="android_url"
                                                                value="{{ @base_settings('android_url') }}"
                                                                placeholder="{{ _trans('settings.Android url') }}">
                                                            @if ($errors->has('android_url'))
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $errors->first('android_url') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label class="col-sm-3 col-form-label h-fit-content">
                                                        {{ _trans('settings.Android icon') }}<br>
                                                        <small
                                                            class="text-muted font-italic">{{ _trans('settings.(Recommended size: 150 x 50 px)') }}
                                                        </small>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <div>
                                                            <div class="ot_fileUploader left-side mb-3">
                                                                <input class="form-control" type="text"
                                                                    placeholder="{{ _trans('settings.Android icon') }}"
                                                                    readonly="" id="placeholder5">
                                                                <div class="primary-btn-small-input">
                                                                    <label class="btn btn-lg ot-btn-primary"
                                                                        for="fileBrouse5">{{ _trans('common.Browse') }}</label>
                                                                    <input type="file" class="d-none form-control"
                                                                        name="android_icon" id="fileBrouse5">
                                                                </div>
                                                            </div>

                                                            @if ($errors->has('android_icon'))
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $errors->first('android_icon') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label class="col-sm-3 col-form-label">
                                                        {{ _trans('settings.Ios url') }}
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <div>
                                                            <input type="url"
                                                                class="form-control ot-form-control ot-input mb-3"
                                                                name="ios_url" value="{{ @base_settings('ios_url') }}"
                                                                placeholder="{{ _trans('settings.Ios url') }}">
                                                            @if ($errors->has('ios_url'))
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $errors->first('ios_url') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label class="col-sm-3 col-form-label h-fit-content">
                                                        {{ _trans('settings.IOS icon') }}<br>
                                                        <small
                                                            class="text-muted font-italic">{{ _trans('settings.(Recommended size: 150 x 50 px)') }}
                                                        </small>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <div>
                                                            <div class="ot_fileUploader left-side mb-3">
                                                                <input class="form-control" type="text"
                                                                    placeholder="{{ _trans('settings.IOS icon') }}"
                                                                    readonly="" id="placeholder6">
                                                                <div class="primary-btn-small-input">
                                                                    <label class="btn btn-lg ot-btn-primary"
                                                                        for="fileBrouse6">{{ _trans('common.Browse') }}</label>
                                                                    <input type="file" class="d-none form-control"
                                                                        name="ios_icon" id="fileBrouse6">
                                                                </div>
                                                            </div>

                                                            @if ($errors->has('ios_icon'))
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $errors->first('ios_icon') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- @endif --}}
                                            </div>
                                        </div>
                                        <div>
                                            @if (hasPermission('general_settings_update'))
                                                <div class="d-flex justify-content-end">
                                                    <button class="btn btn-gradian mr-2"><span class="w-100">
                                                        </span> {{ _trans('common.Update') }}
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>

                    </div>

                    <div id="email" class="tab-pane fade {{ $email_setup ? 'active show' : '' }}">
                        <div class="d-flex justify-content-between">
                            <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                {{ _trans('settings.Email setup [SMTP]') }}</h5>
                        </div>
                        <hr>
                        <div class="content py-primary">
                            <form action="{{ route('manage.settings.update.email') }}" method="post" class="mb-0">
                                @csrf
                                <input type="text" value="smtp" name="mail_mailer" hidden>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="emailSettingHost" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.MAIL HOST') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div><input type="text" name="mail_host" id="emailSettingHost"
                                                required="required" placeholder="{{ _trans('settings.MAIL HOST') }}"
                                                autocomplete="off" value="{{ base_settings('mail_host') }}"
                                                class="form-control ot-form-control ot-input mb-3">
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3"><label for="emailSettingPort"
                                        class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.MAIL PORT') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div><input type="text" name="mail_port" id="emailSettingPort"
                                                required="required" placeholder="{{ _trans('settings.MAIL PORT') }}"
                                                autocomplete="off" value="{{ base_settings('mail_port') }}"
                                                class="form-control ot-form-control ot-input mb-3">
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3"><label for="emailSettingUseranme"
                                        class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.MAIL USERNAME') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">

                                        {{-- not show email configuration and details if config('app.style') === 'demo' --}}
                                        <div><input type="text" name="mail_username" id="emailSettingUseranme"
                                                required="required" placeholder="{{ _trans('settings.MAIL USERNAME') }}"
                                                autocomplete="off"
                                                value="@if (config('app.style') === 'demo') {{ base_settings('mail_username') }} @endif"
                                                class="form-control ot-form-control ot-input mb-3">
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3"><label for="emailSettingAdress"
                                        class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.MAIL FROM ADDRESS') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        {{-- not show email configuration and details if config('app.style') === 'demo' --}}
                                        <div><input type="text" name="mail_from_address" id="emailSettingAdress"
                                                required="required"
                                                placeholder="{{ _trans('settings.MAIL FROM ADDRESS') }}"
                                                autocomplete="off"
                                                value="@if (config('app.style') === 'demo') {{ base_settings('mail_from_address') }} @endif"
                                                class="form-control ot-form-control ot-input mb-3">
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3"><label for="emailSettingPassword"
                                        class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.MAIL PASSWORD') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        {{-- not show email configuration and details if config('app.style') === 'demo' --}}
                                        <div><input type="text" name="mail_password" id="emailSettingPassword"
                                                required="required" placeholder="{{ _trans('settings.MAIL PASSWORD') }}"
                                                autocomplete="off"
                                                value="@if (config('app.style') === 'demo') {{ base_settings('mail_password') }} @endif"
                                                class="form-control ot-form-control ot-input mb-3">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3"><label for="emailSettingEncryption"
                                        class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.MAIL ENCRYPTION') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div><input type="text" name="mail_encryption" id="emailSettingEncryption"
                                                required="required"
                                                placeholder="{{ _trans('settings.MAIL ENCRYPTION') }}"
                                                autocomplete="off" value="{{ base_settings('mail_encryption') }}"
                                                class="form-control  ot-form-control ot-input">
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3"><label for="emailSettingFromName"
                                        class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.MAIL FROM NAME') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div><input type="text" name="mail_from_name" id="emailSettingFromName"
                                                required="required"
                                                placeholder="{{ _trans('settings.MAIL FROM NAME') }}" autocomplete="off"
                                                value="{{ base_settings('mail_from_name') }}"
                                                class="form-control ot-form-control ot-input mb-3">
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                                <!---->
                                @if (hasPermission('general_settings_update'))
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-gradian mr-2">
                                            {{ _trans('common.Save') }}
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div id="payment_gateway" class="tab-pane fade {{ $payment_gateway ? 'active show' : '' }}">
                        <div class="d-flex justify-content-between">
                            <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                {{ _trans('settings.Payment Gateway') }}</h5>
                        </div>
                        <hr>
                        <div class="content py-primary">
                            <form action="{{ route('manage.settings.payment-gateway') }}" method="post"
                                class="mb-0">
                                @csrf
                                <h3>{{ _trans('settings.Stripe') }}</h3>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="stripeKey" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Stripe Key') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" name="stripe_key" id="stripeKey" required="required"
                                            placeholder="{{ _trans('settings.Stripe Key') }}" autocomplete="off"
                                            value="{{ @base_settings('stripe_key') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="stripeSecret" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Stripe Secret') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" name="stripe_secret" id="stripeSecret" required="required"
                                            placeholder="{{ _trans('settings.Stripe Secret') }}" autocomplete="off"
                                            value="{{ @base_settings('stripe_secret') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>

                                <h3>{{ _trans('settings.Demo Checkout') }}</h3>
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Enable Demo Checkout') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input cursor-pointer" type="checkbox"
                                                name="is_demo_checkout" value="1"
                                                {{ @base_settings('is_demo_checkout') ? 'checked' : '' }}
                                            >
                                        </div>
                                    </div>
                                </div>
                                <h3>{{ _trans('settings.Offline Payment Type') }}</h3>
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-3 col-xl-3 mb-lg-0"> {{ _trans('settings.Cash') }} </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input cursor-pointer" type="checkbox" name="is_payment_type_cash" value="1"
                                                {{ @base_settings('is_payment_type_cash') ? 'checked' : '' }}> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-3 col-xl-3 mb-lg-0"> {{ _trans('settings.Cheque') }} </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input cursor-pointer" type="checkbox" name="is_payment_type_cheque" value="1"
                                                {{ @base_settings('is_payment_type_cheque') ? 'checked' : '' }}> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-3 col-xl-3 mb-lg-0"> {{ _trans('settings.Bank Transfer') }} </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input cursor-pointer" type="checkbox" name="is_payment_type_bank_transfer" value="1"
                                                {{ @base_settings('is_payment_type_bank_transfer') ? 'checked' : '' }}> 
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-gradian mr-2">
                                        {{ _trans('common.Save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="storage" class="tab-pane fade {{ $storage_setup ? 'active show' : '' }}">
                        <div class="d-flex justify-content-between">
                            <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                {{ _trans('settings.Storage setup') }}</h5>
                            <div class="d-flex align-items-center mb-0">
                                <!---->
                            </div>
                        </div>
                        <hr>
                        <div class="content py-primary">
                            <form action="{{ route('manage.settings.update.storage') }}" method="post" class="mb-0">
                                @csrf
                                <div class="form-group row align-items-center mb-3"><label for="select_storage"
                                        class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Default storage') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div class="form-group">
                                            <select name="FILESYSTEM_DRIVER" id="select_storage"
                                                class="form-select ot-input select2">
                                                <option selected value="local">{{ _trans('settings.Local') }}</option>
                                                <option {{ env('FILESYSTEM_DRIVER') == 's3' ? 'selected' : '' }}
                                                    value="s3">{{ _trans('settings.S3') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="s3_section d-none">
                                    <div class="form-group row align-items-center"><label for="AWSKeyId"
                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                            {{ _trans('settings.AWS ACCESS KEY ID') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-xl-9">
                                            <div><input type="text" name="AWS_ACCESS_KEY_ID" id="AWSKeyId"
                                                    required="required"
                                                    placeholder="{{ _trans('settings.AWS ACCESS KEY ID') }}"
                                                    autocomplete="off" value="{{ env('AWS_ACCESS_KEY_ID') }}"
                                                    class="form-control ot-form-control ot-input mb-3">
                                                <!---->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center"><label for="AwsSecretKey"
                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                            {{ _trans('settings.AWS SECRET ACCESS KEY') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-xl-9">
                                            <div><input type="text" name="AWS_SECRET_ACCESS_KEY"
                                                    value="{{ env('AWS_SECRET_ACCESS_KEY') }}" required="required"
                                                    placeholder="{{ _trans('settings.AWS SECRET ACCESS KEY') }}"
                                                    autocomplete="off" id="AwsSecretKey"
                                                    class="form-control ot-form-control ot-input mb-3">
                                                <!---->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center"><label for="AwsDefaultRegion"
                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                            {{ _trans('settings.AWS DEFAULT REGION') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-xl-9">
                                            <div><input type="text" name="AWS_DEFAULT_REGION"
                                                    value="{{ env('AWS_DEFAULT_REGION') }}" required="required"
                                                    placeholder="{{ _trans('settings.AWS DEFAULT REGION') }}"
                                                    autocomplete="off" id="AwsDefaultRegion"
                                                    class="form-control ot-form-control ot-input mb-3">
                                                <!---->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center"><label for="AwsBucket"
                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                            {{ _trans('settings.AWS BUCKET') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-xl-9">
                                            <div><input type="text" name="AWS_BUCKET"
                                                    value="{{ env('AWS_BUCKET') }}" required="required"
                                                    placeholder="{{ _trans('settings.AWS BUCKET') }}" autocomplete="off"
                                                    id="AwsBucket" class="form-control ot-form-control ot-input mb-3">
                                                <!---->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center"><label for="AwsEndpoint"
                                            class="col-lg-3 col-xl-3 mb-lg-0">
                                            {{ _trans('settings.AWS ENDPOINT') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-xl-9">
                                            <div><input type="text" name="AWS_ENDPOINT"
                                                    value="{{ env('AWS_ENDPOINT') }}" required="required"
                                                    placeholder="{{ _trans('settings.AWS ENDPOINT') }}"
                                                    autocomplete="off" id="AwsEndpoint"
                                                    class="form-control ot-form-control ot-input mb-3">
                                                <!---->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---->
                                @if (hasPermission('general_settings_update'))
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-gradian mr-2">
                                            {{ _trans('common.Save') }}
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div id="db-backup" class="tab-pane fade {{ $db_backup ? 'active show' : '' }}">
                        <div class="d-flex justify-content-between">
                            <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                {{ _trans('settings.Database backup') }} </h5>
                            <div class="d-flex align-items-center mb-0">
                                <a href="{{ route('database.export') }}"
                                    class="btn btn-gradian">{{ _trans('settings.Backup Database') }}</a>
                            </div>
                        </div>

                        <hr>
                        <div class="content py-primary  table-content table-basic ">
                            <div class="dataTable-btButtons">
                                <div class="table-content table-basic">
                                    <table id="table" class="table datatable mb-0 w-100">
                                        <thead class="thead">
                                            <tr>
                                                <th>{{ _trans('common.File name') }}</th>
                                                <th>{{ _trans('common.Date') }}</th>
                                                <th>{{ _trans('common.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody" id="__database_tbody">
                                            @if (@$data['databases'])
                                                @foreach ($data['databases'] as $key => $item)
                                                    <tr>
                                                        <td>{{ $item->path }}</td>
                                                        <td>{{ showDate($item->created_at) }}</td>
                                                        <td>
                                                            <div class="dropdown dropdown-action">
                                                                <button type="button" class="btn-dropdown"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa-solid fa-ellipsis"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <a target="_blank" href="{{ url($item->path) }}"
                                                                        class="dropdown-item" onclick="">
                                                                        {{ _trans('common.Download') }}
                                                                    </a>
                                                                    <a href="{{ route('database.destroy', $item->id) }}"
                                                                        class="dropdown-item" onclick="">
                                                                        {{ _trans('common.Delete') }}
                                                                    </a>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="about_system" class="tab-pane fade ">
                        <div class="d-flex justify-content-between">
                            <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                {{ _trans('settings.About System') }} </h5>

                        </div>

                        <hr>
                        <div class="col-lg-6">
                            <div class="form-group row align-items-center"><label class="col-lg-3 col-xl-3 mb-lg-0">
                                    {{ _trans('common.Version') }}
                                </label>
                                <div class="col-lg-9 col-xl-9">
                                    <div>
                                        <span class="text-muted">
                                            {{ @aboutSystem()['version'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center"><label class="col-lg-3 col-xl-3 mb-lg-0">
                                    {{ _trans('common.Release Date') }}
                                </label>
                                <div class="col-lg-9 col-xl-9">
                                    <div>
                                        <span class="text-muted">
                                            {{ showDate(@aboutSystem()['release_date']) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    @if (isModuleActive('MultiTheme'))
                        @include('multitheme::partials.settings.app-theme-setup', ['app_theme_setup' => $app_theme_setup])
                    @endif

                    <div id="contact_info" class="tab-pane fade {{ $contact_info ? 'active show' : '' }}">
                        <div class="d-flex justify-content-between">
                            <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                {{ _trans('settings.Contact Info') }}</h5>
                        </div>
                        <hr>
                        <div class="content py-primary">
                            <form action="{{ route('manage.settings.contact-info') }}" method="post" class="mb-0">
                                @csrf
                                <div class="form-group row align-items-center mb-3">
                                    <label for="contactEmail" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Email') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" name="email" id="contactEmail" required="required"
                                            placeholder="{{ _trans('settings.Email') }}" autocomplete="off"
                                            value="{{ @base_settings('email') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="contactPhone" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Phone') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" name="phone" id="contactPhone" required="required"
                                            placeholder="{{ _trans('settings.Phone') }}" autocomplete="off"
                                            value="{{ @base_settings('phone') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="contactAddress" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Address') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" name="address" id="contactAddress" required="required"
                                            placeholder="{{ _trans('settings.Address') }}" autocomplete="off"
                                            value="{{ @base_settings('address') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="twitterLink" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Twitter Link') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="url" name="twitter_link" id="twitterLink"
                                            placeholder="{{ _trans('settings.Twitter Link') }}" autocomplete="off"
                                            value="{{ @base_settings('twitter_link') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="linkedInLink" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.LinkedIn Link') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="url" name="linkedin_link" id="linkedInLink"
                                            placeholder="{{ _trans('settings.LinkedIn Link') }}" autocomplete="off"
                                            value="{{ @base_settings('linkedin_link') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="facebookLink" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Facebook Link') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="url" name="facebook_link" id="facebookLink"
                                            placeholder="{{ _trans('settings.Facebook Link') }}" autocomplete="off"
                                            value="{{ @base_settings('facebook_link') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="instagramLink" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Instagram Link') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="url" name="instagram_link" id="instagramLink"
                                            placeholder="{{ _trans('settings.Instagram Link') }}" autocomplete="off"
                                            value="{{ @base_settings('instagram_link') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="dribbbleLink" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Dribbble Link') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="url" name="dribbble_link" id="dribbbleLink"
                                            placeholder="{{ _trans('settings.Dribbble Link') }}" autocomplete="off"
                                            value="{{ @base_settings('dribbble_link') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="behanceLink" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Behance Link') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="url" name="behance_link" id="behanceLink"
                                            placeholder="{{ _trans('settings.Behance Link') }}" autocomplete="off"
                                            value="{{ @base_settings('behance_link') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="pinterestLink" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Pinterest Link') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="url" name="pinterest_link" id="pinterestLink"
                                            placeholder="{{ _trans('settings.Pinterest Link') }}" autocomplete="off"
                                            value="{{ @base_settings('pinterest_link') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-gradian mr-2">
                                        {{ _trans('common.Save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="website_settings" class="tab-pane fade {{ $website_settings ? 'active show' : '' }}">
                        <div class="d-flex justify-content-between">
                            <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                {{ _trans('settings.Website Setting') }}
                            </h5>
                        </div>
                        <hr>
                        <div class="content py-primary">
                            <form action="{{ route('manage.settings.website-settings') }}" method="post"
                                class="mb-0">
                                @csrf
                                <h3>{{ _trans('settings.WhatsApp') }}</h3>
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Enable WhatsApp') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input cursor-pointer" type="checkbox"
                                                name="is_whatsapp_chat_enable" value="1"
                                                {{ @base_settings('is_whatsapp_chat_enable') ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="whatsAppNumber" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.WhatsApp Number') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" name="whatsapp_chat_number" id="whatsAppNumber"
                                            placeholder="{{ _trans('settings.WhatsApp Number') }}" autocomplete="off"
                                            value="{{ @base_settings('whatsapp_chat_number') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>


                                <h3>{{ _trans('settings.reCAPTCHA') }}</h3>
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Enable reCAPTCHA') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input cursor-pointer" type="checkbox"
                                                name="is_recaptcha_enable" value="1"
                                                {{ @base_settings('is_recaptcha_enable') ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="reCAPTCHASitekey" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.reCAPTCHA Sitekey') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" name="recaptcha_sitekey" id="reCAPTCHASitekey"
                                            placeholder="{{ _trans('settings.reCAPTCHA Sitekey') }}" autocomplete="off"
                                            value="{{ @base_settings('recaptcha_sitekey') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="reCAPTCHASecret" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.reCAPTCHA Secret') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" name="recaptcha_secret" id="reCAPTCHASecret"
                                            placeholder="{{ _trans('settings.reCAPTCHA Secret') }}" autocomplete="off"
                                            value="{{ @base_settings('recaptcha_secret') }}"
                                            class="form-control ot-form-control ot-input mb-3">
                                    </div>
                                </div>


                                <h3>{{ _trans('settings.Tawk') }}</h3>
                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Enable Tawk') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input cursor-pointer" type="checkbox"
                                                name="is_tawk_enable" value="1"
                                                {{ @base_settings('is_tawk_enable') ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center mb-3">
                                    <label for="tawkWidgetScript" class="col-lg-3 col-xl-3 mb-lg-0">
                                        {{ _trans('settings.Tawk Widget Script') }}
                                    </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <textarea name="tawk_chat_widget_script" id="tawkWidgetScript"
                                            placeholder="{{ _trans('settings.Tawk Widget Script') }}" autocomplete="off" class="form-control mb-3 h-250">{{ @base_settings('tawk_chat_widget_script') }}</textarea>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-gradian mr-2">
                                        {{ _trans('common.Save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ url('backend/js/image_preview.js') }}"></script>
    <script>
        $(".radio-checkbox-switch").on("click", function() {
            $(this).next().removeClass("radio-active");
            $(this).prev().removeClass("radio-active");
            $(this).addClass("radio-active");
        });
    </script>



@endsection
