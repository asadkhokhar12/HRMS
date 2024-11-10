<div class="modal  fade lead-modal in" id="lead-modal" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog  modal-dialog-centered modal-lg">
        <div class="modal-content data">
            <div class="modal-header modal-header-image text-center">
                <h5 class="modal-title text-white">{{ @$data['title'] }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times text-white" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row p-5">
                    <div class="col-md-12">
                        <form action="{{ $data['url'] }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="Amount" class="form-label required">{{ _trans('common.Amount') }}</label>
                                <input type="number" class="form-control ot-input ot-form-control" min="0"
                                    step="any" name="amount" id="Amount" autocomplete="off" step="0.01"
                                    value="{{ $data['advance']->due_amount }}" />
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ _trans('common.Category') }}</label>
                                <select name="category" class="form-control modal_select2">

                                    @foreach ($data['category'] as $account)
                                        <option
                                            {{ @$data['edit'] ? (@$data['edit']->income_expense_category_id == $account->id ? 'selected' : '') : '' }}
                                            value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ _trans('common.Account') }}</label>
                                <select name="account" class="form-control modal_select2">
                                    @foreach ($data['accounts'] as $account)
                                        <option
                                            {{ @$data['edit'] ? (@$data['edit']->account_id == $account->id ? 'selected' : '') : '' }}
                                            value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ _trans('account.Payment Method') }} <span
                                        class="text-danger">*</span></label>
                                <select name="payment_method" class="form-control modal_select2" required>
                                    @foreach ($data['payment_method'] as $payment_method)
                                        <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ _trans('common.Note') }} <span
                                        class="text-danger">*</span></label>
                                <textarea type="text" name="description" rows="5" class="form-control ot-input"
                                    placeholder="{{ _trans('common.Enter payment note') }}" required>{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group mb-3 float-right">
                                <button type="submit"
                                    class="btn btn-primary pull-right"><b>{{ _trans('common.Submit') }}</b></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ global_asset('backend/js/fs_d_ecma/modal/__modal.min.js') }}"></script>
{{-- <script src="{{ global_asset('backend/js/_payment.js') }}"></script> --}}
