@extends('frontend.includes.master')
@section('title', @$data['title'])
@section('content')
    <div class="new-main-content">
        {{-- top section --}}
        <div class="bg-gradient-frontend">
            <div class="container">
                <div class="row mt-5 py-5 align-items-center mx-text-md-center">
                    <div class="col-lg-6">
                        <div class="side-img">
                            <img src="{{ url('images/banner-1-1.svg') }}" alt="">
                        </div>

                    </div>
                    <div class="offset-lg-1 col-lg-5 mx-mt-md">
                        <div class="side-content">
                            <h2>Welcome To {{ env('APP_NAME') }}</h2>
                            <p>An intuitive HR Technology to keep track of employee attendance reporting, stress-free
                                payroll services, employee development to performance reviews, payroll_items, compliance and
                                more
                            </p>
                            <div
                                class="button-for-app d-flex flex-column flex-sm-row flex-lg-row flex-xl-row flex-md-row justify-content-center justify-content-lg-start justify-content-xl-start front-page-store-btn">
                                <a href="{{ config('settings.app')['android_url'] }}" class="app-button-wrapper">Google
                                    Play</a>
                                <a href="{{ config('settings.app')['ios_url'] }}" class="app-button-wrapper">Apple
                                    Store</a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        {{-- end --}}

    </div>

@endsection
