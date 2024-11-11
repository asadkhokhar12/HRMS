$(".change-frontend-lang").on("change", function () {
    let selected_lang = $(this).val();
    $.ajax({
        url: $(".change_frontend_lang_url").val(),
        type: "POST",
        data: {
            lang: selected_lang,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if (data.success) {
                toastr.success(data.message, "Success");

                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                console.log('Error')
            }
        },
    });
});