<div id="app_theme_setup" class="tab-pane fade {{ $app_theme_setup ? 'active show' : '' }}">
    <div class="d-flex justify-content-between">
        <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
            {{ _trans('settings.App Theme Setup') }}
        </h5>
    </div>
    <hr>
    <div class="content py-primary">
        <form action="{{ route('manage.settings.update.appTheme') }}" method="post"
            class="mb-0">
            @csrf
            <div class="form-group row align-items-center mb-3 h-100vh">
                <h3>{{ _trans('settings.Choose one theme') }}</h3>
                <div class="col-lg-3 col-xl-3">
                    <div class="div">
                        <label for="app_theme_1">
                            <input type="radio" @if(base_settings('default_theme')== 'app_theme_1') checked @endif  value="app_theme_1" name="app_theme" id="app_theme_1">
                            <img id="get-screen" class="profile-user-img img-fluid " style="max-height: 200px"
                                src="{{ asset(base_settings('app_theme_1')) }}"
                                alt="User profile picture">
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-xl-3">
                    <div class="div">
                        <label for="app_theme_2">
                            <input type="radio" @if(base_settings('default_theme')== 'app_theme_2') checked @endif  value="app_theme_2" name="app_theme" id="app_theme_2">
                            <img id="get-screen" class="profile-user-img img-fluid " style="max-height: 200px"
                                src="{{ asset(base_settings('app_theme_2')) }}"
                                alt="User profile picture">
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-xl-3">
                    <div class="div">
                        <label for="app_theme_3">
                            <input type="radio" @if(base_settings('default_theme')== 'app_theme_3') checked @endif  value="app_theme_3" name="app_theme" id="app_theme_3">
                            <img id="get-screen" class="profile-user-img img-fluid " style="max-height: 200px"
                                src="{{ asset(base_settings('app_theme_3')) }}"
                                alt="User profile picture">
                        </label>
                    </div>

                </div>
            </div>
            @if (hasPermission('general_settings_update'))
                <div class="d-flex justify-content-end">
                    <button class="btn btn-gradian mr-2">
                        {{ _trans('common.Save') }}
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>