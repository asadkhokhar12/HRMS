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
                        <form action="{{ $data['url'] }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">

                                    {{ _trans('common.Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control ot-form-control ot-input" name="name"
                                    placeholder="{{ _trans('common.Name') }}" required
                                    value="{{ @$data['edit'] ? $data['edit']->name : old('name') }}">

                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">
                                    {{ _trans('common.Status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control ot-input modal_select2" required>
                                    <option value="1"
                                        {{ @$data['edit'] ? ($data['edit']->status_id == 1 ? 'Selected' : '') : '' }}>
                                        {{ _trans('payroll.Active') }}</option>
                                    <option value="4"
                                        {{ @$data['edit'] ? ($data['edit']->status_id == 4 ? 'Selected' : '') : '' }}>
                                        {{ _trans('payroll.Inactive') }}</option>
                                </select>
                            </div>
                            <div class="form-group text-right d-flex justify-content-end">
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
<script src="{{ global_asset('backend/js/fs_d_ecma/modal/__modal.min.js') }}"></script>
