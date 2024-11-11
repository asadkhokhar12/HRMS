
@extends('frontend.includes.master')
@section('title', @$data['title'])
@section('content')
    <!-- Start pricing Area -->
    <section class="pricing-area py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="top-content col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                    <div class="section-title">
                        <h1>{{ @$data['title'] }}</h1>
                        <p>No large investment. Only month wise subscription base HR Software.

                        </p>
                        <h4>All of our pricing includes</h4>
                        <div class="all-pricing-includes">
                            <ul>
                                <li>Unlimited Support</li>
                                <li>Unlimited Customizations</li>
                                <li>User Training </li>
                                <li>Data Imports</li>
                                <li>Pre-configured workflow & templates</li>
                                <li>30-day termination notice (not required during first 30 days)</li>
                            </ul>
                        </div>

                        <h4>Soft Pricing, Best HR Software</h4>
                        <p>We invite you to take a self guided tour through the pihr experience. Stop, start, and review at our own pace. When you’re ready for more just schedule a demo to take a look at HR software and have experience with the best HRM software in Bangladesh.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($data['pricing'] as $key2=>$pricing)
                    <div class="col-lg-3 col-xl-3 col-md-6 col-sm-6 col-12">
                        <div class="single-pricing mb-5 rounded  shadow">
                            <div class="pricing-header pricing-header-{{ $key2 }} shadow rounded  ">
                                <h2>{{ @$pricing['title'] }}</h2>
                            </div>
                            <div>
                                @if($pricing['title'] != 'Premium Package')
                                <h2 class="text-center"> <sup class="pricing-sup"></sup>{{ @$pricing['price'] }}$<sub class="pricing-sub">/Month</sub></h2>
                                @else
                                <h2 class="text-center"> <sup class="pricing-sup"></sup>{{ @$pricing['price'] }}$<sub class="pricing-sub">/Per User</sub></h2>
                                @endif
                                <h2 class="text-center"> <sub class="pricing-sub text-danger">{{ @$pricing['subscription'] }}</sub></h2>
                            </div>
                            <div class="pricing-body">
                                <ul class="list-none">
                                    @foreach ($pricing['features'] as $key => $feature)
                                        <li class="pricing-li"><span class="align-middle pricing-list"><i
                                                    class="bi bi-check"></i></span><span
                                                class="text-bold text-info text-uppercase"> {{ $key }}</span> -
                                            {{ $feature }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="pricing-footer text-center my-4">
                                <a href="{{ route('contact') }}" class="btn px-3 {{ @$pricing['class'] }} rounded shadow pricing-button">Contact Us</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End pricing Area -->


@endsection
