<div class="form-group mb-3">
    <div class="row">
        <div
            class="col-12 col-form-label text-primary pt-0 mb-3">
            {{ _trans('settings.Live tracking setting') }}
        </div>
        <div class="col-md-12">
            <div class="form-group row mb-3"><label
                    class="col-sm-3 col-form-label">
                    {{ _trans('settings.App sync time') }}
                </label>
                <div class="col-sm-4">
                    <div>
                        <div class="radio-button-group">
                            <div>
                                <input type="text"
                                    class="form-control ot-form-control ot-input"
                                    name="app_sync_time"
                                    value="{{ @$data['configs']['app_sync_time'] }}"
                                    placeholder="{{ _trans('settings.App sync time') }}"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group row"><label
                    class="col-sm-3 col-form-label">
                    {{ _trans('settings.Live data store after') }}
                </label>
                <div class="col-sm-4">
                    <div>
                        <div class="radio-button-group">
                            <div >
                                <input type="text"
                                    class="form-control ot-form-control ot-input"
                                    name="live_data_store_time"
                                    value="{{ @$data['configs']['live_data_store_time'] }}"
                                    placeholder="{{ _trans('settings.Live data store time') }}"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>