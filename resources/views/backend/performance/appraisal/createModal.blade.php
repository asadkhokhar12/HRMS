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
                                <div class="col-md-12 form-group mb-3">
                                    <div class="form-group">
                                        <label for="#" class="form-label">
                                            {{ _trans('common.Title') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="title" id="title"
                                            class="form-control ot-form-control ot-input"
                                            placeholder="{{ _trans('common.Title') }}" required
                                            value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="name" class="form-label">
                                            {{ _trans('project.Employee') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="user_id" class="form-select mb-3 modal_select2" required>
                                            @foreach ($data['users'] as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="#" class="form-label">
                                            {{ _trans('common.Date') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="date" id="date"
                                            class="form-control ot-form-control ot-input" required
                                            value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <label for="#" class="form-label">
                                            {{ _trans('common.Remarks') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control mt-0 ot-input" placeholder="{{ _trans('common.Enter Remarks') }}" name="remarks"
                                            id="remarks" rows="5" required></textarea>
                                    </div>
                                </div>



                            </div>
                            <div class="row mt-3">
                                @foreach ($data['competence_types'] as $competence_type)
                                    <div class="col-md-12 mb-2">
                                        <h6>{{ $competence_type->name }}</h6>
                                    </div>
                                    <hr class="p-0 mt-8">

                                    @foreach ($competence_type->competencies as $competences)
                                        <div class="col-6">
                                            <p class="primary-color">{{ $competences->name }}</p>
                                        </div>
                                        <div class="col-6">
                                            <fieldset id="demo1" class="rating">
                                                <input type="radio" id="star5_{{ $competences->id }}"
                                                    name="rating[{{ $competences->id }}]" value="5" />
                                                <label class="full" for="star5_{{ $competences->id }}"
                                                    title="Awesome - 5 stars"></label>
                                                <input type="radio" id="star4half_{{ $competences->id }}"
                                                    name="rating[{{ $competences->id }}]" value="4.5" />
                                                <label class="half" for="star4half_{{ $competences->id }}"
                                                    title="Pretty good - 4.5 stars"> </label>
                                                <input type="radio" id="star4_{{ $competences->id }}"
                                                    name="rating[{{ $competences->id }}]" value="4" />
                                                <label class="full" for="star4_{{ $competences->id }}"
                                                    title="Pretty good - 4 stars"></label>
                                                <input type="radio" id="star3half_{{ $competences->id }}"
                                                    name="rating[{{ $competences->id }}]" value="3.5" />
                                                <label class="half" for="star3half_{{ $competences->id }}"
                                                    title="Meh - 3.5 stars"></label>
                                                <input type="radio" id="star3_{{ $competences->id }}"
                                                    name="rating[{{ $competences->id }}]" value="3" />
                                                <label class="full" for="star3_{{ $competences->id }}"
                                                    title="Meh - 3 stars"></label>
                                                <input type="radio" id="star2half_{{ $competences->id }}"
                                                    name="rating[{{ $competences->id }}]" value="2.5" />
                                                <label class="half" for="star2half_{{ $competences->id }}"
                                                    title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" id="star2_{{ $competences->id }}"
                                                    name="rating[{{ $competences->id }}]" value="2" />
                                                <label class="full" for="star2_{{ $competences->id }}"
                                                    title="Kinda bad - 2 stars"></label>
                                                <input type="radio" id="star1half_{{ $competences->id }}"
                                                    name="rating[{{ $competences->id }}]" value="1.5" />
                                                <label class="half" for="star1half_{{ $competences->id }}"
                                                    title="Meh - 1.5 stars"></label>
                                                <input type="radio" id="star1_{{ $competences->id }}" checked
                                                    name="rating[{{ $competences->id }}]" value="1" />
                                                <label class="full" for="star1_{{ $competences->id }}"
                                                    title="bad time - 1 star"></label>
                                            </fieldset>
                                        </div>
                                    @endforeach
                                @endforeach
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
