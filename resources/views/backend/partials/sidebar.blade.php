<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}" class="img-tag sidebar_logo">
                <!-- @include('backend.auth.backend_logo') -->
                <h3>Cybertron Labs</h1>
            </a>
        </div>

        <button class="half-expand-toggle sidebar-toggle">
            <img src="{{ url('assets/images/icons/collapse-arrow.svg') }}" alt="">
        </button>
        <button class="close-toggle sidebar-toggle">
            <img src="{{ url('assets/images/icons/collapse-arrow.svg') }}" alt="">
        </button>
    </div>
    <div class="sidebar-menu">
        <div class="sidebar-menu-section">
            <!-- parent menu list start  -->
            <ul class="sidebar-dropdown-menu parent-menu-list">
                @if (true || (isModuleActive('Saas') && config('app.mood') == 'Saas'))
                    <li class="sidebar-menu-item {{ menu_active_by_route(['saas.dashboard', 'admin.dashboard']) }}">
                        <a href="{{ isMainCompany() ? route('saas.dashboard') : route('admin.dashboard') }}"
                            class="parent-item-content {{ menu_active_by_route(['saas.dashboard', 'admin.dashboard']) }}">
                            <i class="las la-home"></i>
                            <span class="on-half-expanded">{{ _trans('common.Dashboard') }}</span>
                        </a>
                    </li>
                @else
                    <li class="sidebar-menu-item {{ menu_active_by_route(['admin.dashboard']) }}">
                        <a href="{{ route('admin.dashboard') }}"
                            class="parent-item-content {{ menu_active_by_route(['admin.dashboard']) }}">
                            <i class="las la-home"></i>
                            <span class="on-half-expanded">{{ _trans('common.Dashboard') }}</span>
                        </a>
                    </li>
                @endif
                @if (isMainCompany())
                    @include('saas::backend.sidebar.saas_sidebar')
                @endif
                @if (!isMainCompany() && isModuleActive('Saas') && config('app.mood') == 'Saas' && !env('APP_24hourworx'))
                    @include('saas::backend.sidebar.single_company_sidebar')
                @endif
                @if (!isMainCompany())

                    @if (hasFeature('add_ons') &&
                            hasPermission('addons_menu') &&
                            (isModuleActive('EmployeeDocuments') || isModuleActive('MultiBranch')))
                        <li class="sidebar-menu-item">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow  {{ menu_active_by_route(['branches.index', 'documents.*', 'documents.types.*']) }}">
                                <i class="las la-cog"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('common.Add-ons') }}
                                </span>
                            </a>
                            {{-- {{ set_active(['services/models*', 'services/brands*', 'services/machines*', 'services/packages*', 'services/institutions*', 'services/module-services']) }} --}}
                            <ul
                                class="child-menu-list  {{ set_active(['documents/*', 'documents/types/*', 'documents/list', 'branches']) }}">
                                @if (isModuleActive('EmployeeDocuments'))
                                    @include('employeedocuments::sidebar.user_document_sidebar')
                                @endif


                                @if (config('app.branch') === 'MultiBranch' && isModuleActive('MultiBranch') && hasPermission('branch_read'))
                                    <li
                                        class="sidebar-menu-item {{ menu_active_by_route(['branches.index', 'branches.edit', 'branches.create']) }}">
                                        <a href="{{ route('branches.index') }}"
                                            class=" {{ set_active('dashboard/branches') }}">
                                            <span>{{ _trans('common.Branches') }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                    {{-- utf8 --}}

                    @if (hasPermission('hr_menu') && hasFeature('hr'))

                        <li class="sidebar-menu-item">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow {{ menu_active_by_route(['designation.index', 'designation.edit', 'designation.create', 'department.index', 'department.edit', 'department.create', 'roles.index', 'roles.edit', 'roles.create']) }}">
                                <i class="las la-user-tie"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('common.HR') }}
                                </span>
                            </a>
                            <ul
                                class="child-menu-list {{ set_active(['hrm/designation*', 'hrm/department*', 'hrm/roles*']) }}">

                                @if (hasPermission('designation_read'))
                                    <li
                                        class="sidebar-menu-item {{ menu_active_by_route(['designation.index', 'designation.edit', 'designation.create']) }}">
                                        <a href="{{ route('designation.index') }}"
                                            class="  {{ set_active(route('designation.index')) }}">
                                            <span>{{ _trans('common.Designations') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('department_read'))
                                    <li
                                        class="sidebar-menu-item {{ menu_active_by_route(['department.index', 'department.edit', 'department.create']) }}">
                                        <a href="{{ route('department.index') }}"
                                            class="  {{ set_active(route('department.index')) }}">
                                            <span>{{ _trans('common.Departments') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (hasPermission('role_read'))
                                    <li
                                        class="sidebar-menu-item {{ menu_active_by_route(['roles.index', 'roles.edit', 'roles.create']) }}">
                                        <a href="{{ route('roles.index') }}"
                                            class=" {{ set_active('dashboard/roles') }}">
                                            <span>{{ _trans('common.Roles') }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                    @if (isModuleActive('MenuPermission'))
                        <li class="sidebar-menu-item">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow {{ menu_active_by_route(['menu_manage.menu.index']) }}">
                                <i class="las la-bars"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('common.Menu Manage') }}
                                </span>
                            </a>
                            <ul class="child-menu-list {{ set_active(['menu-manage/menu']) }}">
                                {{-- @if (hasPermission('role_read')) --}}
                                <li class="sidebar-menu-item {{ menu_active_by_route(['menu_manage.menu.index']) }}">
                                    <a href="{{ route('menu_manage.menu.index') }}"
                                        class=" {{ set_active('menu-manage/menu') }}">
                                        <span>{{ _trans('common.Menu') }}</span>
                                    </a>
                                </li>
                                {{-- @endif --}}
                            </ul>
                        </li>
                    @endif

                    @if (hasPermission('user_menu'))
                        <li class="sidebar-menu-item ">
                            <a href="{{ route('user.index') }}"
                                class="parent-item-content {{ menu_active_by_route(['user.index', 'user.edit', 'user.create']) }}">
                                <i class="las la-user"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('common.Employees') }}
                                </span>
                            </a>
                        </li>
                    @endif

                    {{-- @if (isModuleActive('SingleDeviceLogin') && hasPermission('user_device_list'))
                        <li class="sidebar-menu-item ">
                            <a href="{{ route('users_device.index') }}"
                                class="parent-item-content {{ menu_active_by_route(['users_device.index']) }}">
                                <i class="las la-calendar-check"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('common.Device Management') }}
                                </span>
                            </a>
                        </li>
                    @endif --}}


                    {{-- @if (isModuleActive('Services') && hasFeature('services') && hasPermission('service_menu'))
                        @include('services::sidebar.service_sidebar')
                    @endif --}}

                    @if (hasPermission('leave_request_read') && hasFeature('leaves'))
                        <li
                            class="sidebar-menu-item {{ set_menu([route('leave.index'), route('assignLeave.index')]) }}">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow {{ menu_active_by_route(['leave.index', 'leave.create', 'leave.edit', 'assignLeave.index', 'assignLeave.create', 'assignLeave.edit', 'leaveRequest.index', 'leaveRequest.create', 'daily_leave.index', 'daily_leave.create']) }}">
                                <i class="las la-sign-out-alt"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('common.Leaves') }}
                                </span>
                            </a>
                            <ul
                                class="child-menu-list {{ set_active(['hrm/leave*', 'hrm/leave/assign*', 'hrm/leave/request*', 'dashboard/user/leave-balance*', 'hrm/daily-leave*']) }}">
                                @if (hasPermission('leave_type_read'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['leave.index', 'leave.create', 'leave.edit']) }}">
                                        <a href="{{ route('leave.index') }}"
                                            class=" {{ set_active(route('leave.index')) }}">
                                            <span>{{ _trans('common.Type') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('leave_assign_read'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['assignLeave.index', 'assignLeave.create', 'assignLeave.edit']) }}">
                                        <a href="{{ route('assignLeave.index') }}"
                                            class=" {{ set_active(route('assignLeave.index')) }}">
                                            <span> {{ _trans('leave.Assign Leave') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('leave_request_read') )
                                    <li
                                        class="nav-item {{ menu_active_by_route(['leaveRequest.index', 'leaveRequest.create']) }}">
                                        <a href="{{ route('leaveRequest.index') }}"
                                            class=" {{ set_active(route('leaveRequest.index')) }}">
                                            <span>{{ _trans('leave.Leave Request') }}</span>
                                        </a>
                                    </li>
                                @endif
                                <!-- @if (Auth::user()->role)
                                    @if (Auth::user()->role->name === 'Staff')
                                        <li
                                            class="nav-item {{ menu_active_by_route('user.authProfile', ['leave_request']) }}">
                                            <a href="{{ route('user.authProfile', ['leave_request']) }}"
                                                class="{{ set_active(route('user.authProfile', ['leave_request'])) }}">
                                                <span>{{ _trans('leave.Leave Request') }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif -->



                                {{-- @if (auth()->user()->userRole(['Staff']))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['leaveRequest.index', 'leave.balance.user', auth()->id()]) }}">
                                        <a href="{{ route('leave.balance.user', auth()->id()) }}"
                                            class=" {{ set_active(route('leave.balance.user', auth()->id())) }}">
                                            <span>{{ _trans('leave.Leave Balance') }}</span>
                                        </a>
                                    </li>
                                @endif --}}
                                {{-- @if (hasPermission('daily_leave_read'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['daily_leave.index', 'daily_leave.create']) }}">
                                        <a href="{{ route('daily_leave.index') }}"
                                            class=" {{ set_active(route('daily_leave.index')) }}">
                                            <span>{{ _trans('leave.Daily Leave') }}</span>
                                        </a>
                                    </li>
                                @endif --}}
                                @if (hasPermission('leave_type_read'))
                                    <li class="nav-item {{ menu_active_by_route(['leaveRequest.balance']) }}">
                                        <a href="{{ route('leaveRequest.balance') }}"
                                            class=" {{ set_active(route('leaveRequest.balance')) }}">
                                            <span>{{ _trans('common.Leave Balance') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (hasPermission('attendance_menu') && hasFeature('attendance'))
                        <li class="sidebar-menu-item">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow {{ menu_active_by_route(['attendance.index', 'hrm.qr.index']) }}">
                                <i class="las la-user-check"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('attendance.Attendance') }}
                                </span>
                            </a>

                            <ul class="child-menu-list {{ set_active(['hrm/attendance*', 'hrm/qr-code*']) }}">
                                @if (hasPermission('attendance_read'))
                                    <li class="nav-item {{ menu_active_by_route('attendance.index') }}">
                                        <a href="{{ route('attendance.index') }}"
                                            class=" {{ set_active(route('attendance.index')) }}">
                                            <span>{{ _trans('attendance.Attendance') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (Auth::user()->role)
                                    @if (Auth::user()->role->name === 'Staff')
                                        @if (hasPermission('attendance_read'))
                                            <li
                                                class="nav-item {{ menu_active_by_route('employeeAttendance', auth()->id()) }}">
                                                <a href="{{ route('employeeAttendance', auth()->id()) }}"
                                                    class=" {{ set_active(route('employeeAttendance', auth()->id())) }}">
                                                    <span>{{ _trans('attendance.Attendance Summary') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                @endif

                                @if (hasPermission('hr_menu') && hasFeature('hr'))
                                    <li class="nav-item {{ menu_active_by_route('machine.attendance') }}">
                                        <a href="{{ route('machine.attendance') }}"
                                            class=" {{ set_active(route('machine.attendance')) }}">
                                            <span>{{ _trans('attendance.Machine Attendance') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (hasPermission('attendance_read') && isModuleActive('FaceAttendance'))
                                    <li class="nav-item {{ menu_active_by_route('attendance.face') }}">
                                        <a href="{{ route('attendance.face') }}" target="_blank"
                                            class=" {{ set_active(route('attendance.face')) }}">
                                            <span>{{ _trans('attendance.Face_Attendance') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (isModuleActive('QrBasedAttendance') && hasPermission('generate_qr_code') && settings('attendance_method') == 'QR')
                                    @include('qrbasedattendance::partials.sidebar.menu')
                                @endif
                            </ul>
                        </li>
                    @endif
                    {{-- @if (hasPermission('conference_read') && isModuleActive('VideoConference') && hasFeature('conference'))
                        <li class="sidebar-menu-item ">
                            <a href="{{ route('conference.index') }}"
                                class="parent-item-content {{ menu_active_by_route(['conference-index']) }}">
                                <i class="las la-microphone"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('videoconference.Conference') }}
                                </span>
                            </a>
                        </li>
                    @endif
                    @if (hasPermission('payroll_menu') && hasFeature('payroll'))
                        <li class="sidebar-menu-item {{ set_menu([route('hrm.payroll_items.index')]) }}">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow {{ menu_active_by_route(['hrm.payroll_items.index', 'hrm.payroll_setup.index', 'hrm.payroll_setup.user_setup', 'hrm.payroll_setup.user_commission_setup', 'hrm.payroll_advance_type.index', 'hrm.payroll_advance_salary.index', 'hrm.payroll_advance_salary.create', 'hrm.payroll_advance_salary.edit', 'hrm.payroll_advance_salary.show', 'hrm.payroll_salary.index', 'hrm.payroll_salary.show', 'hrm.payroll_salary.invoice']) }}">
                                <i class="las la-comment-dollar"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('payroll.Payroll') }}

                                </span>
                            </a>
                            <ul class="child-menu-list {{ set_active(['hrm/payroll*']) }}">

                                @if (hasPermission('payroll_item_menu'))
                                    <li class="nav-item {{ menu_active_by_route(['hrm.payroll_items.index']) }}">
                                        <a href="{{ route('hrm.payroll_items.index') }}" class="">
                                            <span> {{ _trans('payroll.Commissions') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('payroll_set_menu'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['hrm.payroll_setup.index', 'hrm.payroll_setup.user_setup', 'hrm.payroll_setup.user_commission_setup']) }}">
                                        <a href="{{ route('hrm.payroll_setup.index') }}" class="">
                                            <span> {{ _trans('payroll.Setup') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (hasPermission('advance_type_list'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['hrm.payroll_advance_type.index']) }}">
                                        <a href="{{ route('hrm.payroll_advance_type.index') }}" class="">
                                            <span> {{ _trans('payroll.Advance Type') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('advance_salaries_list'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['hrm.payroll_advance_salary.index', 'hrm.payroll_advance_salary.create', 'hrm.payroll_advance_salary.edit', 'hrm.payroll_advance_salary.show']) }}">
                                        <a href="{{ route('hrm.payroll_advance_salary.index') }}" class="">
                                            <span> {{ _trans('payroll.Advance') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (hasPermission('salary_list'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['hrm.payroll_salary.index', 'hrm.payroll_salary.show', 'hrm.payroll_salary.invoice']) }}">
                                        <a href="{{ route('hrm.payroll_salary.index') }}" class="">
                                            <span> {{ _trans('payroll.Salary Generate') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (hasPermission('payroll_set_menu'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['hrm.monthly.salary.table', 'hrm.payroll_salary.show', 'hrm.payroll_salary.invoice']) }}">
                                        <a href="{{ route('hrm.monthly.salary.table') }}" class="">
                                            <span> {{ _trans('payroll.Salary Sheet') }}</span>
                                        </a>
                                    </li>
                                @endif


                            </ul>
                        </li>
                    @endif
                    @if (hasPermission('account_menu') && hasFeature('accounts'))
                        <li
                            class="sidebar-menu-item {{ set_menu([route('hrm.accounts.index', 'hrm.accounts.create')]) }}">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow {{ menu_active_by_route(['hrm.accounts.index', 'hrm.deposits.index', 'hrm.expenses.index', 'hrm.transactions.index', 'hrm.accounts.create', 'hrm.accounts.edit', 'hrm.deposits.create', 'hrm.deposits.edit', 'hrm.expenses.create', 'hrm.expenses.edit', 'hrm.expenses.show', 'hrm.deposit_category.deposit', 'hrm.deposit_category.expense', 'hrm.payment_method.index']) }}">
                                <i class="las la-file-invoice-dollar"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('payroll.Accounts') }}

                                </span>
                            </a>
                            <ul
                                class="child-menu-list {{ set_active(['hrm/accounts*', 'hrm/transactions*', 'hrm/deposit*', 'hrm/expenses*', 'hrm/account-settings*', 'hrm/payment-method*']) }}">


                                @if (hasPermission('account_menu'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['hrm.accounts.index', 'hrm.accounts.create', 'hrm.accounts.edit']) }}">
                                        <a href="{{ route('hrm.accounts.index') }}" class="">
                                            <span> {{ _trans('payroll.Account List') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (hasPermission('deposit_menu'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['hrm.deposits.index', 'hrm.deposits.create', 'hrm.deposits.edit']) }}">
                                        <a href="{{ route('hrm.deposits.index') }}" class="">
                                            <span> {{ _trans('payroll.Deposit') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (hasPermission('expense_menu'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['hrm.expenses.index', 'hrm.expenses.create', 'hrm.expenses.edit', 'hrm.expenses.show']) }}">
                                        <a href="{{ route('hrm.expenses.index') }}" class="">
                                            <span> {{ _trans('payroll.Expense') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (hasPermission('transaction_menu'))
                                    <li class="nav-item {{ menu_active_by_route(['hrm.transactions.index']) }}">
                                        <a href="{{ route('hrm.transactions.index') }}" class="">
                                            <span> {{ _trans('payroll.Transaction History') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('deposit_category_menu'))
                                    <li
                                        class="sidebar-menu-item {{ set_menu([route('hrm.deposit_category.expense')]) }}">
                                        <a href="javascript:void(0)"
                                            class="parent-item-content has-arrow {{ menu_active_by_route(['hrm.deposit_category.deposit', 'hrm.deposit_category.expense', 'hrm.payment_method.index']) }}">
                                            <span class="-text font-purple">
                                                {{ _trans('payroll.Accounts Settings') }}

                                            </span>
                                        </a>
                                        <ul
                                            class="child-menu-list {{ set_active(['hrm/account-settings*', 'hrm/payment-method*']) }} pl-2">


                                            @if (hasPermission('deposit_category_menu'))
                                                <li
                                                    class="nav-item {{ menu_active_by_route(['hrm.deposit_category.deposit']) }}">
                                                    <a href="{{ route('hrm.deposit_category.deposit') }}"
                                                        class="">
                                                        <span> {{ _trans('payroll.Deposit Category') }}</span>
                                                    </a>
                                                </li>
                                            @endif

                                            @if (hasPermission('deposit_category_menu'))
                                                <li
                                                    class="nav-item {{ menu_active_by_route(['hrm.deposit_category.expense']) }}">
                                                    <a href="{{ route('hrm.deposit_category.expense') }}"
                                                        class="">
                                                        <span> {{ _trans('expense.Expense Category') }}</span>
                                                    </a>
                                                </li>
                                            @endif

                                            @if (hasPermission('payment_method_menu'))
                                                <li
                                                    class="nav-item {{ menu_active_by_route(['hrm.payment_method.index']) }}">
                                                    <a href="{{ route('hrm.payment_method.index') }}"
                                                        class="">
                                                        <span> {{ _trans('payment_method.Payment Method') }}</span>
                                                    </a>
                                                </li>
                                            @endif

                                        </ul>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif --}}
                    {{-- Start Client Module --}}
                    {{-- @include('backend.client.sidebar') --}}
                    {{-- End Client Module --}}

                    {{-- task management start --}}
                    <!-- @include('backend.task.sidebar') -->
                    {{-- project management end --}}

                    {{-- project management start --}}
                    <!-- @include('backend.project.sidebar') -->
                    {{-- project management end --}}

                    {{-- award management start --}}
                    <!-- @include('backend.award.sidebar') -->
                    {{-- award management end --}}

                    {{-- Start Travel Routes --}}
                    <!-- @include('backend.travel.sidebar') -->
                    {{-- End Travel Routes --}}



                    {{-- Start performance Routes --}}
                    {{-- @include('backend.performance.sidebar') --}}
                    {{-- End performance Routes --}}

                    {{-- Start meeting Routes --}}
                    {{-- @include('backend.meeting.sidebar') --}}
                    {{-- End meeting Routes --}}
                    {{-- @if (hasPermission('appointment_menu') && hasFeature('appointment'))
                        <li
                            class="sidebar-menu-item {{ set_menu([route('appointment.index', 'appointment.create')]) }}">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow  {{ menu_active_by_route(['appointment.index', 'appointment.create']) }}">
                                <i class="las la-calendar-check"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('appointment.Appointment') }}

                                </span>
                            </a>
                            <ul class="child-menu-list {{ set_active(['hrm/appointment*']) }}">

                                <li
                                    class="nav-item {{ menu_active_by_route(['appointment.index', 'appointment.create']) }}">
                                    <a href="{{ route('appointment.index') }}"
                                        class="  {{ set_active(route('appointment.index', 'appointment.create')) }}">
                                        <span>{{ _trans('common.List') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (hasPermission('visit_menu') && hasFeature('visit'))
                        <li class="sidebar-menu-item {{ set_menu([route('visit.index')]) }}">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow {{ menu_active_by_route(['visit.index']) }}">
                                <i class="las la-map-marked-alt"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('common.Visit') }}

                                </span>
                            </a>
                            <ul class="child-menu-list {{ set_active(['hrm/visit*']) }}">
                                @if (hasPermission('visit_read'))
                                    <li class="nav-item {{ menu_active_by_route(['visit.index']) }}">
                                        <a href="{{ route('visit.index') }}" class="">
                                            <span>{{ _trans('common.Manage visit') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (hasPermission('support_menu') && hasFeature('support'))
                        <li
                            class="sidebar-menu-item {{ set_menu([route('supportTicket.index', 'supportTicket.create')]) }}">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow {{ menu_active_by_route(['supportTicket.index', 'supportTicket.create', 'supportTicket.reply']) }}">
                                <i class="las la-ticket-alt"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('common.Support') }}

                                </span>
                            </a>
                            <ul class="child-menu-list {{ set_active(['hrm/support/ticket*']) }}">
                                @if (hasPermission('support_read') || hasPermission('support_read_all'))
                                    <li
                                        class="nav-item {{ menu_active_by_route(['supportTicket.index', 'supportTicket.create', 'supportTicket.reply']) }}">
                                        <a href="{{ route('supportTicket.index') }}" class="">
                                            <span> {{ _trans('common.Tickets') }}</span> </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (hasPermission('announcement_menu') && hasFeature('announcement'))
                        <li
                            class="sidebar-menu-item  {{ set_menu(['notice.index', 'notice.create', 'notice.edit']) }} ">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow {{ menu_active_by_route(['notice.index', 'notice.create', 'notice.edit']) }}">
                                <i class="las la-bullhorn"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('common.Announcement') }}

                                </span>
                            </a>
                            <ul
                                class="child-menu-list  {{ set_active(['announcement/*', 'dashboard/announcement/*']) }}">

                                @if (hasPermission('notice_menu'))
                                    <li
                                        class="nav-item  {{ menu_active_by_route(['notice.index', 'notice.create', 'notice.edit']) }} ">
                                        <a href="{{ route('notice.index') }}"
                                            class="  {{ menu_active_by_route(['notice.index', 'notice.create', 'notice.edit']) }} ">
                                            <span>{{ _trans('common.Notice') }}</span> <span
                                                class="badge badge-info d-none fs-6 p-s">5</span> </a>
                                    </li>
                                @endif

                                @if (hasPermission('send_email_menu'))
                                    <li class="nav-item d-none">
                                        <a href="#" class="">
                                            <span>{{ _trans('common.Send E-mail') }}</span> </a>
                                    </li>
                                @endif
                                @if (hasPermission('send_notification_menu'))
                                    <li class="nav-item d-none">
                                        <a href="#" class="">
                                            <span>{{ _trans('common.Send Notification') }}</span> </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (hasPermission('contact_menu') && hasFeature('contacts'))
                        <li class="sidebar-menu-item">
                            <a href="{{ route('contact.index') }}"
                                class="parent-item-content {{ menu_active_by_route(['contact.index']) }}">
                                <i class="las la-address-book"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('common.Contacts') }}
                                </span>
                            </a>
                        </li>
                    @endif


                    @if (hasPermission('report_menu') && hasFeature('report'))
                        <li class="sidebar-menu-item {{ set_menu([route('attendanceReport.index')]) }}">
                            <a href="javascript:void(0)"
                                class="parent-item-content has-arrow {{ menu_active_by_route(['live_trackingReport.index', 'attendanceReport.index', 'breakReport.index', 'payment.index', 'report_visit.index', 'report_leave']) }}">
                                <i class="las la-clipboard-list"></i>
                                <span class="on-half-expanded">
                                    {{ _trans('common.Report') }}

                                </span>
                            </a>
                            <ul
                                class="child-menu-list {{ set_active(['hrm/report/*', 'hrm/break/*', 'hrm/expense/payment']) }}">

                                @if (hasPermission('live_tracking_read'))
                                    <li class="nav-item {{ menu_active_by_route(['live_trackingReport.index']) }}">
                                        <a href="{{ route('live_trackingReport.index') }}"
                                            class=" {{ set_active(route('live_trackingReport.index')) }}">
                                            <span>{{ _trans('common.Live Tracking') }}</span>
                                        </a>
                                    </li>
                                    <li
                                        class="d-none nav-item {{ menu_active_by_route(['live_trackingReportHistory.index']) }}">
                                        <a href="{{ route('live_trackingReportHistory.index') }}"
                                            class=" {{ set_active(route('live_trackingReportHistory.index')) }}">
                                            <span>{{ _trans('common.Location History') }}</span>
                                        </a>
                                    </li>
                                    <li
                                        class="nav-item {{ menu_active_by_route(['live_trackingReportTimeline.index']) }}">
                                        <a href="{{ route('live_trackingReportTimeline.index') }}"
                                            class=" {{ set_active(route('live_trackingReportTimeline.index')) }}">
                                            <span>{{ _trans('common.Location Timeline') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (hasPermission('attendance_report_read'))
                                    <li class="nav-item {{ menu_active_by_route(['attendanceReport.index']) }}">
                                        <a href="{{ route('attendanceReport.index') }}"
                                            class=" {{ set_active(route('attendanceReport.index')) }}">
                                            <span>{{ _trans('attendance.Attendance report') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ menu_active_by_route(['breakReport.index']) }}">
                                        <a href="{{ route('breakReport.index') }}"
                                            class=" {{ set_active(route('breakReport.index')) }}">
                                            <span>{{ _trans('common.Break report') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (hasPermission('daily_leave_read'))
                                    <li class="nav-item {{ menu_active_by_route(['leaveReport.index']) }}">
                                        <a href="{{ route('leaveReport.index') }}"
                                            class=" {{ set_active(route('leaveReport.index')) }}">
                                            <span>{{ _trans('leave.Leave Report') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (hasPermission('payment_read'))
                                    <li class="nav-item {{ menu_active_by_route(['payment.index']) }}">
                                        <a href="{{ route('payment.index') }}"
                                            class=" {{ set_active(route('payment.index')) }}">
                                            <span>{{ _trans('common.Payment Report') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('visit_read'))
                                    <li class="nav-item {{ menu_active_by_route(['report_visit.index']) }}">
                                        <a href="{{ route('report_visit.index') }}" class="">
                                            <span>{{ _trans('common.Visit Reports') }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif --}}

                    <!-- @include('backend.partials.configurations-sidebar')

                    @include('backend.partials.settings-sidebar') -->

                @endif
            </ul>
            <!-- parent menu list end  -->
        </div>
    </div>
</aside>
