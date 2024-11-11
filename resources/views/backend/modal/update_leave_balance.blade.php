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
                <form action="{{ $data['url'] }}" class="row p-2" method="post" id="modal_values" enctype="multipart/form-data">
                    @csrf
                    {{-- dynamic attributes --}}
                    @if (@$data['attributes'])
                        @foreach (@$data['attributes'] as $key => $attribute)
                            <div class="{{ @$attribute['col'] }}">
                                <label class="form-label">Leave Type</label><br>
                                <label>
                                    {{ @$attribute['label'] }} {{ @$attribute['title'] }}
                                </label>
                            </div>
                            <div class="{{ @$attribute['col'] }}">
                                <label class="form-label">
                                    {{ @$attribute['label'] }}
                                    @if (@$attribute['required'])
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                <input type="number" class="{{ @$attribute['class'] }}" name="leave[{{@$attribute['leave_type_id']}}][]" id="{{ @$key }}" 
                                        @if (@$attribute['required']) required @endif
                                        value="{{ @$attribute['value'] }}" autocomplete="off">
                            </div>
                        @endforeach
                    @endif
                    @if (@$data['attributes']->count() > 0)
                    <div class="form-group d-flex justify-content-end">
                        <button type="button" class="btn btn-gradian pull-right hit_modal">{{ @$data['button'] }}</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/fs_d_ecma/modal/__modal.min.js') }}"></script>
