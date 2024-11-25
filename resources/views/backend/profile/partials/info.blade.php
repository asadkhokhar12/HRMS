{{-- {{dd($data)}} --}}
<div class="profile-body p-40 pl-40 pr-40 pt-10">
    <!-- profile body nav start -->
    <div class="profile-body-form">
        @if (hasPermission('user_update'))
            <form method="POST" action="{{ route('user.update.profile', [$data['id'], $data['slug']]) }}"
                enctype="multipart/form-data">
                @csrf
                <input type="text" hidden name="user_id" value="{{ $data['id'] }}">
        @endif
        @if (hasPermission('user_update'))
            <div class="form-group mt-20">
                <label class="mb-10">{{ _trans('common.Tax') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control ot-form-control ot-input" name="tax"
                    placeholder="{{ _trans('common.Enter Tax') }}"
                    value="{{ $data['show']->original['data']['tax'] ?? 'N/A' }}">
                @if ($errors->has('tax'))
                    <span class="text-danger">{{ $errors->first('tax') }}</span>
                @endif
            </div>
        @endif
        <div class="form-group mt-20">
            <label class="mb-10">{{ _trans('common.Phone') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control ot-form-control ot-input" name="phone"
                placeholder="{{ _trans('common.Enter Phone') }}"
                value="{{ $data['show']->original['data']['phone'] ?? 'N/A' }}">
            @if ($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>
        <div class="form-group mt-20">
            <label class="mb-10">{{ _trans('profile.Date of Birth') }}</label>
            <input type="text" class="form-control ot-form-control ot-input s_date" name="birth_date"
                placeholder="{{ _trans('profile.Date of Birth') }}"
                value="{{ date('m/d/y', strtotime(@$data['show']->original['data']['birth_date_db'])) }}">
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
                        {{ $gender == @$data['show']->original['data']['gender'] ? 'selected' : '' }}>
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
                value="{{ @$data['show']->original['data']['address'] ?? 'N/A' }}">
            @if ($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
            @endif
        </div>

        <div class="form-group mt-20">
            <label class="mb-10">{{ _trans('profile.Nationality') }}</label>
            <input type="text" class="form-control ot-form-control ot-input"
                placeholder="{{ _trans('profile.Enter Nationality') }}" name="nationality"
                value="{{ @$data['show']->original['data']['nationality'] }}">
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
                        {{ $blood == @$data['show']->original['data']['blood_group'] ? 'selected' : '' }}>
                        {{ $blood }}</option>
                @endforeach
            </select>
            @if ($errors->has('blood_group'))
                <span class="text-danger">{{ $errors->first('blood_group') }}</span>
            @endif
        </div>
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
        {{-- <div class="form-group mt-20">
            <label class="mb-10">{{ _trans('profile.TIN') }}
            </label>
            <input type="text" class="form-control ot-form-control ot-input" name="tin"
                value="{{ $data['show']->original['data']['tin'] }}" placeholder="{{ _trans('profile.Enter TIN') }}">
            @if ($errors->has('tin'))
                <span class="text-danger">{{ $errors->first('tin') }}</span>
            @endif
        </div> --}}
        @if (hasPermission('user_update'))
            <div class="form-group d-flex justify-content-end mt-20">
                <button type="submit" class="btn btn-gradian">{{ _trans('common.Update') }}</button>
            </div>
            </form>
        @endif
    </div>
</div>
