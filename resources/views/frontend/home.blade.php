@extends('frontend.layouts.app')
@section('title', @$data['title'])
@section('content')
    @if (@$data['homeContent'])
        @foreach ($data['homeContent'] as $key => $item)
            @if (@$key == 0)
                <div class="bg-for-landingpage sectionbg-color1">
                    <div class="container">
                        <div class="content-container">
                            <div class="row mt-50">
                                <div class="col-lg-6 align-self-center">
                                    <div class="banner-info">
                                        <h4>{{ @$item->contents['title'] }}</h4>
                                        <p>{{ @$item->contents['description'] }}</p>
                                    </div>
                                    <div class="d-flex gap-4 pt-40">
                                        <div class="btn-playstore">
                                            <a href="#" class=" store-btn"> <img class="mr-2"
                                                    src="{{ url('assets/images/playstorelogo.png') }}"
                                                    alt="">
                                                {{ _trans('common.Playstore') }}</a>
                                        </div>
                                        <div class="btn-appstore">
                                            <a href="#" class="store-btn"><img class="mr-2"
                                                    src="{{ url('assets/images/logoappstore.png') }}"
                                                    alt="">{{ _trans('common.Appstore') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="user-img">
                                        <img src="{{ url('assets/images/about.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($key == 1)
                <div class="container">
                    <section class="mt-5 mb-5 works-section">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="about-img">
                                    <img src="{{ url('assets/images/welcome-double-exposure-business-man-partner-handshake 1.png') }}"
                                        alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="aboutus-info">
                                    <div class="aboutus-keyword">
                                        <p>{{ @$item->contents['slogan'] }}</p>
                                    </div>
                                    <div class="aboutus-title">
                                        <h4>{{ @$item->contents['title'] }}</h4>
                                    </div>
                                    <div class="aboutus-content">
                                        <p class="mb-15"> {{ @$item->contents['description'] }} </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            @endif
        @endforeach
    @endif

    {{-- Services s t a r t --}}
    @if (count(@$data['services']) > 0)
        <section class="bg-for-landingpage sectionbg-img1">
            <div class="container">
                <div class="service-info">
                    <div class="service-title">
                        <h4>{{ _trans('frontend.Our Serivces') }}</h4>
                    </div>
                    <div class="row">
                        @foreach ($data['services'] as $service)
                            <div class="col-md-4 mb-4">
                                <div class="card-transparent">
                                    <div class="card-service-title">
                                        <h5>{{ @$service->title }}</h5>
                                    </div>
                                    <div class="card-service-content">
                                        <p>
                                            {!! Str::limit(strip_tags(@$service->description), 100) !!}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>
            </div>
        </section>
    @endif
    {{-- Services end --}}

    {{-- Portfolio S t a r t --}}
    @if (count(@$data['portfolios']) > 0)
        <section class="pt-100 ">
            <div class="container">
                <div class="portfolio-title">
                    <h5>{{ _trans('frontend.Our Portfolio') }}</h5>
                </div>
                <div class="btns d-none">
                    <button type="button" data-menu="all">All</button>
                    <button type="button" data-menu="finance">Finance </button>
                    <button type="button" data-menu="enu">Energy & Utility</button>
                    <button type="button" data-menu="education">education</button>
                    <button type="button" data-menu="engineers">health</button>
                    <button type="button" data-menu="media">media</button>
                </div>
                <div class="row">

                    @foreach ($data['portfolios'] as $item)
                        <div data-menu="finance" class="single col-lg-3 col-md-4 p-2 col-sm-6">
                            <div class="portfolio-card pb-15">
                                <div class="portfolio-img">
                                    <img src="{{ url($item->image->img_path) }}" alt="">
                                </div>
                                <div class="portfolio-content">
                                    <h6>{{ $item->title }}</h6>
                                    <p>{!! Str::limit(strip_tags(@$item->description), 100) !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </section>
    @endif
    {{-- Portfolio End --}}

    {{-- Team --}}
    <section class=" mt-5 mb-5 ">
        <div class="container">
            <div class="portfolio-keyword">
                <p>What we have done so far</p>
            </div>
            <div class="portfolio-title">
                <h5>Our Team</h5>
            </div>

            <div class="btns_management d-none">
                <button type="button" data-menu="all_management">All</button>
                <button type="button" data-menu="management">Management </button>
                <button type="button" data-menu="team_leads">Team Leads</button>
                <button type="button" data-menu="managers">Manager</button>
                <button type="button" data-menu="hr">HR</button>
                <button type="button" data-menu="accounts">Accounts</button>
                <button type="button" data-menu="engineers">Engineers</button>

            </div>
            <div class="row g-0">


                @foreach ($data['front_teams'] as $item)
                    <div data-menu="management" class="single_management col-lg-3 col-md-4 p-2 col-sm-6">
                        <div class="portfolio-card">
                            <div class="portfolio-bg-pink">
                                <div class="portfolio-img-management">
                                    <img class="team_member_image" src="{{ url($item->image->img_path) }}" alt="">
                                </div>
                                <div class="text-center">
                                    <span class="member-name bg-pink-member">{{ $item->name }}</span>
                                </div>

                                <div class="member-designation">
                                    <span>{{ $item->designation }}</span>
                                </div>
                                <div class="portfolio-content-management ">
                                    <p>{!! Str::limit(strip_tags(@$item->description), 50) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
    {{-- End Team --}}

    {{-- Contact Form s t a r t --}}
    <section class=" pb-100">
        <div class="container">
            <div class="getin-touch">
                <div class="getin-touch-content">
                    <p>{{ _trans('frontend.Start Your New Project') }}</p>
                    <h4>{{ _trans('frontend.Get In Touch') }}</h4>
                </div>
                <div class="getin-touch-form">
                    <form class="contact_form" action="{{ route('storeContact') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1"
                                        class="form-label gettouch-form-label">{{ _trans('frontend.Username') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" class="form-control gettouch-form-control"
                                        placeholder="{{ _trans('common.Name') }} " value="{{ old('name') }}" autocomplete="off">
                                    <small class="text-danger contact_name"></small>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1"
                                        class="form-label gettouch-form-label">{{ _trans('frontend.Email') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-control gettouch-form-control"
                                        placeholder="{{ _trans('common.Email') }} " value="{{ old('email') }}" autocomplete="off">
                                    <small class="text-danger contact_email"></small>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1"
                                        class="form-label gettouch-form-label">{{ _trans('frontend.Phone Number') }}</label>
                                    <input type="number" name="phone" class="form-control gettouch-form-control"
                                        placeholder="{{ _trans('common.Phone No') }}" value="{{ old('phone') }}" autocomplete="off">
                                    <small class="text-danger contact_phone"></small>
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1"
                                        class="form-label gettouch-form-label">{{ _trans('frontend.Contact For') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select gettouch-form-control" name="contact_for">
                                        <option value="" disabled>{{ _trans('frontend.Contact For ') }}</option>
                                        <option value="1" {{ old('contact_for') == 1 ? 'selected' : '' }} selected>
                                            {{ _trans('common.Support') }} </option>
                                        <option value="0" {{ old('contact_for') == 0 ? 'selected' : '' }}>
                                            {{ _trans('common.Query') }}</option>
                                    </select>
                                    <small class="text-danger contact_service_type"></small>
                                    @error('contact_for')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1"
                                        class="form-label gettouch-form-label">{{ _trans('frontend.Your Message') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="message" class=" form-control gettouch-form-area" rows="6" placeholder="{{ _trans('common.Enter Message') }}">{{ old('message') }} </textarea>
                                    <small class="text-danger contact_message"></small>
                                    @error('message')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 text-center mt-4">
                                <button class="send-btn  contact_btn"
                                    href="javascript:void(0)">{{ _trans('frontend.Send Message') }}</button>
                            </div>
                            <p class="form-messege mb-0 mt-20"></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
    {{-- Contact Form End --}}
@endsection
@section('scripts')
@endsection
