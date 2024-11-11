<div class="profile-body p-40 pl-40 pr-40 pt-10">
    <!-- profile body nav start -->
    <div class="profile-body-form">
        @if (hasPermission('user_update'))
            <form method="POST" action="{{ route('user.update.profile', [$data['id'], $data['slug']]) }}"
                enctype="multipart/form-data">
                @csrf
                <input type="text" hidden name="user_id" value="{{ $data['id'] }}">
        @endif
        <div class="form-group mt-20">
            <label class="mb-10">{{ _trans('common.Phone') }} <span class="text-danger">*</span></label>
            <input type="number" class="form-control ot-form-control ot-input" name="phone"
                placeholder="{{ _trans('common.Enter Phone') }}"
                value="{{ old('phone', @$data['show']->original['data']['phone']) }}"
            >
            @if ($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>
        <div class="form-group mt-20">
            <label class="mb-10">{{ _trans('profile.Date of Birth') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control ot-form-control ot-input s_date" name="birth_date"
                placeholder="{{ _trans('profile.Date of Birth') }}"
                value="{{ old('birth_date', date('m/d/y', strtotime(@$data['show']->original['data']['birth_date_db']))) }}">
            @if ($errors->has('birth_date'))
                <span class="text-danger">{{ $errors->first('birth_date') }}</span>
            @endif
        </div>
        <div class="form-group mt-20">
            <label class="mb-10">{{ _trans('common.Gender') }} <span class="text-danger">*</span></label>
            <select name="gender" required
                class="form-select select2 demo-select2-placeholder {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                <option disabled selected>{{ _trans('common.Choose One') }}
                </option>
                @foreach (config('hrm.gender') as $gender)
                    <option value="{{ $gender }}"
                        {{ old('gender', $gender) == @$data['show']->original['data']['gender'] ? 'selected' : '' }}>
                        {{ $gender }}</option>
                @endforeach
            </select>
            @if ($errors->has('gender'))
                <span class="text-danger">{{ $errors->first('gender') }}</span>
            @endif
        </div>
        <div class="form-group mt-20">
            <label class="mb-10">{{ _trans('common.Address') }}</label>
            <input type="text" class="form-control ot-form-control ot-input"
                placeholder="{{ _trans('common.Enter Address') }}" name="address"
                value="{{ old('address', @$data['show']->original['data']['address'] ?? 'N/A') }}">
            @if ($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
            @endif
        </div>

        <div class="form-group mt-20">
            <label class="mb-10">{{ _trans('profile.Nationality') }}</label>
            <input type="text" class="form-control ot-form-control ot-input"
                placeholder="{{ _trans('profile.Enter Nationality') }}" name="nationality"
                value="{{ old('nationality', @$data['show']->original['data']['nationality']) }}">
            @if ($errors->has('nationality'))
                <span class="text-danger">{{ $errors->first('nationality') }}</span>
            @endif
        </div>

        <div class="form-group mt-20">
            <label class="mb-10">{{ _trans('common.Blood Group') }} <span class="text-danger">*</span></label>

            <select name="blood_group" required
                class="form-select select2 demo-select2-placeholder {{ $errors->has('blood_group') ? 'is-invalid' : '' }}">
                <option disabled selected>{{ _trans('common.Choose One') }}
                </option>
                @foreach (config('hrm.blood_group') as $blood)
                    <option value="{{ $blood }}"
                        {{ old('blood_group', $blood) == @$data['show']->original['data']['blood_group'] ? 'selected' : '' }}>
                        {{ $blood }}</option>
                @endforeach
            </select>
            @if ($errors->has('blood_group'))
                <span class="text-danger">{{ $errors->first('blood_group') }}</span>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Avatar') }}</label>
                    <div class="ot_fileUploader left-side mb-3">
                        <input class="form-control" type="text" placeholder="{{ _trans('profile.Avatar') }}"
                            name="backend_image" readonly="" id="placeholder3">
                        <button class="primary-btn-small-input" type="button">
                            <label class="btn btn-lg ot-btn-primary m-0"
                                for="fileBrouse3">{{ _trans('common.Browse') }}</label>
                            <input type="file" class="d-none form-control" name="avatar" id="fileBrouse3">
                        </button>
                    </div>
        
                    @if ($errors->has('avatar'))
                        <span class="text-danger">{{ $errors->first('avatar') }}</span>
                    @endif
                </div>
        
            </div>
            <div class="col-lg-6">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Speak Language') }}</label>
                     <input type="text" name="speak_language" value="{{ @$data['show']->original['data']['speak_language']??old('speak_language') }}" class="form-control ot-form-control ot-input">
        
                    @if ($errors->has('avatar'))
                        <span class="text-danger">{{ $errors->first('avatar') }}</span>
                    @endif
                </div>
        
            </div>
            <div class="col-lg-6">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Employee ID') }}</label>
                     <input type="text" name="employee_id" value="{{ old('employee_id', @$data['show']->original['data']['employee_id']) }}" class="form-control ot-form-control ot-input">
        
                    @if ($errors->has('employee_id'))
                        <span class="text-danger">{{ $errors->first('employee_id') }}</span>
                    @endif
                </div>
        
            </div>
        </div>


        <div class="form-group mt-20 d-none">
            <label class="mb-10">{{ _trans('profile.TIN') }}
            </label>
            <input type="text" class="form-control ot-form-control ot-input"
                placeholder="{{ _trans('profile.Enter TIN') }}" name="tin"
                value="{{ old('tin', @$data['show']->original['data']['tin']) }}">
            @if ($errors->has('tin'))
                <span class="text-danger">{{ $errors->first('tin') }}</span>
            @endif
        </div>


        {{--
        passport_number
        passport_file_id
        passport_expire_date
        start passport section
        --}}

        @php
            $isEmployeePassportRequired = settings('is_employee_passport_required') ? true : false;
        @endphp
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">
                        {{ _trans('profile.Passport Number') }}
                        @if ($isEmployeePassportRequired)
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <input type="text" class="form-control ot-form-control ot-input" placeholder="{{ _trans('profile.Enter Passport Number') }}" name="passport_number" value="{{ old('passport_number', @$data['show']->original['data']['passport_number']) }}" 
                        {{ $isEmployeePassportRequired ? 'required' : '' }}
                    >
                    @if ($errors->has('passport_number'))
                        <span class="text-danger">{{ $errors->first('passport_number') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Passport File') }} 
                        @if ($isEmployeePassportRequired)
                            <span class="text-danger">*</span>
                        @endif
                        @if (@$data['show']->original['data']['passport_file_id'])
                            [<span>
                                <a href="javascript:;"
                                    onclick="mainModalOpen(`{{ route('user.fileView', @$data['show']->original['data']['passport_file_id']) }}`) ">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </span>]
                        @endif
                    </label>
                    <div class="ot_fileUploader left-side mb-3">
                        <input class="form-control" type="text"  placeholder="{{ _trans('profile.Passport File') }}" name="" readonly=""  id="placeholder">
                        <button class="primary-btn-small-input" type="button">
                            <label class="btn btn-lg ot-btn-primary m-0" for="fileBrouse">{{ _trans('common.Browse') }}</label>
                            <input type="file" class="d-none form-control" name="passport_file_id" id="fileBrouse" 
                                {{ $isEmployeePassportRequired ? 'required' : '' }}
                            >
                        </button>
                    </div>
                    @if ($errors->has('passport_file_id'))
                        <span class="text-danger">{{ $errors->first('passport_file_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">
                        {{ _trans('profile.Passport Expire Date') }} 
                            @if ($isEmployeePassportRequired)
                                <span class="text-danger">*</span>
                            @endif
                        </label>
                    <input type="text" class="form-control ot-form-control ot-input expire-date"
                        name="passport_expire_date" placeholder="{{ _trans('profile.Passport Expire Date') }}" value="{{ old('passport_expire_date', @$data['show']->original['data']['passport_expire_date']) }}" 
                        {{ $isEmployeePassportRequired ? 'required' : '' }}
                    >
                    @if ($errors->has('passport_expire_date'))
                        <span class="text-danger">{{ $errors->first('passport_expire_date') }}</span>
                    @endif
                </div>
            </div>
        </div>
        {{-- end passport section  --}}

        {{--
            eid_number
            eid_file_id
            eid_expire_date
            start id section
        --}}

        @php
            $isEmployeeEIDRequired = settings('is_employee_eid_required') ? true : false;
        @endphp
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">
                        {{ _trans('profile.EID Number') }}
                        @if ($isEmployeeEIDRequired)
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <input type="text" class="form-control ot-form-control ot-input"
                        placeholder="{{ _trans('profile.Enter EID Number') }}" name="eid_number"
                        value="{{ old('eid_number', @$data['show']->original['data']['eid_number']) }}"
                        {{ $isEmployeeEIDRequired ? 'required' : '' }}
                    >
                    @if ($errors->has('eid_number'))
                        <span class="text-danger">{{ $errors->first('eid_number') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.EID File') }}
                        @if ($isEmployeeEIDRequired)
                            <span class="text-danger">*</span>
                        @endif
                        @if (@$data['show']->original['data']['eid_file_id'])
                            [<span>
                                <a href="javascript:;"
                                    onclick="mainModalOpen(`{{ route('user.fileView', @$data['show']->original['data']['eid_file_id']) }}`) ">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </span>]
                        @endif
                    </label>
                    <div class="ot_fileUploader left-side mb-3">
                        <input class="form-control" type="text" placeholder="{{ _trans('profile.EID File') }}"  name="" readonly="" id="placeholder2">
                        <button class="primary-btn-small-input" type="button">
                            <label class="btn btn-lg ot-btn-primary m-0" for="fileBrouse2">{{ _trans('common.Browse') }}</label>
                            <input type="file" class="d-none form-control" name="eid_file_id" id="fileBrouse2" 
                                {{ $isEmployeeEIDRequired ? 'required' : '' }}
                            >
                        </button>
                    </div>

                    @if ($errors->has('eid_file_id'))
                        <span class="text-danger">{{ $errors->first('eid_file_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">
                        {{ _trans('profile.EID Expire Date') }} 
                        @if ($isEmployeeEIDRequired)
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <input type="text" class="form-control ot-form-control ot-input expire-date" name="eid_expire_date" placeholder="{{ _trans('profile.EID Date') }}"  value="{{ old('eid_expire_date', @$data['show']->original['data']['eid_expire_date']) }}"
                        {{ $isEmployeeEIDRequired ? 'required' : '' }}
                    >
                    @if ($errors->has('eid_expire_date'))
                        <span class="text-danger">{{ $errors->first('eid_expire_date') }}</span>
                    @endif
                </div>
            </div>
        </div>
        {{-- end id section  --}}








        {{--
        visa_number
        visa_file_id
        visa_expire_date
        start VISA section
        --}}
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Visa Number') }}
                    </label>
                    <input type="text" class="form-control ot-form-control ot-input"
                        placeholder="{{ _trans('profile.Enter Visa Number') }}" name="visa_number"
                        value="{{ old('visa_number', @$data['show']->original['data']['visa_number']) }}">
                    @if ($errors->has('visa_number'))
                        <span class="text-danger">{{ $errors->first('visa_number') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Visa File') }}
                        @if (@$data['show']->original['data']['visa_file_id'])
                            [<span>
                                <a href="javascript:;"
                                    onclick="mainModalOpen(`{{ route('user.fileView', @$data['show']->original['data']['visa_file_id']) }}`) ">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </span>]
                        @endif
                    </label>
                    <div class="ot_fileUploader left-side mb-3">
                        <input class="form-control" type="text" placeholder="{{ _trans('profile.Visa File') }}" name="" readonly="" id="placeholder6">
                        <button class="primary-btn-small-input" type="button">
                            <label class="btn btn-lg ot-btn-primary m-0"
                                for="fileBrouse6">{{ _trans('common.Browse') }}</label>
                            <input type="file" class="d-none form-control" name="visa_file_id" id="fileBrouse6">
                        </button>
                    </div>

                    @if ($errors->has('visa_file_id'))
                        <span class="text-danger">{{ $errors->first('visa_file_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Visa Expire Date') }} </label>
                    <input type="text" class="form-control ot-form-control ot-input expire-date"
                        name="visa_expire_date" placeholder="{{ _trans('profile.Visa Expire Date') }}" value="{{ old('visa_expire_date', @$data['show']->original['data']['visa_expire_date']) }}">
                    @if ($errors->has('visa_expire_date'))
                        <span class="text-danger">{{ $errors->first('visa_expire_date') }}</span>
                    @endif
                </div>
            </div>
        </div>
        {{-- end VISA section  --}}






        {{--
        Insurance_number
        insurance_file_id
        insurance_expire_date
        start INSURANCE section
         --}}
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Insurance Number') }}
                    </label>
                    <input type="text" class="form-control ot-form-control ot-input"
                        placeholder="{{ _trans('profile.Enter Insurance Number') }}" name="insurance_number"
                        value="{{ old('insurance_number', @$data['show']->original['data']['insurance_number']) }}">
                    @if ($errors->has('insurance_number'))
                        <span class="text-danger">{{ $errors->first('insurance_number') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Insurance File') }}
                        @if (@$data['show']->original['data']['insurance_file_id'])
                            [<span>
                                <a href="javascript:;"
                                    onclick="mainModalOpen(`{{ route('user.fileView', @$data['show']->original['data']['insurance_file_id']) }}`) ">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </span>]
                        @endif
                    </label>
                    <div class="ot_fileUploader left-side mb-3">
                        <input class="form-control" type="text"  placeholder="{{ _trans('profile.Insurance File') }}" name="" readonly="" id="placeholder5">
                        <button class="primary-btn-small-input" type="button">
                            <label class="btn btn-lg ot-btn-primary m-0" for="fileBrouse5">{{ _trans('common.Browse') }}</label>
                            <input type="file" class="d-none form-control" name="insurance_file_id" id="fileBrouse5">
                        </button>
                    </div>
                    @if ($errors->has('insurance_file_id'))
                        <span class="text-danger">{{ $errors->first('insurance_file_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Insurance Expire Date') }} </label>
                    <input type="text" class="form-control ot-form-control ot-input expire-date"  name="insurance_expire_date" placeholder="{{ _trans('profile.Insurance Expire Date') }}" value="{{ old('insurance_expire_date', @$data['show']->original['data']['insurance_expire_date']) }}">
                    @if ($errors->has('insurance_expire_date'))
                        <span class="text-danger">{{ $errors->first('insurance_expire_date') }}</span>
                    @endif
                </div>
            </div>
        </div>
        {{-- end INSURANCE section  --}}






        {{--
        labour_card_number
        labour_card_file_id
        labour_card_expire_date
        start LABOUR CARD section
        --}}
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Labour Card Number') }} </label>
                    <input type="text" class="form-control ot-form-control ot-input"  placeholder="{{ _trans('profile.Enter Labour Card Number') }}" name="labour_card_number"  value="{{ old('labour_card_number', @$data['show']->original['data']['labour_card_number']) }}">
                    @if ($errors->has('labour_card_number'))
                        <span class="text-danger">{{ $errors->first('labour_card_number') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Labour Card File') }}
                        @if (@$data['show']->original['data']['labour_card_file_id'])
                            [<span>
                                <a href="javascript:;"
                                    onclick="mainModalOpen(`{{ route('user.fileView', @$data['show']->original['data']['labour_card_file_id']) }}`) ">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </span>]
                        @endif
                    </label>
                    <div class="ot_fileUploader left-side mb-3">
                        <input class="form-control" type="text"  placeholder="{{ _trans('profile.Labour Card File') }}" name="" readonly=""  id="placeholder4">
                        <button class="primary-btn-small-input" type="button">
                            <label class="btn btn-lg ot-btn-primary m-0" for="fileBrouse4">{{ _trans('common.Browse') }}</label>
                            <input type="file" class="d-none form-control" name="labour_card_file_id"  id="fileBrouse4">
                        </button>
                    </div>
                    @if ($errors->has('labour_card_file_id'))
                        <span class="text-danger">{{ $errors->first('labour_card_file_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mt-20">
                    <label class="mb-10">{{ _trans('profile.Labour Card Expire Date') }} </label>
                    <input type="text" class="form-control ot-form-control ot-input expire-date"  name="labour_card_expire_date" placeholder="{{ _trans('profile.Labour Card Expire Date') }}" value="{{ old('labour_card_expire_date', @$data['show']->original['data']['labour_card_expire_date']) }}">
                    @if ($errors->has('labour_card_expire_date'))
                        <span class="text-danger">{{ $errors->first('labour_card_expire_date') }}</span>
                    @endif
                </div>
            </div>
        </div>
        {{-- end LABOUR CARD section  --}}


        @if (hasPermission('user_update'))
            <div class="form-group d-flex justify-content-end mt-20">
                <button type="submit" class="btn btn-gradian">{{ _trans('common.Update') }}</button>
            </div>
            </form>
        @endif

    </div>
</div>
