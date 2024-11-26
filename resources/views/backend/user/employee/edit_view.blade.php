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
            <form method="POST" action="{{ route('user.update', $data['show']->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Name') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control ot-form-control ot-input"
                                    placeholder="{{ _trans('common.Name') }}" value="{{ old('name', $data['show']->name) }}"
                                    required>
                                @if ($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="employee_id" class="form-label">{{ _trans('common.Employee ID') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="employee_id" class="form-control ot-form-control ot-input"
                                    placeholder="{{ _trans('common.Employee ID') }}"
                                    value="{{ old('employee_id', $data['show']->employee_id) }}" required>
                                @if ($errors->has('employee_id'))
                                    <div class="error">{{ $errors->first('employee_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-20">
                                <label class="mb-10">{{ _trans('profile.Avatar') }}</label>
                                <div class="ot_fileUploader left-side mb-20">
                                    <input class="form-control" type="text" placeholder="{{ _trans('profile.Avatar') }}"
                                        name="backend_image" readonly="" id="placeholder3">
                                    <div class="primary-btn-small-input">
                                        <label class="btn btn-lg ot-btn-primary"
                                            for="fileBrouse3">{{ _trans('common.Browse') }}</label>
                                        <input type="file" class="d-none form-control" name="avatar" id="fileBrouse3">
                                    </div>
                                </div>

                                @if ($errors->has('avatar'))
                                    <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Email') }} <span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" placeholder="{{ _trans('common.Email') }}"
                                    autocomplete="off" class="form-control ot-form-control ot-input"
                                    value="{{ old('email', $data['show']->email) }}" required>
                                @if ($errors->has('email'))
                                    <div class="error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Phone') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="phone" placeholder="{{ _trans('common.Phone') }}"
                                    autocomplete="off" class="form-control ot-form-control ot-input"
                                    value="{{ old('phone', $data['show']->phone) }}" required>
                                @if ($errors->has('phone'))
                                    <div class="error">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label"> {{ _trans('common.Country') }} <span
                                        class="text-danger">*</span>
                                </label>

                                <select name="country" class="form-control ot-form-control ot-input select2"
                                    id="_country_id" required>
                                    @foreach ($data['countries'] as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country', $data['show']->country_id) == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
                                    <div class="error">{{ $errors->first('country') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="joining_date" class="form-label">{{ _trans('common.Joining Date') }} <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="joining_date" autocomplete="off"
                                    class="form-control ot-form-control ot-input"
                                    value="{{ old('joining_date', $data['show']->joining_date) }}" required>
                                @if ($errors->has('joining_date'))
                                    <div class="error">{{ $errors->first('joining_date') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">{{ _trans('common.Date Of Birth') }}</label>
                                <input type="date" name="birth_date" autocomplete="off"
                                    class="form-control ot-form-control ot-input"
                                    value="{{ old('birth_date', $data['show']->birth_date) }}">
                                @if ($errors->has('birth_date'))
                                    <div class="error">{{ $errors->first('birth_date') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="blood_group">{{ _trans('common.Blood Group') }}</label>
                                <select name="blood_group" class="form-select select2">
                                    <option disabled selected>{{ _trans('common.Choose One') }}
                                    </option>
                                    <option value="A+"
                                        {{ old('blood_group', $data['show']->blood_group) == 'A+' ? 'selected' : '' }}>
                                        {{ _trans('common.A+') }}
                                    </option>
                                    <option value="A-"
                                        {{ old('blood_group', $data['show']->blood_group) == 'A-' ? 'selected' : '' }}>
                                        {{ _trans('common.A-') }}
                                    </option>
                                    <option value="B+"
                                        {{ old('blood_group', $data['show']->blood_group) == 'B+' ? 'selected' : '' }}>
                                        {{ _trans('common.B+') }}
                                    </option>
                                    <option value="B-"
                                        {{ old('blood_group', $data['show']->blood_group) == 'B-' ? 'selected' : '' }}>
                                        {{ _trans('common.B-') }}
                                    </option>
                                    <option value="O+"
                                        {{ old('blood_group', $data['show']->blood_group) == 'O+' ? 'selected' : '' }}>
                                        {{ _trans('common.O+') }}
                                    </option>
                                    <option value="O-"
                                        {{ old('blood_group', $data['show']->blood_group) == 'O-' ? 'selected' : '' }}>
                                        {{ _trans('common.O-') }}
                                    </option>
                                    <option value="AB+"
                                        {{ old('blood_group', $data['show']->blood_group) == 'AB+' ? 'selected' : '' }}>
                                        {{ _trans('common.AB+') }}
                                    </option>
                                    <option value="AB-"
                                        {{ old('blood_group', $data['show']->blood_group) == 'AB-' ? 'selected' : '' }}>
                                        {{ _trans('common.AB-') }}
                                    </option>
                                </select>
                                @if ($errors->has('blood_group'))
                                    <div class="error">{{ $errors->first('blood_group') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Gross Salary') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="basic_salary"
                                    placeholder="{{ _trans('common.Gross Salary') }}" autocomplete="off"
                                    class="form-control ot-form-control ot-input" step=0.01
                                    value="{{ old('basic_salary', $data['show']->basic_salary) }}" required>
                                @if ($errors->has('basic_salary'))
                                    <div class="error">{{ $errors->first('basic_salary') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('settings.TimeZone') }}</label>
                                <select id="time_zone" name="time_zone"
                                    class="custom-select form-select ot-form-control select2">
                                    @foreach ($data['timezones'] as $key => $timezone)
                                        <option value="{{ $timezone->time_zone }}"
                                            {{ old('time_zone', @$data['show']->time_zone) == $timezone->time_zone ? 'selected' : '' }}>
                                            {{ $timezone->time_zone }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('timezone'))
                                    <div class="error">{{ $errors->first('timezone') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">

                            <div class="form-group mt-20">
                                <label class="mb-10">{{ _trans('common.Tax') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control ot-form-control ot-input" name="tax"
                                    placeholder="{{ _trans('common.Enter Tax') }}"
                                    value="{{ @$data['show']->tax ?? 'N/A' }}">
                                @if ($errors->has('tax'))
                                    <span class="text-danger">{{ $errors->first('tax') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="password"
                                    class="form-label">{{ _trans('common.Password') }} <span class="text-danger">*</span>
                                </label> <br>
                                <input type="radio" name="password_type" value="keep_old" id="" checked>
                                <span class="mr-4">{{ _trans('common.Keep Old Password') }}</span>
                                <input type="radio" name="password_type" value="default" id=""> <span
                                    class="mr-4">{{ _trans('common.Default Password') }} (12345678)</span>
                                <input type="radio" name="password_type" value="custom" id="">
                                <span>{{ _trans('common.Custom Password') }}</span>
                            </div>
                        </div>

                        <div id="editSelectionDiv" class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="password"
                                    class="form-label">{{ _trans('common.Password') }} <span class="text-danger">*</span>
                                    <span data-toggle="tooltip" data-placement="top"
                                        title="Leave the field blank to not change the password."><i
                                            class="fa-solid fa-circle-info"></i></span></label>
                                <input type="text" name="password" placeholder="{{ _trans('common.Password') }}"
                                    autocomplete="off" class="form-control ot-form-control ot-input"
                                    value="{{ old('password') }}" id="password">

                                @if ($errors->has('password'))
                                    <div class="error text-danger">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Role') }} <span
                                        class="text-danger">*</span></label>[<a href="javascript:;" role="button"
                                    onclick="mainModalOpen(`{{ route('role.create_modal') }}`)"> <span><i
                                            class="fa-solid fa-plus"></i> </span>
                                    <span class="d-none d-xl-inline"> <strong> {{ _trans('common.Add Role') }}
                                        </strong> </span> </a>]
                                <select name="role_id" class="form-select select2 change-role" required>
                                    <option value="" disabled selected>
                                        {{ _trans('common.Choose One') }}</option>
                                    @foreach ($data['roles'] as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id', $data['show']->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="shift_id" class="form-label">{{ _trans('common.Shift') }} <span
                                        class="text-danger">*</span></label>

                                <select name="shift_id[]" class="form-select select2"
                                    {{ isModuleActive('MultiShift') ? 'multiple' : '' }} required>
                                    <option value="" disabled>{{ _trans('common.Choose One') }}</option>
                                    @foreach ($data['shifts'] as $shift)
                                        <option
                                            @foreach ($data['show']->shifts as $userShift)
                                                        {{ $userShift->shift_id == $shift->id ? 'selected' : '' }} @endforeach
                                            value="{{ $shift->id }}">{{ $shift->name }}</option>
                                    @endforeach
                                    {{-- @foreach ($data['shifts'] as $shift)
                                                @php
                                                    $isSelected = $data['show']->shifts->contains($shift->id) ? 'selected' : '';
                                                @endphp
                                               
                                                <option value="{{ $shift->id }}" {{ $isSelected }}>{{ $shift->name }}</option>
                                            @endforeach --}}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Department') }} <span
                                        class="text-danger">*</span></label>
                                @if (hasPermission('department_create'))
                                    [<a href="javascript:;" role="button" class="btn-add" data-bs-toggle="tooltip"
                                        onclick="mainModalOpen(`{{ route('department.create_modal') }}`)"
                                        data-bs-placement="right" data-bs-title="{{ _trans('common.Add') }}">
                                        <span><i class="fa-solid fa-plus"></i> </span>
                                        <span class="d-none d-xl-inline"> <strong> {{ _trans('common.Department') }}
                                            </strong> </span>
                                    </a>]
                                @endif
                                <select name="department_id" class="form-select select2" required>
                                    <option value="" disabled>{{ _trans('common.Choose One') }}
                                    </option>
                                    @foreach ($data['departments'] as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_id', $data['show']->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="designation_id" class="form-label">{{ _trans('common.Designation') }} <span
                                        class="text-danger">*</span></label>
                                @if (hasPermission('designation_create'))
                                    [<a href="javascript:;" role="button" class="btn-add" data-bs-toggle="tooltip"
                                        onclick="mainModalOpen(`{{ route('designation.create_modal') }}`)"
                                        data-bs-placement="right" data-bs-title="{{ _trans('common.Add') }}">
                                        <span><i class="fa-solid fa-plus"></i> </span>
                                        <span class="d-none d-xl-inline"> <strong> {{ _trans('common.Designation') }}
                                            </strong> </span>
                                    </a>]
                                @endif
                                <select name="designation_id" class="form-select select2" required>
                                    <option value="" disabled>{{ _trans('common.Choose One') }}
                                    </option>
                                    @foreach ($data['designations'] as $designation)
                                        <option value="{{ $designation->id }}"
                                            {{ old('designation_id', $data['show']->designation_id) == $designation->id ? 'selected' : '' }}>
                                            {{ $designation->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="manager_id" class="form-label">{{ _trans('user.Manager') }}</label>
                                <select name="manager_id" class="form-select select2" required>
                                    <option value="" disabled>{{ _trans('common.Choose One') }}
                                    </option>
                                    @foreach ($data['managers'] as $manager)
                                        <option value="{{ $manager->id }}"
                                            {{ old('manager_id', $data['show']->manager_id) === $manager->id ? 'selected' : '' }}>
                                            {{ $manager->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('manager_id'))
                                    <small class="error">{{ $errors->first('manager_id') }}</small>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Gender') }} <span
                                        class="text-danger">*</span></label>
                                <select name="gender" required
                                    class="form-select select2 demo-select2-placeholder {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                                    <option disabled selected>{{ _trans('common.Choose One') }}
                                    </option>
                                    <option value="Male"
                                        {{ old('gender', $data['show']->gender) == 'Male' ? 'selected' : '' }}>
                                        {{ _trans('common.Male') }}</option>
                                    <option value="Female"
                                        {{ old('gender', $data['show']->gender) == 'Female' ? 'selected' : '' }}>
                                        {{ _trans('common.Female') }}</option>
                                    <option value="Unisex"
                                        {{ old('gender', $data['show']->gender) == 'Unisex' ? 'selected' : '' }}>
                                        {{ _trans('common.Unisex') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">{{ _trans('common.Address') }}</label>
                                <input type="text" name="address" placeholder={{ _trans('common.Address') }}
                                    autocomplete="off" class="form-control ot-form-control ot-input"
                                    value="{{ old('address', $data['show']->address) }}">
                                @if ($errors->has('address'))
                                    <div class="error">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">{{ _trans('common.Religion') }}</label>

                                <select name="religion" id="religion" class="form-select select2">
                                    <option value="Islam"
                                        {{ old('religion', $data['show']->religion) == 'Islam' ? 'selected' : '' }}>
                                        {{ _trans('common.Islam') }}
                                    </option>
                                    <option value="Hindu"
                                        {{ old('religion', $data['show']->religion) == 'Hindu' ? 'selected' : '' }}>
                                        {{ _trans('common.Hindu') }}
                                    </option>
                                    <option value="Christan"
                                        {{ old('religion', $data['show']->religion) == 'Christan' ? 'selected' : '' }}>
                                        {{ _trans('common.Christan') }}
                                    </option>
                                </select>
                                @if ($errors->has('religion'))
                                    <div class="error">{{ $errors->first('religion') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label"
                                    for="marital_status">{{ _trans('common.Marital Status') }}</label>
                                <select name="marital_status" id="marital_status" class="form-select select2">
                                    <option disabled selected>{{ _trans('common.Choose One') }}
                                    </option>
                                    <option value="Married"
                                        {{ old('marital_status', $data['show']->marital_status) == 'Married' ? 'selected' : '' }}>
                                        {{ _trans('common.Married') }}</option>
                                    <option value="Unmarried"
                                        {{ old('marital_status', $data['show']->marital_status) == 'Unmarried' ? 'selected' : '' }}>
                                        {{ _trans('common.Unmarried') }}</option>
                                </select>
                                @if ($errors->has('marital_status'))
                                    <div class="error">{{ $errors->first('marital_status') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Is free Location?') }} <span
                                        class="text-danger">*</span></label>
                                <select name="is_free_location" id="is_free_location"
                                    class="form-select ot-input select2" required>
                                    <option value="" disabled>{{ _trans('common.Choose One') }}
                                    </option>
                                    <option value="1"
                                        {{ old('is_free_location', $data['show']->is_free_location) == 1 ? 'selected' : '' }}>
                                        {{ _trans('common.Yes') }}</option>
                                    <option value="0"
                                        {{ old('is_free_location', $data['show']->is_free_location) == 0 ? 'selected' : '' }}>
                                        {{ _trans('common.No') }}</option>
                                </select>
                                @if ($errors->has('is_free_location'))
                                    <div class="error">{{ $errors->first('is_free_location') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">{{ _trans('common.Attendance Method') }}</label>
                                <select name="attendance_method[]" class="form-control " id="attendance_method" multiple>
                                    @if (@$data['show'] && @$data['show']->attendance_method)
                                        @foreach ($data['show']->attendance_method as $key => $method)
                                            <option value="{{ $key }}" {{ $method === 1 ? 'selected' : '' }}>
                                                {{ ucwords(str_replace('_', ' ', $key)) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('attendance_method'))
                                    <div class="error">{{ $errors->first('attendance_method') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Status') }} <span
                                        class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select ot-input select2" required>
                                    @foreach ($data['statuses'] as $key => $status)
                                        <option value="{{ $status->id }}"
                                            {{ old('status', @$data['show']->status_id) == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('status'))
                                    <div class="error">{{ $errors->first('status') }}</div>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-lg-12">
                    <div class="col-md-12 text-right mt-3 mb-3 mr-5">
                        <div class="form-group d-flex justify-content-end">
                            @if (hasPermission('user_update'))
                                <button type="submit" class="btn btn-gradian">{{ _trans('common.Update') }}</button>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
    <input type="hidden" id="get_attendance_method_data" value="{{ route('user.getAttendanceMethod') }}">
@endsection
@section('script')
    <script src="{{ url('backend/js/pages/__profile.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initially hide the role selection div
            $('#editSelectionDiv').hide();

            // Attach an event listener to the radio buttons
            $('input[name="password_type"]').on('change', function() {
                if ($(this).val() === 'custom') {
                    // If the 'custom' radio button is selected, show the edit selection div
                    $('#editSelectionDiv').show();
                } else {
                    // If the 'default' radio button is selected or other value, hide the edit selection div
                    $('#editSelectionDiv').hide();
                }
            });
        });
    </script>
@endsection
