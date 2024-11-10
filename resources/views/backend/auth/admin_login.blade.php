@extends('frontend.auth.app')
@section('title', _trans('auth.Sign In'))
@section('content')


    <!-- form heading  -->
    <div class="form-heading mb-40">
        <h1 class="title mb-8">{{ _trans('auth.Sign In') }}</h1>
        <p class="subtitle mb-0">{{ _trans('auth.welcome back please login to your account') }}</p>
        <p>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </p>
    </div>
    <input type="hidden" id="login_success_fully" value="{{ _trans('frontend.Login successfully') }}">
    <!-- Start With form -->
    <form action="#" method="post" id="login"
        class="auth-form d-flex justify-content-center align-items-start flex-column __login_form">
        @csrf

        <input type="hidden" hidden name="is_email" value="1">
        <!-- username input field  -->
        <div class="input-field-group">
            <label for="username">{{ _trans('auth.Email') }} <sup>*</sup></label><br>
            <div class="custom-input-field login__field">
                <input type="email" name="email" class="login__input " id="username"
                    placeholder="{{ _trans('auth.Enter email') }}">
            </div>
            <p class="text-danger cus-error __phone small-text"></p>
        </div>
        <!-- password input field  -->
        <div class="input-field-group ">
            <label for="passwordLoginInput">{{ _trans('auth.Password') }} <sup>*</sup></label><br>
            <div class="custom-input-field password-input login__field">
                <input type="hidden" class="device_uuid" name="device_uuid" value="">
                <input type="password" name="password" class="login__input " id="passwordLoginInput"
                    placeholder="{{ _trans('auth.Enter password') }}">
                <i class="lar la-eye"></i>
            </div>
            <p class="text-danger cus-error __password small-text"></p>
        </div>
        <div class="d-flex justify-content-between w-100">
            <!-- Forget Password link  -->
            <div>
                <a href="{{ route('password.forget') }}" class="fogotPassword ">
                    {{ _trans('auth.Forgot password?') }}</a>
            </div>
        </div>
        <button type="submit" class="submit-btn  __login_btn mb-3 pv-16 mt-32 mb-20">
            {{ _trans('auth.Sign In') }}
        </button>
    </form>
    <div class="row">

        @foreach ($users as $user)
            <div class="col-md-6">
                <form action="#" class="form  justify-content-center align-items-start flex-column mb-3"
                    method="post">
                    @csrf
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" class="device_uuid" name="device_uuid" value="">
                    <input type="hidden" name="password" value="12345678">
                    <button type="button"
                        class="submit-button submit-btn  pv-14 __demo_login_btn admin-login-btn">
                        {{ _trans('auth.Login as') }} {{ $user->name }}

                    </button>
                </form>
            </div>
        @endforeach 
    </div>

@endsection

@section('script')
    <script src="{{ global_asset('/') }}frontend/assets/jquery.min.js"></script>
    <script src="{{ global_asset('frontend/js/device-uuid.min.js') }}"></script>
    <script>
        var uuid = new DeviceUUID().get();
        $('.device_uuid').val(uuid);
        console.log('device_uuid ' + uuid);
    </script>
    <script src="{{ global_asset('/') }}frontend/assets/bootstrap/bootstrap.min.js"></script>
    <script src="{{ global_asset('/') }}backend/js/select2.min.js"></script>
    @include('backend.partials.message')
    <script src="{{ global_asset('js/toastr.js') }}"></script>
    {!! Toastr::message() !!}
    <script src="{{ global_asset('frontend/js/registration.js') }}"></script>
    <script src="{{ global_asset('frontend/js/show-hide-password.js') }}"></script>
@endsection
