@if (hasPermission('meeting_menu') && hasFeature('meeting'))
    <li class="sidebar-menu-item">
        <a href="javascript:void(0)" class="parent-item-content has-arrow {{ menu_active_by_route(['meeting.index','meeting.create','meeting.edit','meeting.view']) }}">
            <i class="las la-handshake"></i>
            <span class="on-half-expanded">
                {{ _trans('meeting.Meeting') }}
            </span>
        </a>
        <ul class="child-menu-list {{ set_active(['admin/meeting*']) }}">

            @if (hasPermission('meeting_list'))
                <li class="sidebar-menu-item {{ menu_active_by_route(['meeting.index','meeting.create','meeting.edit','meeting.view']) }}">
                    <a href="{{ route('meeting.index') }}">
                        <span> {{ _trans('meeting.Meeting List') }}</span>
                    </a>
                </li>
            @endif

        </ul>
    </li>
@endif
