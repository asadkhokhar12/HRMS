@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        route('documents.types.index') => _trans('common.Document Types'),
        '#' => @$data['title'],
    ]) !!}
    <div class="table-content table-basic">
        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ $data['url'] }}" method="PATCH" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ @$data['edit']->id }}">


                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Document Type -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="document_type">Document Type</label>
                                <input type="text" class="form-control ot-form-control ot-input" id="name"
                                    name="name" value="{{ @$data['edit']->name?? old('name') }}" >

                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="document_type">Choose Status</label>
                                <select name="status_id" id="status_id"
                                    class="form-control ot-form-control ot-input select2" required>
                                    <option value="">Choose A Status</option>
                                    <option value="1" @if(@$data['edit']->status_id ==1)  selected @endif >{{ _trans('common.Active') }}</option>
                                    <option value="4"  @if(@$data['edit']->status_id ==4)  selected @endif >{{ _trans('common.Inactive') }}</option>
                                </select>
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

    </div>
@endsection
@section('script')
    @include('backend.partials.table_js')
@endsection
