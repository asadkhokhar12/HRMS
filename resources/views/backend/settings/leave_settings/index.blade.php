@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    <div class="content-wrapper cus-content-wrapper">

        <!-- Main content -->
        <div class="container-fluid border-radius-5 p-imp-30">
            <div class="row mt-4">
                <div class="offset-md-3 col-md-6 pr-md-3">
                    <div class="card card-with-shadow border-0">
                        <div class="px-primary py-primary">
                            <h4>{{ _trans('settings.Other leave Information') }}</h4>
                            <hr>
                            <div id="General-0">
                                <fieldset class="form-group mb-5">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label text-capitalize pt-0 pb-0">{{ _trans('settings.Sandwich Leave') }}
                                                </label>
                                                <div class="col-sm-9">
                                                    <div>
                                                        {{ $data['leaveSetting']->sandwich_leave == 1 ? _trans('common.Activated') : _trans('common.Not Activated') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label text-capitalize pt-0 pb-0">{{ _trans('settings.Fiscal Year') }}
                                                </label>
                                                <div class="col-sm-9">
                                                    <div>
                                                        @php
                                                            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                                                        @endphp
                                                        {{ $months[$data['leaveSetting']->month] }} {{ _trans('settings.- December')}}
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label text-capitalize pt-0 pb-0">{{ _trans('settings.Leave Prorate') }}
                                                </label>
                                                <div class="col-sm-9">
                                                    <div>
                                                        {{ $data['leaveSetting']->prorate_leave == 1 ? 'Activated' : 'Not Activated' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="offset-md-4 col-md-4">
                                                    @if(hasPermission('leave_settings_update'))
                                                        <a href="{{ route('leaveSettings.edit') }}"
                                                           class="btn btn-primary pull-right">{{ _trans('settings.Edit information') }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
