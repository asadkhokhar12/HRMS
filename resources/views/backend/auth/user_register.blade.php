@extends('backend.auth.app')
@section('title', $data['title'])
@section('content')
    <div class="login_page_bg">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="screen">
                    <div class="screen__content">

                        <form action="#" method="post" id="login" class="__user_signup_form">
                            @csrf
                            <div class="ml-4 pt-5 __logo">
                                <h2 class="adminpanel-title  mb-0 pl-2 ">{{ _trans('common.Signup') }}</h2>
                            </div>
                            <div class="login pb-0">

                                <div class="cus__field login__field">
                                    @if (Session::has('phone'))
                                        <div class=" __first_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="{{ _trans('auth.Employer phone') }}" id="__phone"
                                                    value="{{ Session::get('phone') }}">
                                            </div>
                                            <p class="text-danger __phone small-text"></p>
                                        </div>
                                    @else
                                        <div class=" __first_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="{{ _trans('auth.Employer phone') }}" id="__phone">
                                            </div>
                                            <p class="text-danger __phone small-text"></p>
                                            <div class="text-left">
                                                <button type="button"
                                                    class="login-panel-btn  __first_btn __submit_btn mb-3 __previous_btn">
                                                    {{ _trans('common.Next') }}
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    @if (Session::has('name'))
                                        <div class="__second_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="{{ _trans('auth.Employer name') }}" id="__name"
                                                    value="{{ Session::get('name') }}">
                                            </div>
                                            <p class="text-danger __name small-text"></p>
                                        </div>
                                    @else
                                        <div class="__second_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="{{ _trans('auth.Employer name') }}" id="__name">
                                            </div>
                                            <p class="text-danger __name small-text"></p>
                                            <div class=" text-left">
                                                <button type="button"
                                                    class="login-panel-btn  __second_btn __submit_btn mb-3 __previous_btn">
                                                      {{ _trans('common.Next') }}
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    @if (Session::has('email'))
                                        <div class=" __third_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="email" name="email" id="__email" class="form-control"
                                                    placeholder="{{ _trans('auth.Employer email') }}" value="{{ Session::get('email') }}">
                                            </div>
                                            <p class="text-danger __email small-text"></p>
                                        </div>
                                    @else
                                        <div class=" __third_step">
                                            <div class="input-group mb-3">
                                                <input type="email" name="email" id="__email" class="form-control"
                                                    placeholder="{{ _trans('auth.Employer name') }}">
                                            </div>
                                            <p class="text-danger __email small-text"></p>
                                            <div class=" text-left">
                                                <button type="button"
                                                    class="login-panel-btn  __third_btn __submit_btn mb-3 __previous_btn">
                                                      {{ _trans('common.Next') }}
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    @if (Session::has('company_name'))
                                        <div class="__forth_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="text" name="company_name" class="form-control"
                                                    id="__company_name" placeholder="{{ _trans('auth.Company name') }}"
                                                    value="{{ Session::get('company_name') }}">
                                            </div>
                                            <p class="text-danger __company_name small-text"></p>
                                        </div>
                                    @else
                                        <div class="__forth_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="text" name="company_name" class="form-control"
                                                    id="__company_name" placeholder="{{ _trans('auth.Company name') }}">
                                            </div>
                                            <p class="text-danger __company_name small-text"></p>
                                            <div class=" text-left">
                                                <button type="button"
                                                    class="login-panel-btn  __forth_btn __submit_btn mb-3 __previous_btn">
                                                      {{ _trans('common.Next') }}
                                                </button>
                                            </div>
                                        </div>
                                    @endif


                                    @if (Session::has('total_employee'))
                                        <div class=" __forth_second_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="number" name="total_employee" class="form-control"
                                                    id="__total_employee" placeholder="{{ _trans('auth.Total employee') }}"
                                                    value="{{ Session::get('total_employee') }}">
                                            </div>
                                            <p class="text-danger __total_employee small-text"></p>
                                        </div>
                                    @else
                                        <div class=" __forth_second_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="number" name="total_employee" class="form-control"
                                                    id="__total_employee" placeholder="{{ _trans('auth.Total employee') }}">
                                            </div>
                                            <p class="text-danger __total_employee small-text"></p>
                                            <div class=" text-left">
                                                <button type="button"
                                                    class="login-panel-btn  __forth_second_btn __submit_btn mb-3 __previous_btn">
                                                      {{ _trans('common.Next') }}
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    @if (Session::has('business_type'))
                                        <div class=" __fifth_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="text" name="business_type" class="form-control"
                                                    id="__business_type" placeholder="{{ _trans('auth.Business type') }}"
                                                    value="{{ Session::get('business_type') }}">
                                            </div>
                                            <p class="text-danger __business_type small-text"></p>
                                        </div>
                                    @else
                                        <div class=" __fifth_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="text" name="business_type" class="form-control"
                                                    id="__business_type" placeholder="{{ _trans('auth.Business type') }}">
                                            </div>
                                            <p class="text-danger __business_type small-text"></p>
                                            <div class=" text-left">
                                                <button type="button"
                                                    class="login-panel-btn  __fifth_btn __submit_btn mb-3 __previous_btn">
                                                      {{ _trans('common.Next') }}
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    @if (Session::has('trade_licence_number'))
                                        <div class=" __sixth_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="text" name="trade_licence_number" class="form-control"
                                                    id="__trade_licence_number" placeholder="{{ _trans('auth.Trade license number') }}"
                                                    value="{{ Session::get('trade_licence_number') }}">
                                            </div>
                                            <p class="text-danger __trade_licence_number small-text"></p>
                                        </div>
                                    @else
                                        <div class=" __sixth_step custom-step">
                                            <div class="input-group mb-3">
                                                <input type="text" name="trade_licence_number" class="form-control"
                                                    id="__trade_licence_number" placeholder="{{ _trans('auth.Trade license number') }}">
                                            </div>
                                            <p class="text-danger __trade_licence_number small-text"></p>
                                            <div class="text-left">
                                                <button type="button"
                                                    class="login-panel-btn  __sixth_btn __submit_btn mb-3 __previous_btn">
                                                      {{ _trans('common.Next') }}
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    <div class=" __seventh_step color_red" >

                                        <div class="input-group mb-3">
                                            <select name="country" class="form-control" id="_country_id">
                                            </select>
                                        </div>
                                        <p class="text-danger __country_id small-text"></p>

                                        <div class="input-group mb-3">
                                            <input type="password" name="password" class="form-control" id="__password"
                                                placeholder="{{ _trans('auth.Password') }}">
                                        </div>
                                        <p class="text-danger __password small-text"></p>

                                        <div class="input-group mb-3">
                                            <input type="password" name="password_confirmation" class="form-control"
                                                id="__password_confirmation" placeholder="{{ _trans('auth.Re type password') }}">
                                        </div>
                                        <p class="text-danger __password_confirmation small-text"></p>

                                        <div class="input-group">
                                            <p class="small-text">{{ _trans('auth.All the information is okay? Then press submit.') }}</p>
                                        </div>
                                        <div class="text-left">
                                            <button type="button" class="login-panel-btn  __seventh_btn __submit_btn mb-3">
                                                {{ _trans('common.Submit') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <div class="form-row flex-column flex-md-row justify-content-center justify-content-md-between justify-content-lg-between">
                                <a href="{{ route('adminLogin') }}"
                                   class="bluish-text d-flex align-items-center justify-content-center justify-content-lg-end mr-2">
                                    <span class="text-muted already-have-an-account">{{ _trans('auth.Already have an account?') }}</span>&nbsp;{{ _trans('auth.Sign in') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="screen__background">
                        <span class="screen__background__shape screen__background__shape4"></span>
                        <span class="screen__background__shape screen__background__shape3"></span>
                        <span class="screen__background__shape screen__background__shape2"></span>
                        <span class="screen__background__shape screen__background__shape1"></span>
                    </div>

                </div>

            </div>
        </div>

    </div>
    <input type="hidden" id="getCountry" value="{{ route('add.getCountry') }}">
    <input type="hidden" id="phone" value="{{ Session::has('phone') }}">
    <input type="hidden" id="name" value="{{ Session::has('name') }}">
    <input type="hidden" id="email" value="{{ Session::has('email') }}">
    <input type="hidden" id="company_name" value="{{ Session::has('company_name') }}">
    <input type="hidden" id="total_employee" value="{{ Session::has('total_employee') }}">
    <input type="hidden" id="business_type" value="{{ Session::has('business_type') }}">
    <input type="hidden" id="trade_licence_number" value="{{ Session::has('trade_licence_number') }}">
    <input type="text" hidden id="addGetCountry" value="{{ route('add.getCountry') }}">
@endsection
@section('script')
        <script src="{{asset('frontend/js/registration.js') }}"></script>
@endsection
