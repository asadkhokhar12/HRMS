@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('content')

    <div class="d-flex justify-content-between flex-wrap dashboard-heading  align-items-center pb-24 gap-3">
        <h3 class="mb-0">{{ _trans('common.Welcome to') }} {{ config('settings.app.company_name') }}
            [{{ Auth::user()->name }}]</h3>
        {{-- dropdown menu --}}
        <div class="dropdown card-button">
            <button class="btn btn-secondary ot-dropdown-btn dropdown-toggle" type="button" id="revenueBtn"
                data-bs-toggle="dropdown" aria-expanded="false">
                <span id="__selected_dashboard">
                    @php
                        $auth_role = !auth()->user()->role ? 'staff' : auth()->user()->role->slug;
                    @endphp
                    @if ($auth_role == 'admin')
                        {{ _trans('common.Company Dashboard') }}
                    @else
                        {{ _trans('common.My Dashboard') }}
                    @endif
                </span>
                <i class="las la-angle-down"></i>
            </button>
            <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
                <li>
                    <a class="dropdown-item profile_option" onclick="dashboardAdmin('My Dashboard')"
                        href="javascript:void(0)">{{ _trans('common.My Dashboard') }}</a>
                </li>

            </ul>
        </div>
    </div>
    <div class="content p-0 mt-4">
        <div class="__MyProfileDashboardView" id="__MyProfileDashboardView"></div>
    </div>
    <input type="hidden" id="user_slug" value="{{ $auth_role }}">
    <input type="hidden" id="profileWiseDashboard" value="{{ route('dashboard.profileWiseDashboard') }}">
@endsection
@section('script')
    <script src="{{ global_asset('backend/js/fs_d_ecma/chart/echarts.min.js') }}"></script>
    <script type="module" src="{{ global_asset('backend/js/fs_d_ecma/components/dashboard.js') }}"></script>
@endsection
