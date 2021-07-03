$(document).ready( function () {
    $('[data-toggle="popover"]').popover();
    $(".recipient-selection").change(function () {
        var selectedItem = $(this).val();
        var baseUrl = $('#hfBaseUrl').val();

        if(selectedItem === 'single')
        {
            showPreloader();

            location.href = baseUrl+'/recipients/add-recipient';
        }
        else if(selectedItem === 'multiple')
        {
            showPreloader();
            location.href = baseUrl+'/recipients/add-multiple-recipient';
        }
    });

    $('.selectpicker').selectpicker();
    $('#recipient-list').DataTable(
        {
            pageLength: 20,
            lengthChange: false,
            searching: false,
            ordering: false,
            info: true,
            language: {
                emptyTable: "Recipients not found.",
                paginate: {
                    first: "First",
                    previous: "<i class='fa fa-caret-left'></i>",
                    next: "<i class='fa fa-caret-right'></i>",
                    last:  "Last"
                },
                "lengthMenu": "_MENU_ ",
                "info": "_START_ to _END_ of _TOTAL_",
                "infoEmpty": "0 of 0"
            }
        });

    var element=$(".dataTables_paginate");
    var dataTables_info_element=$(".dataTables_info");
    $(".recipient-stats #info_cont").html( dataTables_info_element);
    $(".recipient-stats #pagination_cont").html( element);

    //if(noOfRecords=='0'){
    //    $("#recipient-list_wrapper .dataTables_paginate").hide();
    //}

    $(document).on("click", "#send_review_requests_existing_customers", function (e) {
        if(!$(this).hasClass('disabled')){
            var baseUrl = $('#hfBaseUrl').val();
            showPreloader();
            location.href = baseUrl+'/customers-list';
        }
    });


});