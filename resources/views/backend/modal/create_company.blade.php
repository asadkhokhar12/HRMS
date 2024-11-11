<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: none;
        z-index: 1000;
    }

    #loader {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }

    /* Center the spinner within the loader */
    #loader .d-flex {
        justify-content: center;
        align-items: center;
        height: 100%;
    }
</style>
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
                <form action="{{ $data['url'] }}" class="row p-2" method="post" id="modal_values"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- dynamic attributes --}}
                    @if (@$data['attributes'])
                        @foreach (@$data['attributes'] as $key => $attribute)
                            <div class="{{ @$attribute['col'] }}">
                                <label class="form-label">
                                    {{ @$attribute['label'] }}
                                    @if (@$attribute['required'])
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                @if (@$attribute['type'] == 'text')
                                    <input type="text" class="{{ @$attribute['class'] }}" name="{{ @$key }}"
                                        id="{{ @$key }}" placeholder="{{ @$attribute['label'] }}"
                                        @if (@$attribute['required']) required @endif autocomplete="off"
                                        value="{{ @$attribute['value'] }}">
                                @elseif (@$attribute['type'] == 'select')
                                    <select name="{{ @$key }}" id="{{ @$attribute['id'] }}"
                                        class="{{ @$attribute['class'] }}" aria-label="Default select example"
                                        @if (@$attribute['required']) required @endif
                                        {{ @$attribute['multiple'] }}>
                                        @foreach (@$attribute['options'] as $option)
                                            <option value="{{ $option['value'] }}"
                                                {{ @$option['active'] ? 'selected' : '' }}>
                                                <?= $option['text'] ?>
                                            </option>
                                        @endforeach
                                    </select>
                                @elseif (@$attribute['type'] == 'number')
                                    <input type="number" class="{{ @$attribute['class'] }}"
                                        name="{{ @$key }}" id="{{ @$key }}"
                                        @if (@$attribute['required']) required @endif
                                        value="{{ @$attribute['value'] }}" autocomplete="off">
                                @elseif (@$attribute['type'] == 'date')
                                    <input type="text" class="{{ @$attribute['class'] }}"
                                        name="{{ @$key }}" id="{{ @$attribute['id'] }}"
                                        @if (@$attribute['required']) required @endif
                                        value="{{ @$attribute['value'] }}" autocomplete="off">
                                @elseif (@$attribute['type'] == 'file')
                                    <input type="file" class="{{ @$attribute['class'] }}"
                                        name="{{ @$key }}" id="{{ @$attribute['id'] }}"
                                        @if (@$attribute['required']) required @endif
                                        value="{{ @$attribute['value'] }}" autocomplete="off">
                                @elseif (@$attribute['type'] == 'checkbox')
                                    <div class="form-check">
                                        <input type="checkbox" class="{{ @$attribute['class'] }}"
                                            name="{{ @$key }}" id="{{ @$key }}" value="1">
                                        <label class="form-check-label">{{ @$attribute['label'] }}</label>
                                    </div>
                                @elseif (@$attribute['type'] == 'textarea')
                                    <textarea class="{{ @$attribute['class'] }}" name="{{ @$key }}" rows="{{ @$attribute['row'] ?? 1 }}"
                                        placeholder="{{ @$attribute['label'] }}" @if (@$attribute['required']) required @endif>{{ @$data['edit'] ? $data['edit']->$key : old($key) }}</textarea>
                                @endif
                            </div>
                        @endforeach

                    @endif
                    <div class="form-group d-flex justify-content-end">
                        <button type="button"
                            class="btn btn-gradian pull-right loader-btn">{{ @$data['button'] }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="overlay" id="overlay"></div>

<div id="loader">
    <div class="d-flex justify-content-center align-items-center">
        <div class="spinner-border text-white" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="text-center mt-3">
        <p class="text-white">Please wait...</p>

    </div>
</div>





<script src="{{ global_asset('backend/js/fs_d_ecma/modal/__modal.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // $('.loader-btn').click(function() {
        //     // Remove any existing modal
        //     if ()
        //         // $('.modal').modal('hide');
        //         // Show the overlay
        //         $('#overlay').show();
        //     // Display the loader
        //     $('#loader').show();
        // });

        $('#subdomain').on('keyup change', function() {
            var inputValue = $(this).val();
            var inputValueWithoutSpaces = inputValue.replace(/ /g, '');
            $('#subdomain').val(inputValueWithoutSpaces);
        });
        $('.loader-btn').on('click', function(e) {
            e.preventDefault();

            var data = {
                url: $('#modal_values').attr('action'),
                data: $('#modal_values').serialize(),
                value: {
                    method: 'POST',
                    _token: _token,
                    load: 'table',
                },
            };

            // Show the loader immediately when the request starts
            $('#overlay').show();
            $('#loader').show();
            $('.modal').modal('hide');

            http_Request([data])
                .then(function(response) {
                    console.log(response);

                    // Hide the loader once the response is received
                    $('#loader').hide();

                    if (response.status === 200) {
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message,
                            timer: 1500,
                        });

                        $('#overlay').hide();

                        location.reload(true);
                    } else {
                        $('#overlay').show();
                        $('.modal').modal('show');
                        Toast.fire({
                            icon: 'error',
                            title: response?.data?.message || 'Something went wrong.',
                        });
                    }
                })
                .catch(function(error) {
                    $('.modal').modal('show');
                    $('#overlay').show();

                    $('.btn-close').on('click', function() {
                        $('#overlay').hide();
                    });

                    $('body').on('click', function() {
                        $('#overlay').hide();
                    });

                    $('#loader').hide();

                    if (error?.response?.data?.errors) {
                        $.each(error.response.data.errors, function(key, value) {
                            $('#' + key).removeClass('is-invalid');
                            const select2Tags = $('#' + key).next().find(
                                '.select2-selection');

                            if (select2Tags?.prevObject[0]?.className ===
                                'select2 select2-container select2-container--default') {
                                $('#' + key).next('.select2-container').next().empty();
                                $('#' + key).next('.select2-container').after(
                                    '<div class="invalid-feedback d-inline">' + value[
                                    0] + '</div>');
                            } else {
                                $('#' + key).next().empty();
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).after('<div class="invalid-feedback">' + value[
                                    0] + '</div>');
                            }
                        });
                    } else if (error?.response?.data?.message) {

                        $('#overlay').show();
                        $('.modal').modal('show');
                        Toast.fire({
                            icon: 'error',
                            title: error.response.data.message,
                        });
                    }
                });
        });

    });

    $(document).ready(function() {
        $('#subdomain').on('keyup change', function() {
            var inputValue = $(this).val();
            // Use a regular expression to remove all special characters
            var cleanedValue = inputValue.replace(/[^\w-]+/g, '');
            $(this).val(cleanedValue);
        });
    });
</script>
