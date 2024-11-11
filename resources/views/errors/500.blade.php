@extends('errors::minimal')

@section('title', __('Internal Server Error'))


@section('code', '404')

@section('message')
    {{__('Internal Server Error') }}
@endsection
@section('content')

<div class="container text-center mt-5">
    <div class="row mt-5">
        <div class="col-md-12">
            <h1 class="display-4 mt-5">500</h1>
            <p class="lead">Internal Server Error</p>
            <p>Sorry, The 500 Internal Server Error happens when the server encounters an unexpected condition that prevents it from fulfilling the request. This is a general message indicating that the server knows something is wrong, but can't be more specific about the exact problem.</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Go Back to Home</a>
        </div>
    </div>
</div>
@endsection
