@extends('errors::minimal')

@section('title', __('Not Found'))


@section('code', '404')

@section('message')
    {{'Not Found' }}
@endsection
@section('content')
<div class="container text-center">
    <div class="row">
        <div class="col-md-12">
            <h1 class="display-4">503</h1>
            <p class="lead">Page Not Found</p>
            <p>Sorry, the page you are looking for does not exist.</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Go Back to Home</a>
        </div>
    </div>
</div>
@endsection
