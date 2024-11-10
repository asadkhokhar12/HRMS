<table class="table table-bordered">
    <thead class="thead">
        <tr>
            <th class="sorting_asc">SL</th>
            <th class="sorting_asc">Employee</th>
            <th class="sorting_asc">Title</th>
            <th class="sorting_asc">Number</th>
            <th class="sorting_asc">Expiration</th>
            <th class="sorting_asc">Request Description</th>
            <th class="sorting_asc">Request Approved</th>
            <th class="sorting_asc">Request Date</th>
            <th class="sorting_asc">Notification Date</th>
            <th class="sorting_asc">Attachment</th>
        </tr>
    </thead>
    <tbody class="tbody ">
        @if (count($data['items']) > 0)
            @foreach ($data['items'] as $key => $row)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ @$row->user->name }}</td>
                    <td>{{ $row->document_title }}</td>
                    <td>{{ $row->document_number }}</td>
                    <td>{{ $row->document_expiration }}</td>
                    <td>{{ $row->document_request_description }}</td>
                    <td>
                        @if ($row->document_request_approved)
                            Yes
                        @else
                            No
                        @endif
                    </td>
                    <td>{{ $row->document_request_date }}</td>
                    <td>{{ $row->document_notification_date }}</td>
                    <td>
                        @if (hasPermission('employee_document_download'))
                            <a href="{{ uploaded_asset(@$row->attachment_id) }}">Download</a>
                        @endif
                    </td>
                    {{-- <td>
                        <div class="dropdown dropdown-action">
                            <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">

                                <a class="dropdown-item"
                                    href="{{ route('user-documents.show', $row->id) }}">View</a>
                                <a class="dropdown-item"
                                    href="{{ route('user-documents.edit', $row->id) }}">Edit</a>
                            </ul>
                        </div>
                    </td> --}}
                </tr>
            @endforeach
        @else
            <tr class="odd">
                <td valign="top" colspan="9" class="dataTables_empty">
                    <div class="no-data-found-wrapper text-center ">
                        <img src="{{ asset('assets/images/empty.png') }}" alt="" class="mb-primary empty_table"
                            width="200">
                    </div>
                </td>
            </tr>
        @endif
    </tbody>
</table>
{{ $data['items']->links('employeedocuments::custom_pagination') }}
