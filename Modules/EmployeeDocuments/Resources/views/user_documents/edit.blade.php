@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('content')
<div class="table-content table-basic">
        <h1>Edit User Document</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user-documents.update', $userDocument->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <select name="user_id" class="form-control ot-form-control ot-input">
                            <option value="">Choose An Employee</option>
                            <option value="1" @if ($userDocument->user_id == 1) selected @endif>Superadmin</option>
                            <option value="2" @if ($userDocument->user_id == 2) selected @endif>Admin</option>
                            <option value="3" @if ($userDocument->user_id == 3) selected @endif>HR</option>
                            <option value="4" @if ($userDocument->user_id == 4) selected @endif>Staff</option>
                        </select>
                    </div>

                    <!-- Document Type -->
                    <div class="form-group mb-3">
                        <label for="document_type">Document Type:</label>
                        <input type="text" class="form-control ot-form-control ot-input" id="document_type" name="document_type"
                            value="{{ old('document_type', $userDocument->document_type) }}" required>
                    </div>

                    <!-- Document Number -->
                    <div class="form-group mb-3">
                        <label for="document_number">Document Number:</label>
                        <input type="text" class="form-control ot-form-control ot-input" id="document_number" name="document_number"
                            value="{{ old('document_number', $userDocument->document_number) }}" required>
                    </div>

                    <!-- Document Expiration -->
                    <div class="form-group mb-3">
                        <label for="document_expiration">Document Expiration:</label>
                        <input type="date" class="form-control ot-form-control ot-input" id="document_expiration" name="document_expiration"
                            value="{{ old('document_expiration', $userDocument->document_expiration) }}">
                    </div>

                    <!-- Document Request Description -->
                    <div class="form-group mb-3">
                        <label for="document_request_description">Request Description:</label>
                        <textarea class="form-control ot-form-control ot-input" id="document_request_description"
                            name="document_request_description"
                            rows="3">{{ old('document_request_description', $userDocument->document_request_description) }}</textarea>
                    </div>

                    <!-- Document Request Approved -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="document_request_approved"
                            name="document_request_approved" value="1"
                            @if ($userDocument->document_request_approved) checked @endif>
                        <label class="form-check-label" for="document_request_approved">Request Approved</label>
                    </div>

                    <!-- Document Request Date -->
                    <div class="form-group mb-3">
                        <label for="document_request_date">Request Date:</label>
                        <input type="date" class="form-control ot-form-control ot-input" id="document_request_date" name="document_request_date"
                            value="{{ old('document_request_date', $userDocument->document_request_date) }}">
                    </div>

                    <!-- Document Notification Date -->
                    <div class="form-group mb-3">
                        <label for="document_notification_date">Notification Date:</label>
                        <input type="date" class="form-control ot-form-control ot-input" id="document_notification_date"
                            name="document_notification_date"
                            value="{{ old('document_notification_date', $userDocument->document_notification_date) }}">
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