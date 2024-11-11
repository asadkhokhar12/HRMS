
@if((hasPermission('general_settings_read') ) && hasFeature('settings'))
    <li class="sidebar-menu-item">
        <a href="javascript:void(0)"
           class="parent-item-content has-arrow {{ menu_active_by_route(['manage.settings.view', 'appScreenSetup', 'ipConfig.create', 'language.index', 'language.setup', 'content.list']) }}">
            <i class="las la-cog"></i>
            <span class="on-half-expanded">
                {{ _trans('common.Settings') }}
            </span>
        </a>
        <ul
                class="child-menu-list  {{ set_active(['admin/settings*', 'admin/settings/list', 'admin/settings/leave*', 'admin/settings/ip-configuration*', 'company/settings', 'admin/settings/app-setting/dashboard', 'admin/settings/language-setup', 'admin/content/list*', 'admin/saas/email-template*']) }}">
            @if(hasPermission('general_settings_read'))
                <li class="nav-item {{ menu_active_by_route('manage.settings.view') }}">
                    <a href="{{ route('manage.settings.view') }}"
                       class=" {{ set_active('admin/settings/list') }}">
                        <span>{{ _trans('common.General Settings') }}</span>
                    </a>
                </li>
            @endif
            {{-- get config file value --}}

            <li class="nav-item {{ menu_active_by_route('appScreenSetup') }}">
                <a href="{{ route('appScreenSetup') }}"
                   class=" {{ set_active('admin/settings/contact/*') }}">
                    <span>{{ _trans('common.App Setting') }}</span>
                </a>
            </li>
{{--            <li class="nav-item {{ menu_active_by_route('manage.settings.add_currency') }}">--}}
{{--                <a href="{{ route('manage.settings.add_currency') }}"--}}
{{--                   class="  ">--}}
{{--                    <span>{{ _trans('common.Add Currency') }}</span>--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="nav-item {{ menu_active_by_route('manage.settings.currency_list') }}">
                <a href="{{ route('manage.settings.currency_list') }}"
                   class="  ">
                    <span>{{ _trans('common.Currency') }}</span>
                </a>
            </li>
            @if(hasPermission('content_menu') && isMainCompany())
                <li class="nav-item {{ menu_active_by_route(['content.list']) }}">
                    <a href="{{ route('content.list') }}"
                       class="nav-link {{ set_active('admin/settings/app-setting/dashboard/*') }}">
                        <span>{{ _trans('common.Contents') }}</span>
                    </a>
                </li>
            @endif
            @if(hasPermission('language_menu'))
                <li
                        class="nav-item {{ menu_active_by_route(['language.index', 'language.setup']) }}">
                    <a href="{{ route('language.index') }}"
                       class=" {{ set_active('admin/settings/language/*') }}">
                        <span>{{ _trans('settings.Language') }}</span>
                    </a>
                </li>
            @endif
            @if (isMainCompany())
                <li class="nav-item {{ menu_active_by_route('saas.email-template.index') }}">
                    <a href="{{ route('saas.email-template.index') }}"
                       class=" {{ set_active('admin/saas/email-template*') }}">
                        <span>{{ _trans('common.Email Template') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif