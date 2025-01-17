<!DOCTYPE html>
@php
App::setLocale(userLocal());
@endphp
<html lang="{{ userLocal() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ @base_settings('company_name') }} - @yield('title')</title>
    <meta name="keywords" content="attendance, finance, hr management, employee, hrm, HRM management system, human, laravel, leave,office, office-attendance, php, report, resource">
    <meta name="description" content="Onesttech Human Resource Management System Website ">
    @if (env('APP_ENV') == 'production' && env('APP_HTTPS') == true)
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    <meta name="base-url" id="base-url" content="{{ url('/') }}">
    {{-- Header start --}}
    @include('backend.partials.header')
    {{-- Header start --}}
    @yield('style')
</head>
<body class="default-theme">
    <input type="text" hidden value="{{ background_asset(@base_settings('backend_image')) }}" id="background_image">
    <input type="text" hidden value="{{ url('/') }}" id="url">
    <input type="text" hidden value="{{ config('settings.app.company_name') }}" id="site_name">
    <input type="text" hidden value="{{ settings('time_format') }}" id="time_format">
    <input type="text" hidden value="{{ \Carbon\Carbon::now()->format('Y/m/d') }}" id="defaultDate">
    <input type="hidden" id="get_custom_user_url" value="{{ route('user.getUser') }}">
    <input hidden value="{{ _trans('project.Select Employee') }}" id="select_custom_members">
    <input hidden value="{{ auth()->id() }}" id="fire_base_authenticate">
    <input hidden value="{{ _trans('alert.Are you sure?') }}" id="are_you_sure">
    <input hidden value="{{ _trans('alert.You want to delete this record?') }}" id="you_want_delete">
    <input hidden value="{{ _trans('alert.You want to approve this record?') }}" id="you_want_approve">
    <input hidden value="{{ _trans('alert.You want to reject this record?') }}" id="you_want_reject">
    <input hidden value="{{ _trans('response.Something went wrong') }}" id="something_wrong">
    <input hidden value="{{ _trans('common.Yes') }}" id="yes">
    <input hidden value="{{ _trans('common.Cancel') }}" id="cancel">
    <input hidden value="{{ @settings('currency_symbol') }}" id="currency_symbol">
    <input hidden value="{{ _trans('common.Nothing to show here') }}" id="nothing_show_here">
    <input hidden
        value="{{ _trans('project.Please add a new entity or manage the data table to see the content here') }}"
        id="please_add_new">
    <input hidden value="{{ _trans('common.Thank you') }}" id="thank_you">

    <div id="layout-wrapper">
        {{-- Navbar start --}}
        @include('backend.partials.navbar')
        {{-- Navbar start --}}

        {{-- Sidebar start --}}
        @include('backend.partials.sidebar')
        {{-- Sidebar end --}}
        <main class="main-content ph-32 pt-100 pb-20" id="__index_ltn">
            <div class="page-content">
                {{-- Content start --}}
                @yield('content')
                {{-- Content end --}}
            </div>
            {{-- Footer start --}}
            @include('backend.partials.footer')
            {{-- Footer end --}}
        </main>
    </div>

    {{-- Script start --}}
    <script>
        var isRTL = {{ @isRTL() }};
    </script>
    @include('backend.partials.script')
    {{-- Script end --}}

    @if (Auth::check() && env('APP_ENV') == 'production')
        <script src="{{ global_asset('https://www.gstatic.com/firebasejs/8.7.1/firebase-app.js') }}"></script>
        <script src="{{ global_asset('https://www.gstatic.com/firebasejs/8.7.1/firebase-messaging.js') }}"></script>
        <script>
            @include('vendor.notifications.init_firebase')
        </script>
        <script src="{{ global_asset('backend/js/__firebase.js') }}"></script>
    @endif

    {{-- Script end --}}
    @include('backend.partials.message')
    {{-- Script end --}}
    {{-- table end --}}
    <script src="{{ global_asset('backend/js/table/data-table.js') }}"></script>
    {{-- table end --}}
    @yield('script')
    <script src="{{ global_asset('backend/js/backend_common.js') }}"></script>
    <script src="{{ global_asset('backend/js/__app.script.js') }}"></script>

    @stack('ModuleScript')
</body>
</html>