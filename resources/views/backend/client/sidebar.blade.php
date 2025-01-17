     {{-- project management start --}}
     @if (hasPermission('client_menu') && hasFeature('clients'))
     <li class="sidebar-menu-item {{ set_menu([route('project.index')]) }}">
         <a href="javascript:void(0)" class="parent-item-content has-arrow {{ menu_active_by_route(['client.index','client.create','client.edit']) }}">
            <i class="las la-user-friends"></i>
             <span class="on-half-expanded">
                 {{ _trans('client.Clients') }}
             </span>
         </a>
         <ul class="child-menu-list {{ set_active(['admin/client*']) }}">

            @if (hasPermission('client_list'))
                 <li class="sidebar-menu-item {{ menu_active_by_route(['client.index','client.create','client.edit']) }}">
                     <a href="{{ route('client.index') }}" >
                         <span> {{ _trans('common.Client Lists') }}</span>
                     </a>
                 </li>
             @endif


         </ul>
     </li>
 @endif