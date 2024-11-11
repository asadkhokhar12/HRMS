@extends('frontend.layouts.master')
@section('title', 'Verify')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ _trans('auth.Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ _trans('auth.A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ _trans('auth.Before proceeding, please check your email for a verification link.') }}
                    {{ _trans('auth.If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ _trans('auth.click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
