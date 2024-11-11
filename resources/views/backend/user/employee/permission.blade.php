@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    <div class="card ot-card">
        <div class="card-body">
            <form method="POST"
                action="{{ route('user.permission_update', $data['show']->id) }}"enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-content table-basic">
                            <div class="table-responsive  min-height-500">
                                <table class="table role-create-table role-permission " id="permissions-table">
                                    <thead class="thead">
                                        <tr>
                                            <th class="border-bottom-0" class="" scope="col">
                                                {{ _trans('common.Module') }}/
                                                {{ _trans('common.Sub Module') }}</th>
                                            <th class="border-bottom-0 text-right" scope="col">
                                                {{ _trans('common.Permissions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        @foreach ($data['permissions'] as $permission)
                                            <tr class="bg-transparent border-bottom-0">
                                                <td colspan="5" class="p-0 border-bottom-0">
                                                    <div class="accordion accordion-role mb-3">
                                                        <div class="accordion-item" id="accordion-{{ $permission->id }}">
                                                            <h2 class="accordion-header">
                                                                @php
                                                                    $count = 0;
                                                                    $permissionKeywords = json_decode($permission->keywords, true);

                                                                    foreach ($permissionKeywords ?? [] as $key => $keyword) {
                                                                        if (in_array($keyword, is_array(@$data['show']->permissions) ? @$data['show']->permissions : json_decode(@$data['show']->permissions) ?? [])) {
                                                                            $count++;
                                                                        } 
                                                                    }   
                                                                @endphp
                                                                <button 
                                                                        class="accordion-button {{ $count ? '' : 'collapsed' }}"
                                                                        type="button" 
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#toggle-{{ $permission->id }}"
                                                                        aria-expanded="{{ $count ? 'true' : 'false' }}"
                                                                        aria-controls="toggle-{{ $permission->id }}"
                                                                    >
                                                                    <div class="input-check-radio">
                                                                        <div class="form-check">
                                                                            <input 
                                                                                type="checkbox"
                                                                                class="form-check-input permission-group"
                                                                                id="permission-{{ $permission->id }}"
                                                                                {{ $count ? 'checked' : '' }}
                                                                                onclick="toggleSinglePermissions(this)"
                                                                            >
                                                                            <label 
                                                                                class="form-check-label ml-6"
                                                                                for="permission-{{ $permission->id }}"
                                                                                onclick="toggleSinglePermissions(this)"
                                                                            >
                                                                                {{ Str::title(Str::replace('_', ' ', $permission->attribute)) }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div 
                                                                id="toggle-{{ $permission->id }}"
                                                                class="accordion-collapse collapse {{ $count ? 'show' : '' }}"
                                                            >
                                                                <div class="accordion-body d-flex flex-wrap">
                                                                    @foreach ($permissionKeywords ?? [] as $key => $keyword)
                                                                        <div class="input-check-radio mr-16">
                                                                            <div class="form-check">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input single-permission"
                                                                                    name="permissions[]"
                                                                                    value="{{ $keyword }}"
                                                                                    id="{{ $keyword }}"
                                                                                    {{ in_array($keyword, is_array(@$data['show']->permissions) ? @$data['show']->permissions : json_decode(@$data['show']->permissions) ?? []) ? 'checked' : '' }}
                                                                                    onclick="togglePermissionGroup(this)"
                                                                                >
                                                                                <label
                                                                                    class="form-check-label ml-6"
                                                                                    for="{{ $keyword }}"
                                                                                    onclick="togglePermissionGroup(this)"
                                                                                >
                                                                                    {{ Str::title(Str::replace('_', ' ', $key)) }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="col-md-12 text-right mt-3 mb-3 mr-5">
                        <div class="form-group d-flex justify-content-end">
                            @if (hasPermission('user_create'))
                                <button type="submit" class="btn btn-gradian">{{ _trans('common.Update') }}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ url('backend/js/pages/__profile.js') }}"></script>
    <script>
        const toggleSinglePermissions = (obj) => {
            let isChecked = $(obj).closest('.accordion-item').find('.permission-group').is(':checked');
            $(obj).closest('.accordion-item').find('.single-permission').prop('checked', isChecked);
        }

        const togglePermissionGroup = (obj) => {

            let count = 0;

            $(obj).closest('.accordion-item').find('.single-permission').each(function () {
                if ($(this).is(':checked')) {
                    count++;
                }
            })

            if (count > 0) {
                $(obj).closest('.accordion-item').find('.permission-group').prop('checked', true);
            } else {
                $(obj).closest('.accordion-item').find('.permission-group').prop('checked', false);
            }
        }
    </script>
@endsection
