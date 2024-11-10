<!-- profile menu mobile start -->
<div class="profile-content">
    <div class="profile-menu-mobile">
        <button class="btn-menu-mobile" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasWithBothOptionsMenuMobile" aria-controls="offcanvasWithBothOptionsMenuMobile">
            <span class="icon"><i class="fa-solid fa-bars"></i></span>
        </button>

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1"
            id="offcanvasWithBothOptionsMenuMobile">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <span class="icon"><i class="fa-solid fa-xmark"></i></span>
                </button>
            </div>
            <div class="offcanvas-body">
                <!-- profile menu start -->
                <div class="profile-menu">
                    <!-- profile menu head start -->
                    <div class="profile-menu-head">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img class="img-fluid rounded-circle"
                                    src="{{ @$data['show']->original['data']['avatar'] }}" width="60"
                                    alt="profile image" />
                            </div>
                            <div class="flex-grow-1">
                                <div class="body">
                                    <h2 class="title">{{ @$data['name'] }}</h2>
                                    <p class="paragraph">{{ @$data['name'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- profile menu head end -->

                    <!-- profile menu body start -->
                    <div class="profile-menu-body">
                        <nav>
                            <ul class="nav flex-column">
                                <li class="nav-item dropdown">
                                    <a class="nav-link {{ menu_active_by_url(route('user.authProfile', ['personal'])) }}"
                                        href="{{ route('user.authProfile', ['personal']) }}">
                                        {{ _trans('common.Profile') }}
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link {{ menu_active_by_url(route('user.authProfile', ['settings'])) }}"
                                        href="{{ route('user.authProfile', ['settings']) }}">
                                        {{ _trans('common.Settings') }}
                                    </a>
                                </li>
                                @if (hasPermission('contract_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['contract'])) }}"
                                            href="{{ route('user.authProfile', ['contract']) }}">
                                            {{ _trans('profile.Contract') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('attendance_profile'))
                                    <li class="nav-item dropdown">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['attendance'])) }}"
                                            href="{{ route('user.authProfile', ['attendance']) }}">
                                            {{ _trans('attendance.Attendance') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('notice_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['notice'])) }}"
                                            href="{{ route('user.authProfile', ['notice']) }}">
                                            {{ _trans('common.Notices') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('leave_request_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['leave_request'])) }}"
                                            href="{{ route('user.authProfile', ['leave_request']) }}">
                                            {{ _trans('common.Leaves') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('visit_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['visit'])) }}"
                                            href="{{ route('user.authProfile', ['visit']) }}">
                                            {{ _trans('common.Visit') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('phonebook_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['phonebook'])) }}"
                                            href="{{ route('user.authProfile', ['phonebook']) }}">
                                            {{ _trans('common.Phonebook') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('appointment_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['appointment'])) }}"
                                            href="{{ route('user.authProfile', ['appointment']) }}">
                                            {{ _trans('appointment.Appointment') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('support_ticket_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['ticket'])) }}"
                                            href="{{ route('user.authProfile', ['ticket']) }}">
                                            {{ _trans('common.Support') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('advance_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['advance'])) }}"
                                            href="{{ route('user.authProfile', ['advance']) }}">
                                            {{ _trans('payroll.Advance') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('commission_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['commission'])) }}"
                                            href="{{ route('user.authProfile', ['commission']) }}">
                                            {{ _trans('payroll.Commission') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('salary_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['salary'])) }}"
                                            href="{{ route('user.authProfile', ['salary']) }}">
                                            {{ _trans('payroll.Salary') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('project_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['project'])) }}"
                                            href="{{ route('user.authProfile', ['project']) }}">
                                            {{ _trans('project.Projects') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('task_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['task'])) }}"
                                            href="{{ route('user.authProfile', ['task']) }}">
                                            {{ _trans('project.Tasks') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('award_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['award'])) }}"
                                            href="{{ route('user.authProfile', ['award']) }}">
                                            {{ _trans('award.Awards') }}
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('travel_profile'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['travel'])) }}"
                                            href="{{ route('user.authProfile', ['travel']) }}">
                                            {{ _trans('travel.Travels') }}
                                        </a>
                                    </li>
                                @endif

                                {{-- new menus  --}}
                                <li class="nav-item">
                                    <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['request'])) }}"
                                        href="{{ route('user.authProfile', ['request']) }}">
                                        {{ _trans('travel.Request') }}
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- profile menu body end -->
                </div>
                <!-- profile menu end -->
            </div>
        </div>
    </div>
</div>

<!-- profile menu mobile end -->

<div class="new-profile-content">
    <div class="profile-menu">
        <div class="table-basic table-content ">
            <div class="card">
                <div class="card-body">
                    <div class="profile-menu-head">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 w-60 h-60">
                                <img class="img-fluid rounded-circle w-100 h-100"
                                    src="{{ @$data['show']->original['data']['avatar'] }}" width="60"
                                    alt="profile image" />
                            </div>
                            <div class="flex-grow-1">
                                <div class="body">
                                    <h2 class="title">{{ @$data['name'] }}</h2>
                                    <p class="paragraph">{{ @$data['name'] }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- profile menu body start -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-basic table-content">
                    <div class="card mb-3 bg-gray">
                        <div class="card-body p-2">
                            <nav>
                                <ul class="nav nav-pills">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link {{ menu_active_by_url(route('user.authProfile', ['personal'])) }}"
                                            href="{{ route('user.authProfile', ['personal']) }}">
                                            {{ _trans('common.Profile') }}
                                        </a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link {{ menu_active_by_url(route('user.authProfile', ['settings'])) }}"
                                            href="{{ route('user.authProfile', ['settings']) }}">
                                            {{ _trans('common.Settings') }}
                                        </a>
                                    </li>
                                    @if (!isMainCompany())
                                        @if (hasPermission('contract_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['contract'])) }}"
                                                    href="{{ route('user.authProfile', ['contract']) }}">
                                                    {{ _trans('profile.Contract') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('attendance_profile'))
                                            <li class="nav-item dropdown">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['attendance'])) }}"
                                                    href="{{ route('user.authProfile', ['attendance']) }}">
                                                    {{ _trans('attendance.Attendance') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('notice_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['notice'])) }}"
                                                    href="{{ route('user.authProfile', ['notice']) }}">
                                                    {{ _trans('common.Notices') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('leave_request_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['leave_request'])) }}"
                                                    href="{{ route('user.authProfile', ['leave_request']) }}">
                                                    {{ _trans('common.Leaves') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('visit_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['visit'])) }}"
                                                    href="{{ route('user.authProfile', ['visit']) }}">
                                                    {{ _trans('common.Visit') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('phonebook_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['phonebook'])) }}"
                                                    href="{{ route('user.authProfile', ['phonebook']) }}">
                                                    {{ _trans('common.Phonebook') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('appointment_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['appointment'])) }}"
                                                    href="{{ route('user.authProfile', ['appointment']) }}">
                                                    {{ _trans('appointment.Appointment') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('support_ticket_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['ticket'])) }}"
                                                    href="{{ route('user.authProfile', ['ticket']) }}">
                                                    {{ _trans('common.Support') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('advance_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['advance'])) }}"
                                                    href="{{ route('user.authProfile', ['advance']) }}">
                                                    {{ _trans('payroll.Advance') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('commission_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['commission'])) }}"
                                                    href="{{ route('user.authProfile', ['commission']) }}">
                                                    {{ _trans('payroll.Commission') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('salary_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['salary'])) }}"
                                                    href="{{ route('user.authProfile', ['salary']) }}">
                                                    {{ _trans('payroll.Salary') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('project_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['project'])) }}"
                                                    href="{{ route('user.authProfile', ['project']) }}">
                                                    {{ _trans('project.Projects') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('task_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['task'])) }}"
                                                    href="{{ route('user.authProfile', ['task']) }}">
                                                    {{ _trans('project.Tasks') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('award_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['award'])) }}"
                                                    href="{{ route('user.authProfile', ['award']) }}">
                                                    {{ _trans('award.Awards') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (hasPermission('travel_profile'))
                                            <li class="nav-item">
                                                <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['travel'])) }}"
                                                    href="{{ route('user.authProfile', ['travel']) }}">
                                                    {{ _trans('travel.Travels') }}
                                                </a>
                                            </li>
                                        @endif

                                        {{-- new menus  --}}
                                        <li class="nav-item">
                                            <a class="nav-link  {{ menu_active_by_url(route('user.authProfile', ['request'])) }}"
                                                href="{{ route('user.authProfile', ['request']) }}">
                                                {{ _trans('travel.Request') }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- profile menu body end -->
    </div>
</div>