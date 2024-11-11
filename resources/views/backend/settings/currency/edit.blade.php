@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
{!! breadcrumb([ 'title' => @$data['title'], route('admin.dashboard') => _trans('common.Dashboard'), '#' => @$data['title']]) !!}
    <div class="table-basic table-content">
        <div class="card">
            <div class="card-body">
                <div class="">
                    <div class="">
                        <div class="px-primary py-primary">
                            <div id="General-0">
                                <fieldset class="form-group mb-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form  action="{{route('manage.settings.update_currency')}}"  method="post" enctype="multipart/form-data">
                                                @csrf
                                                      <input type="hidden" name="id" value="{{$data['currency']->id}}">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <!-- Document Type -->
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="document_type">{{ _trans('settings.Currency Name') }}</label>
                                                            <input required type="text" value="{{$data['currency']->name}}" class="form-control ot-form-control ot-input" id="name"
                                                                   name="name"  >
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="document_type">{{ _trans('settings.Currency Code') }}</label>
                                                            <input required type="text" value="{{$data['currency']->code}}" class="form-control ot-form-control ot-input" id="name"
                                                                   name="code"  >
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="document_type">{{ _trans('settings.Currency Icon') }}</label>
                                                            <input  required type="text" value="{{$data['currency']->symbol}}" class="form-control ot-form-control ot-input" id="name"
                                                                   name="symbol"  >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-gradian mr-3">Submit</button>
                                                    </div>
                                                </div>

                                            </form>
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
    <input type="hidden" id="appScreenSetupUpdate" value="{{ route('appScreenSetupUpdate') }}">
    <input type="hidden" id="token" value="{{ csrf_token() }}">
@endsection
