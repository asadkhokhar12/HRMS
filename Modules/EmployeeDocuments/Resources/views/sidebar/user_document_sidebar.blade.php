@if (hasPermission('employee_document_type_read') || hasPermission('employee_document_read'))
    <li class="sidebar-menu-item">
        <a href="javascript:void(0)"
            class="parent-item-content has-arrow {{ menu_active_by_route(['documents.index', 'documents.types.index']) }}">
            <span>
                {{ _trans('common.Employee Documents') }}
            </span>
        </a>
        <ul class="child-menu-list  {{ set_active(['documents/*']) }}">
            @if (hasPermission('employee_document_type_read'))
                <li class="nav-item {{ menu_active_by_route('documents.types.index') }}">
                    <a href="{{ route('documents.types.index') }}" class=" {{ set_active('documents/types') }}">
                        <span>{{ _trans('documents.Types') }}</span>
                    </a>
                </li>
            @endif
            @if (hasPermission('employee_document_read'))
                <li class="nav-item {{ menu_active_by_route('documents.index') }}">
                    <a href="{{ route('documents.index') }}" class=" {{ set_active('documents/list') }}">
                        <span>{{ _trans('documents.List') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif