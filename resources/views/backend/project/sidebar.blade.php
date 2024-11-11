@if (hasPermission('project_menu') && hasFeature('projects'))
    <li class="sidebar-menu-item {{ set_menu([route('project.index')]) }}">
        <a href="javascript:void(0)" class="parent-item-content has-arrow  {{ menu_active_by_route(['project.create','project.index','project.view','project.edit']) }}">
            <i class="lab la-product-hunt"></i>
            <span class="on-half-expanded">
                {{ _trans('project.Projects') }}
            </span>
        </a>
        <ul class="child-menu-list {{ set_active(['admin/project*']) }}">

            @if (hasPermission('project_create'))
                <li class="sidebar-menu-item {{ menu_active_by_route(['project.create']) }}">
                    <a href="{{ route('project.create') }}">
                        <span> {{ _trans('project.Project Create') }}</span>
                    </a>
                </li>
            @endif

            @if (hasPermission('project_list'))
                <li class="sidebar-menu-item {{ menu_active_by_route(['project.index','project.view','project.edit']) }}">
                    <a href="{{ route('project.index') }}">
                        <span> {{ _trans('project.Project List') }}</span>
                    </a>
                </li>
            @endif



        </ul>
    </li>
@endif
