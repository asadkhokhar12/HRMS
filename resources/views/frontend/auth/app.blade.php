<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ @base_settings('company_name') }} - @yield('title')</title>

    <link rel="shortcut icon" href="{{ company_fav_icon(@base_settings('company_icon')) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ global_asset('vendors/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ global_asset('vendors/lineawesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ global_asset('vendors/bootstrap/css/bootstrap.min.css') }}"> 
    <link rel="stylesheet" href="{{ global_asset('vendors/sweet-alert/css/sweet-alert.min.css') }}">
    <link rel="stylesheet" href="{{ global_asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ global_asset('backend/css/c-ui.css') }}">
    @yield('style')
</head>

<body class="default-theme" style="background-image: url(' {{ background_asset(@base_settings('backend_image')) }}')">
    <!-- main content start -->
    <main class="auth-page">
        <section class="auth-container">
            <div
                class="form-wrapper pv-80 ph-100 bg-white d-flex justify-content-center align-items-center flex-column">
                <div class="form-container d-flex justify-content-center align-items-start flex-column">
                    <div class="form-logo mb-40">
                        <!-- @include('frontend.partials.dark_logo') -->
                        <h3>Cybertron Labs</h1>
                    </div>
                    @yield('content')
                </div>
            </div>
             <div class="d-flex justify-content-around pt-3">
                <!-- <small class="fw-light"><a href="{{ env('APP_URL')}}/pages/privacy-policy" target="_blank">Privacy Policy</a></small>
                <small class="fw-light"><a href="{{ env('APP_URL')}}/pages/terms-of-use" target="_blank">Terms & Conditions</a></small>
                <small class="fw-light"><a href="{{ env('APP_URL')}}/pages/support-24-7" target="_blank">24/7 Support</a></small> -->
            </div> 
        </section>
    </main>
    <!-- main content end -->
    <!-- vendors js  -->
    <script src="{{ global_asset('vendors/sweet-alert/js/sweetalert2@11.min.js') }}"></script>
    @yield('script')
</body>
