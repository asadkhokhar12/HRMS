$(document).ready(function() {

    var baseUrl = $('meta[name="base-url"]').attr('content');
    // tokens
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    //vehicle 
    $('.select2').select2({
            placeholder: "Select Driver"
        });
    $('.vehicle_makes').select2({
        placeholder: 'Choose Make',
        ajax: {
            url: baseUrl + '/vehicle-select/get-make',
            dataType: 'json',
            type: 'POST',
            delay: 250,
            processResults : function( data ){
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id,
                        }
                    })
                }
            },
            cache: false
        }
    });

    //vehicle make year
    $('.vehicle_year').select2({
        placeholder: 'Choose Year',
        ajax: {
            url: baseUrl + '/vehicle-select/get-year',
            dataType: 'json',
            type: 'POST',
            delay: 250,
            data: function(params){
                return {
                    term: params.term,
                    vehicle_make_id: $('select[name="vehicle_make_id"]').val()
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.year,
                            id: item.id,
                        }
                    })
                }
            },
            cache: false
        }
    });

    //vehicle models
    $('.vehicle_models').select2({
        placeholder: 'Choose Model',
        ajax: {
            url: baseUrl + '/vehicle-select/get-model',
            dataType: 'json',
            type: 'POST',
            delay: 250, data: function(params){
                return {
                    term: params.term,
                    vehicle_make_year_id: $('select[name="vehicle_make_year_id"]').val()
                };
            },
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.name,
                            id: item.id,
                        }
                    })
                }
            },
            cache: false
        }
    });

      // get vehicle colors
      $('.vehicle_color').select2({
        placeholder: 'Choose Color',
        ajax: {
            url: baseUrl + '/vehicle-select/get-color',
            dataType: 'json',
            type: 'POST',
            delay: 250,
            processResults: function (data) {

                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.name,
                            id: item.id,
                        }
                    })
                }
            },
            cache: false
        }
    });


    viewModal = (ur) => {
        $.get(ur, function (data) {
            console.log(data);
            if (data == 'fail') {
                setTimeout(function () {
                    toastr.error('Something went wrong!', 'Error!', {
                        timeOut: 2000
                    });
                }, 500);
            } else {  
              $(data).appendTo('body').modal({
                backdrop: 'static',
                keyboard: false
              });
        }
        })        
     }
});