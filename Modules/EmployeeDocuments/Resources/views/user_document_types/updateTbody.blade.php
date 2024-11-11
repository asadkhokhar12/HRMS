<table class="table table-bordered">
    <thead class="thead">
        <tr>
            <th class="sorting_asc">SL</th>
            <th class="sorting_asc">Name</th>
            <th class="sorting_asc">Status</th>
            {{-- <th class="sorting_asc">Created At</th> --}}
            <th class="sorting_asc">Actions</th>
        </tr>
    </thead>
    <tbody class="tbody ">
        @if (count($data['items']) > 0)
            @foreach ($data['items'] as $key => $row)
                <tr>
                    <?php $val = request()->entries * (request()->page - 1); ?>
                    <td>{{ $key + 1 + $val}}</td>
                    <td>{{ $row->name }}</td>
                    <td>
                        <small class="badge badge-{{ @$row->status->class }}">{{ @$row->status->name }}</small>
                    </td>
                    {{-- <td>{{ $row->created_at }}</td> --}}

                    <td>
                        @if (hasPermission('employee_document_type_update') || hasPermission('employee_document_type_delete'))
                            <div class="dropdown dropdown-action">
                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if (hasPermission('employee_document_type_update'))
                                        <a class="dropdown-item" href="{{ route('documents.types.edit', $row->id) }}">Edit</a>
                                    @endif
                                    @if (hasPermission('employee_document_type_delete'))
                                        <a class="dropdown-item" href="{{ route('documents.types.delete', $row->id) }}">Delete</a>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr class="odd">
                <td valign="top" colspan="4" class="dataTables_empty">
                    <div class="no-data-found-wrapper text-center ">
                        <img src="{{ asset('assets/images/empty.png') }}" alt="" class="mb-primary empty_table"
                            width="200">
                    </div>
                </td>
            </tr>
        @endif
    </tbody>
</table>

{{-- <div class="ot-pagination d-flex justify-content-end align-content-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            {{ $data['items']->links('pagination::simple-bootstrap-5') }}
        </ul>
    </nav>
</div> --}}
{{ $data['items']->links('employeedocuments::custom_pagination') }}
