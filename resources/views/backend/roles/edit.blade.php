@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    <div class="table-content table-basic">
        
        @if ($errors->any())
            @if ($errors->has('permissions'))
                <div class="alert alert-danger">
                    {{ _trans('common.At least one permission is required') }}
                </div>
            @endif
        @endif
        <div class="card">
            <div class="card-body">
                <form action="{{ route('roles.update', $data['role']->id) }}" class="form-validate" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                @if (hasPermission('role_read'))
                                    <a href="{{ route('roles.index') }}" class="btn btn-gradian"> <i
                                            class="fa fa-arrow-left"></i> {{ _trans('common.Back') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12 mt-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fv-full-name">{{ _trans('common.Name') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control ot-form-control ot-input"
                                            id="fv-full-name" name="name" required
                                            placeholder="{{ _trans('common.Name') }}" value="{{ $data['role']->name }}">
                                    </div>
                                    @if ($errors->has('name'))
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="fv-email">{{ _trans('common.Status') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select name="status_id" id="status_id" class="form-select ot-input" required>
                                            <option value="" disabled>{{ _trans('common.Choose One') }}
                                            </option>
                                            <option value="1" {{ $data['role']->status_id == 1 ? 'selected' : '' }}>
                                                {{ _trans('common.Active') }}</option>
                                            <option value="4" {{ $data['role']->status_id == 4 ? 'selected' : '' }}>
                                                {{ _trans('common.In-active') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @php
                                $upper_roles = json_decode($data['role']->upper_roles) ?? [];
                            @endphp
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label" for="fv-email">
                                        {{ _trans('common.Upper Roles') }} 
                                        @if ($data['role']->id > 4)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <div class="form-control-wrap">
                                        <select 
                                            name="upper_roles[]" 
                                            multiple 
                                            id="upper_roles"
                                            class="form-select select2-input ot-input mb-3 modal_select2" 
                                            @if ($data['role']->id > 4)
                                                required
                                            @endif
                                        >
                                            <option value="" disabled>{{ _trans('common.Choose One') }}</option>
                                            @foreach ($data['roles']->where('id', '!=', $data['role']->id) as $role)
                                                <option 
                                                    value="{{ @$role->id }}"
                                                    {{ in_array($role->id, $upper_roles) ? 'selected' : '' }}
                                                >
                                                    {{ @$role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="role-permisssion-control">
                                <div class="table-content table-basic">
                                    <div class="table-responsive  min-height-500">
                                        <table class="table role-create-table role-permission ">
                                            <thead class="thead">
                                                <tr>
                                                    <th class="" scope="col">
                                                        {{ _trans('common.Module') }}/
                                                        {{ _trans('common.Sub Module') }}</th>
                                                    <th scope="col">{{ _trans('common.Permissions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody">
                                                <tr>
                                                    <td>{{ _trans('common.Check all') }}</td>
                                                    <td>
                                                        <div class="input-check-radio">
                                                            <div class="form-check">
                                                                <input 
                                                                    type="checkbox"
                                                                    class="form-check-input read"
                                                                    id="checkAll"
                                                                    onclick="toggleAllPermission()"
                                                                >
                                                                <label 
                                                                    class="form-check-label ml-6"
                                                                    for="checkAll"
                                                                    onclick="toggleAllPermission()"
                                                                >
                                                                    {{ _trans('common.Check all') }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @foreach ($data['permissions'] as $permission)
                                                    <tr class="bg-transparent border-bottom-0">
                                                        <td colspan="5" class="p-0 border-bottom-0">
                                                            <div class="accordion accordion-role mb-3">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header">
                                                                        @php
                                                                            $count = 0;

                                                                            foreach (json_decode(@$permission->keywords) ?? [] as $key => $keyword) {
                                                                                if (in_array($keyword, is_array(@$data['role']->permissions) ? @$data['role']->permissions : json_decode(@$data['role']->permissions) ?? [])) {
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
                                                                            <div class="input-check-radio mr-16">
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
                                                                            @foreach (json_decode(@$permission->keywords) ?? [] as $key => $keyword)
                                                                                <div class="input-check-radio mr-16">
                                                                                    <div class="form-check">
                                                                                        @if ($keyword != '' && $data['role']->permissions)
                                                                                            <input type="checkbox"
                                                                                                class="form-check-input single-permission"
                                                                                                name="permissions[]"
                                                                                                value="{{ $keyword }}"
                                                                                                id="{{ $keyword }}"
                                                                                                {{ in_array($keyword, is_array(@$data['role']->permissions) ? @$data['role']->permissions : json_decode(@$data['role']->permissions) ?? []) ? 'checked' : '' }}
                                                                                                onclick="togglePermissionGroup(this)"
                                                                                            >
                                                                                            <label
                                                                                                class="form-check-label ml-6"
                                                                                                for="{{ $keyword }}"
                                                                                                onclick="togglePermissionGroup(this)"
                                                                                            >
                                                                                                {{ Str::title(Str::replace('_', ' ', $key)) }}
                                                                                            </label>
                                                                                        @else
                                                                                            <input 
                                                                                                type="checkbox"
                                                                                                class="form-check-input read single-permission"
                                                                                                name="permissions[]"
                                                                                                value="{{ $keyword }}"
                                                                                                id="{{ $keyword }}"
                                                                                                onclick="togglePermissionGroup(this)"
                                                                                            >
                                                                                            <label
                                                                                                class="form-check-label ml-2"
                                                                                                for="{{ $keyword }}"
                                                                                                onclick="togglePermissionGroup(this)"
                                                                                            >
                                                                                                {{ Str::title(Str::replace('_', ' ', $key)) }}
                                                                                            </label>
                                                                                        @endif
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
                        <div class="col-md-12 text-right mt-3 mb-3">
                            <div class="d-flex justify-content-end">
                                @if (hasPermission('role_update'))
                                    <button type="submit" class="btn btn-gradian">{{ _trans('common.Update') }}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ global_asset('backend/js/_roles.js') }}"></script>
@endsection
