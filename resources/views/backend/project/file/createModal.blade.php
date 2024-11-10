<div class="modal  fade lead-modal in" id="lead-modal" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">
            <div class="modal-header modal-header-image text-center">
                <h5 class="modal-title text-white">{{ @$data['title'] }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times text-white" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row p-2">
                    <div class="col-md-12">
                        <form action="{{ $data['url'] }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">{{ _trans('common.Subject') }} <span class="text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control ot-form-control ot-input"
                                    placeholder="{{ _trans('common.Subject') }}" required>
                                    <div class="error_show_subject"></div>
                            </div>
                            <div class="form-group pt-3">
                                <label class="form-label">{{ _trans('common.Attach File') }} <span class="text-danger">*</span></label>
                                <input type="file" name="attach_file" class="form-control file_note ot-form-control ot-input"
                                    placeholder="{{ _trans('common.Title') }}" required>
                                    <div class="error_show_attach_file"></div>
                            </div>
                            <div class="form-group d-none">
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" name="show_to_customer" value="1"
                                        {{ @$data['edit']->show_to_customer == 33 ? 'checked' : '' }}
                                        id="show_to_customer">
                                    <label for="show_to_customer">{{ _trans('project.Visible to Customer') }}</label>
                                </div>
                            </div>
                            <div class="form-group text-right pt-3 d-flex justify-content-end">
                                <button type="submit"
                                    class="btn btn-gradian pull-right">{{ @$data['button'] }}</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>