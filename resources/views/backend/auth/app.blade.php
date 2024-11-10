<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('settings.app.company_name') }} - @yield('title')</title>
    
    @if (env('APP_ENV') == 'production' && env('APP_HTTPS') == true)
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    @if (env('FILESYSTEM_DRIVER') == 'server')
        <link rel="shortcut icon" href="{{ Storage::disk('s3')->url(config('settings.app')['company_icon']) }}"
            type="image/x-icon" >
    @elseif (env('FILESYSTEM_DRIVER') == 's3')
        <link rel="shortcut icon" href="{{ Storage::disk('s3')->url(config('settings.app')['company_icon']) }}"
            type="image/x-icon" >
    @elseif(env('FILESYSTEM_DRIVER') == 'local')
        <link rel="shortcut icon" href="{{ Storage::url(config('settings.app')['company_icon']) }}"
            type="image/x-icon" >
    @else
        <link rel="shortcut icon" href="{{ Storage::url(config('settings.app')['company_icon']) }}"
            type="image/x-icon" >
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ global_asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ global_asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ global_asset('backend/css/adminlte.min.css') }}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ global_asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ global_asset('frontend/css/custom.css') }}">
    <link rel="stylesheet" href="{{ global_asset('css/main.css') }}">
    {{--  iziToast  --}}
    <link rel="stylesheet" href="{{ global_asset('frontend/assets/css/iziToast.css') }}">
    <link rel="stylesheet" href="{{global_asset('backend/') }}/plugins/select2/css/select2.min.css">

    {{-- intarnal stylesheet moved to app.css --}}
    <link rel="stylesheet" href="{{ global_asset('frontend/assets/css/app.css') }}">

    <link rel="stylesheet" href="{{ global_asset('frontend/css/frontend.css') }}">

    @yield('style')
    
</head>

<body class="hold-transition ">
    
    @include('frontend.includes.menu')

    <div class="row">
    
        <div class=" col-md-12  my-auto">

            <div class=" new-main-content">

            <a href="{{ url('/') }}"></a>
            @yield('content')
        </div>
        <!-- /.login-logo -->

    </div>
    <!-- /.login-box -->
    </div>
    @include('frontend.includes.footer')
