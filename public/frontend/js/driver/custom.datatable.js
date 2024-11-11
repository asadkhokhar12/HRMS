$(document).ready( function () {
    // base url from meta tag
    var baseUrl = $('meta[name="base-url"]').attr('content');
    //tokens from base meta tag
    var _token = $('meta[name="csrf-token"]').attr('content');
    //start data table for all users
    function DriverDataTable(){
        let data = [];
        let url = $("#data_url").val();
        data['url'] = url;
        var from_date = $('.from').val();
        var to_date = $('.to').val();

        data['value'] = {
            'from' : from_date,
            'to' : to_date,
            '_token' : _token
        };

        data['column']=  [{ data: 'id', name: 'id' , visible: false},
                { data: 'name', name: 'name'},
                { data: 'phone', name: 'phone'},
                { data: 'role', name: 'role'},
                { data: 'status', name: 'status'},
                { data: 'action', name: 'action', orderable: false, searchable: true}];
        data['order'] = [[0, 'desc']];
        data['table_id'] = 'drivers_table';
        ajaxTable(data)

    }
    $('.drivers_table').length && DriverDataTable();
    // end data table for all users


    function ajaxTable(data, $search_false = null) {
        $(`.${data['table_id']}`).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
             url: data['url'],
             data: data['value']
             },
            //  bLengthChange: true,
             "bDestroy": true,
             language: {
                 paginate: {
                     next: "<i class='ti-arrow-right'></i>",
                     previous: "<i class='ti-arrow-left'></i>"
                 },
                 processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                 sEmptyTable: `<div
                                    class="no-data-found-wrapper text-center p-primary">
                                    <img src="${baseUrl}/public/images/no_data.svg"
                                        alt="" class="mb-primary">
                                    <p class="mb-0 text-center">Nothing to show
                                        here</p>
                                    <p
                                        class="mb-0 text-center text-secondary font-size-90">
                                        Please add a new entity or manage the
                                        data table to see the content here</p>
                                    <p
                                        class="mb-0 text-center text-secondary font-size-90">
                                        Thank you</p>
                                </div>`,
             },
             dom: 'Blfrtip',
             lengthMenu:[
                 [10,25,100,-1],
                 ['10 rows','25 rows','100 rows','Show all']
             ],
             buttons: [
                 {
                     extend: 'copyHtml5',
                     text: '<i class="fa fa-files-o"></i>',
                     titleAttr: 'Copy',
                     exportOptions: {
                         columns: ':visible',
                     }
                 },
                 {
                     extend: 'excelHtml5',
                     text: '<i class="fa fa-file-excel-o"></i>',
                     titleAttr: 'Excel',
                     exportOptions: {
                         columns: ':visible',
                         order: 'applied'
                     }
                 },
                 {
                     extend: 'csvHtml5',
                     text: '<i class="fa fa-file-text-o"></i>',
                     titleAttr: 'CSV',
                     exportOptions: {
                         columns: ':visible',
                     }
                 },
                 {
                     extend: 'pdfHtml5',
                     text: '<i class="fa fa-file-pdf-o"></i>',
                     titleAttr: 'PDF',
                     orientation: 'landscape',
                     pageSize: 'A5',
                       alignment: 'center',
                       header: true,
                       margin: 20,
                 },
                 'colvis'

             ],
              responsive: true,
              pageLength: 25,
              deferRender: true,
              fixedColumns: true,
              columns: data['column'],
              order: data['order'],
              searching: $search_false == null ? true : false,

          });
    }


    //end data table for all stickers

    function ajaxminiTable(data) {
        $(`.${data['table_id']}`).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
             url: data['url'],
             data: data['value']
             },
            //  bLengthChange: true,
             "bDestroy": true,
             language: {
                 paginate: {
                     next: "<i class='ti-arrow-right'></i>",
                     previous: "<i class='ti-arrow-left'></i>"
                 },
                 processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                 sEmptyTable: `<div
                                class="no-data-found-wrapper text-center p-primary">
                                <img src="${baseUrl}/public/images/no_data.svg"
                                    alt="" class="mb-primary">
                                <p class="mb-0 text-center">Nothing to show
                                    here</p>
                                <p
                                    class="mb-0 text-center text-secondary font-size-90">
                                    Please add a new entity or manage the
                                    data table to see the content here</p>
                                <p
                                    class="mb-0 text-center text-secondary font-size-90">
                                    Thank you</p>
                            </div>`,
             },
             dom: 'Blfrtip',
             lengthMenu:[
                 [10,25,100,-1],
                 ['10 rows','25 rows','100 rows','Show all']
             ],
             buttons: [
                 {
                     extend: 'copyHtml5',
                     text: '<i class="fa fa-files-o"></i>',
                     titleAttr: 'Copy',
                     exportOptions: {
                         columns: ':visible',
                     }
                 },
                 {
                     extend: 'excelHtml5',
                     text: '<i class="fa fa-file-excel-o"></i>',
                     titleAttr: 'Excel',
                     exportOptions: {
                         columns: ':visible',
                         order: 'applied'
                     }
                 },
                 {
                     extend: 'csvHtml5',
                     text: '<i class="fa fa-file-text-o"></i>',
                     titleAttr: 'CSV',
                     exportOptions: {
                         columns: ':visible',
                     }
                 },
                 {
                     extend: 'pdfHtml5',
                     text: '<i class="fa fa-file-pdf-o"></i>',
                     titleAttr: 'PDF',
                     orientation: 'landscape',
                     pageSize: 'A5',
                       alignment: 'center',
                       header: true,
                       margin: 20,
                 },
                 'colvis'

             ],
              responsive: true,
              lengthChange: false,
              pageLength: 25,
              deferRender: true,
              fixedColumns: true,
              columns: data['column'],
              order: data['order'],
              searching: true,

          });
    }

    //start data table for all visiting report data for driver data
    function VisitingReportDataTable(){
        let data = [];
        let url = $("#data_url").val();
        data['url'] = url;
        var from_date = $('#start').val();
        var to_date = $('#end_date').val();
        var driver_id = $('#driver_id').val();

        data['value'] = {
            'from' : from_date,
            'to' : to_date,
            'driver_id' : driver_id,
            '_token' : _token
        };

        data['column']=  [{ data: 'id', name: 'id' , visible: false},
            { data: 'name', name: 'name'},
            { data: 'date', name: 'date'},
            { data: 'hours', name: 'hours'},
            { data: 'distance', name: 'distance'},
            { data: 'map', name: 'map', orderable: true, searchable: true}];
        data['order'] = [[0, 'desc']];
        data['table_id'] = 'visiting_report_table';
        ajaxminiTable(data)

    }
    $('.visiting_report_table').length && VisitingReportDataTable();
    $('.data_table_form').on('click', () =>  VisitingReportDataTable())
    //end data table for all visiting report data for driver data


    // driver payment data table for all
    function DriverPaymentDataTable(){
            let data = [];
            let url = $("#data_url").val();
            data['url'] = url;
            var from_date = $('#start').val();
            var to_date = $('#end_date').val();

            data['value'] = {
                'from' : from_date,
                'to' : to_date,
                '_token' : _token
            };

            data['column']=  [{ data: 'id', name: 'id' , visible: false},
                { data: 'code', name: 'code',orderable: true, searchable: true},
                { data: 'name', name: 'name'},
                { data: 'date', name: 'date'},
                { data: 'amount', name: 'amount'},
                { data: 'status', name: 'status'}];
            data['order'] = [[0, 'desc']];
            data['table_id'] = 'driver_payment_list';
            ajaxminiTable(data)

        }

    $(".driver_payment_list").length && DriverPaymentDataTable();
    $('.driver_table_form').on('click', () =>  DriverPaymentDataTable())

    // driver payment data table for all
    function accountPaymentDataTable(){
        let data = [];
        let url = $("#data_url").val();
        data['url'] = url;
        var from_date = $('#start').val();
        var to_date = $('#end_date').val();
        var driver_id = $('#driver_id').val();

        data['value'] = {
            'from' : from_date,
            'to' : to_date,
            'driver_id' : driver_id,
            '_token' : _token
        };

        data['column']=  [{ data: 'id', name: 'id' , visible: false},
            { data: 'code', name: 'code'},
            { data: 'name', name: 'name'},
            { data: 'date', name: 'date'},
            { data: 'amount', name: 'amount'},
            { data: 'status', name: 'status'},
            { data: 'action', name: 'action', orderable: false, searchable: true}];
        data['order'] = [[0, 'desc']];
        data['table_id'] = 'account_payment_list';
        ajaxTable(data)

    }

    $(".account_payment_list").length && accountPaymentDataTable();
    $('.account_table_form').on('click', () =>  accountPaymentDataTable())




    // default data table for all

    $('.buttons-colvis').on('click', () => {
        $('.dt-button-collection').css("left","");
    });
    $('.dataTables_filter > label').append('<i class="fbi bi-search _search_icon"></i>');



 });
