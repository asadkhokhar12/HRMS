@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        route('user.index') => _trans('common.Employees'),
        '#' => @$data['title'],
    ]) !!}
    <style>
        .btn {
            padding: 10px 15px;
            font-size: 14px;
        }
    </style>
    <div class="table-content table-basic">
        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf


                    <div class="row mb-3">
                        <div class="col-md-4">
                            {{-- $data['users'] --}}
                            <div class="form-group mb-3">
                                <label class="form-label" for="document_type">Choose A Employee</label>
                                <select name="user_id" id="user_id"
                                    class="form-control ot-form-control ot-input select2" required>
                                    <option value="">Choose A Employee</option>
                                    @foreach ($data['users'] as $key => $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="document_type">Choose Document Type</label>
                                <select name="user_document_type_id" id="user_document_type_id"
                                    class="form-control ot-form-control ot-input select2">
                                    <option value="">Choose Document Type</option>
                                    @foreach ($data['types'] as $key => $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <!-- Document Type -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="document_title">Document Title</label>
                                <input type="text" class="form-control ot-form-control ot-input" id="document_title"
                                    name="document_title" required>
                            </div>

                        </div>
                    </div>



                    <div class="row mb-3">
                        <div class="col-md-4">
                            <!-- Document Number -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="document_number">Document Number:</label>
                                <input type="text" class="form-control ot-form-control ot-input" id="document_number"
                                    name="document_number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Document Expiration -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="document_expiration">Document Expiration:</label>
                                <input type="date" class="form-control ot-form-control ot-input" id="document_expiration"
                                    name="document_expiration">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-20">
                                <label class="mb-10">{{ _trans('common.Attachments') }}</label>
                                <div class="ot_fileUploader left-side mb-20">
                                    <input class="form-control" type="text"
                                        placeholder="{{ _trans('profile.Attachment') }}" name="backend_image" readonly=""
                                        id="placeholder3">
                                    <div class="primary-btn-small-input">
                                        <label class="btn btn-lg ot-btn-primary"
                                            for="fileBrouse3">{{ _trans('common.Browse') }}</label>
                                        <input type="file" class="d-none form-control" name="attachment"
                                            id="fileBrouse3">
                                    </div>
                                </div>

                                @if ($errors->has('attachment'))
                                    <span class="text-danger">{{ $errors->first('attachment') }}</span>
                                @endif
                            </div>

                        </div>
                    </div>

                    <!-- Document Request Description -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="document_request_description">Request Description:</label>
                        <textarea class="form-control ot-form-control ot-textarea" id="document_request_description"
                            name="document_request_description" rows="5"></textarea>
                    </div>





                    <div class="row mb-3">

                        <div class="col-md-4">
                            <!-- Document Request Approved -->
                            <div class="form-check  mt-3">
                                <input class="form-check-input" type="checkbox" id="document_request_approved"
                                    name="document_request_approved" value="1">
                                <label class="form-label" class="form-check-label" for="document_request_approved">Request
                                    Approved</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Document Request Date -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="document_request_date">Request Date:</label>
                                <input type="date" class="form-control ot-form-control ot-input"
                                    id="document_request_date" name="document_request_date">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Document Notification Date -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="document_notification_date">Notification Date:</label>
                                <input type="date" class="form-control ot-form-control ot-input"
                                    id="document_notification_date" name="document_notification_date">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gradian mr-3">Submit</button>
                    <a href="{{ route('documents.index') }}" class="btn btn-secondary  mr-3">Cancel</a>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('script')
    @include('backend.partials.table_js')
@endsection
