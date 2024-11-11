{{-- @extends('frontend.layouts.app') --}}
@extends('frontend.includes.master')

@section('title', @$data['title'])
@section('content')

    <div class="new-main-content">
        <div class="container">
            <div class="row py-5 mt-5">
                <div class="col-md-12">
                    <h3 class="fs_30 grayColor1">{{ $data['show']->title }}</h3>
                    <p>
                        {!! @$data['show']->content !!}
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
