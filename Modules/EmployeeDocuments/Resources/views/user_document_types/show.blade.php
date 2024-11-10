@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('content')
<div class="table-content table-basic">
        <div class="card">
            <div class="card-body">
                <h1>User Document Details</h1>
                <a href="{{ route('documents.index') }}" class="btn btn-secondary mb-3">Back to User Documents</a>

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Document Type</th>
                            <td>{{ $userDocument->document_type }}</td>
                        </tr>
                        <tr>
                            <th>Document Number</th>
                            <td>{{ $userDocument->document_number }}</td>
                        </tr>
                        <tr>
                            <th>Document Expiration</th>
                            <td>{{ $userDocument->document_expiration }}</td>
                        </tr>
                        <tr>
                            <th>Document Request Description</th>
                            <td>{{ $userDocument->document_request_description }}</td>
                        </tr>
                        <tr>
                            <th>Document Request Approved</th>
                            <td>
                                @if ($userDocument->document_request_approved)
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Document Request Date</th>
                            <td>{{ $userDocument->document_request_date }}</td>
                        </tr>
                        <tr>
                            <th>Document Notification Date</th>
                            <td>{{ $userDocument->document_notification_date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('backend.partials.table_js')
@endsection