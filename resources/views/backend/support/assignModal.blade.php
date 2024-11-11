<div class="modal fade lead-modal" id="lead-modal" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">
            <div class="modal-header modal-header-image mb-3">
                <h5 class="modal-title text-white">{{ @$data['title'] }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times text-white" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row p-2">
                    <div class="col-md-12">
                        <form action="{{ $data['url'] }}" method="POST" id="modal_values">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">
                                            {{ _trans('common.Employee') }}
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select name="department_id"
                                            class="form-select select2-input ot-input mb-3 modal_select2" required>
                                            @foreach ($data['users'] as $user)
                                                <option
                                                    {{ $user->id == @$data['edit']->department_id ? ' selected' : '' }}
                                                    value="{{ $user->id }}">{{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button type="button"
                                    class="btn btn-gradian pull-right hit_modal">{{ @$data['button'] }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ global_asset('backend/js/fs_d_ecma/modal/__modal.min.js') }}"></script>
