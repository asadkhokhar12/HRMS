

@if (hasPermission('company_setup_menu') && hasFeature('configurations'))
<li class="sidebar-menu-item">
    <a href="javascript:void(0)"
        class="parent-item-content has-arrow {{ menu_active_by_route([
            'company.settings.configuration',
            'weekendSetup.index',
            'holidaySetup.index',
            'dutySchedule.index',
            'shift.index',
            'ipConfig.index',
            'ipConfig.create',
            'company.settings.location',
            'company.settings.locationCreate',
            'company.settings.locationEdit',
            'company.settings.activation',
            'holidaySetup.create',
            'holidaySetup.show',
            'dutySchedule.create',
            'dutySchedule.edit',
        ]) }}">
    <i class="las la-tools"></i>
    <span class="on-half-expanded">
        {{ _trans('common.Configurations') }}

    </span>
</a>
<ul
    class="child-menu-list  {{ set_active(['admin/company-setup*', 'hrm/weekend/setup*', 'hrm/holiday/setup*', 'hrm/duty/schedule*', 'hrm/shift*', 'hrm/ip-whitelist*', 'hrm/location*']) }}">

    @if (hasPermission('company_setup_configuration'))
    <li class="nav-item {{ menu_active_by_route(['company.settings.configuration']) }}">
        <a href="{{ route('company.settings.configuration') }}" class=" ">
            <span>{{ _trans('common.Configurations') }}</span>
        </a>
    </li>
    @endif

    @if (!isMainCompany())
        @if (hasPermission('weekend_read'))
        <li class="nav-item {{ menu_active_by_route(['weekendSetup.index']) }}">
            <a href="{{ route('weekendSetup.index') }}"
                class=" {{ set_active([route('weekendSetup.index')]) }}">
                <span>{{ _trans('attendance.Weekend Setup') }}</span>
            </a>
        </li>
        @endif
        @if (hasPermission('holiday_read'))
        <li
            class="nav-item {{ menu_active_by_route(['holidaySetup.index', 'holidaySetup.create', 'holidaySetup.show']) }}">
            <a href="{{ route('holidaySetup.index') }}"
                class=" {{ menu_active_by_route(['holidaySetup.index', 'holidaySetup.create', 'holidaySetup.show']) }}">
                <span>{{ _trans('attendance.Holiday Setup') }}</span>
            </a>
        </li>
        @endif
        @if (hasPermission('shift_read'))
        <li class="nav-item {{ menu_active_by_route('shift.index') }}">
            <a href="{{ route('shift.index') }}" class=" {{ set_active(route('shift.index')) }}">
                <span>{{ _trans('attendance.Shift Setup') }}</span>
            </a>
        </li>
        @endif
        @if (hasPermission('schedule_read'))
        <li
            class="nav-item {{ menu_active_by_route(['dutySchedule.index', 'dutySchedule.create', 'dutySchedule.show']) }}">
            <a href="{{ route('dutySchedule.index') }}"
                class=" {{ menu_active_by_route(['dutySchedule.index', 'dutySchedule.create', 'dutySchedule.show']) }}">
                <span>{{ _trans('attendance.Duty Schedule') }}</span>
            </a>
        </li>
        @endif




        @if (isModuleActive('IpBasedAttendance') && hasPermission('ip_read'))
            @include('ipbasedattendance::partials.sidebar.menu')
        @endif

        @if (isModuleActive('AreaBasedAttendance') && hasPermission('company_setup_location'))
            @include('areabasedattendance::partials.sidebar.menu')
        @endif

        @if (hasPermission('company_setup_activation'))
        <li class="nav-item {{ menu_active_by_route('company.settings.activation') }}">
            <a href="{{ route('company.settings.activation') }}" class="">
                <span>{{ _trans('common.Activation') }}</span>
            </a>
        </li>
        @endif
    @endif
</ul>
</li>
@endif