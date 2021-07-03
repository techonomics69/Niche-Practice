$(function () {
    $(".remove-me").click(function () {
        var siteUrl = $('#hfBaseUrl').val();
        var template = $(this).attr('data-target-id');
        var currentTarget = $(this);

        showPreloader();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: siteUrl + "/done-me",
            data: {
                send: 'admin-delete-template',
                id: template,
            },
            // contentType: false,
            // cache: false,
            // processData: false,
            // data: formData,
        }).done(function (result) {
            var json = $.parseJSON(result);
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;

            hidePreloader();

            if(statusCode == 200)
            {
                // if($("tbody tr").length != 1)
                // {
                //     currentTarget.closest('tr').remove();
                // }

                // console.log("length ");
                // console.log($("tbody tr").length);
                swal({
                    title: "Success!",
                    text: statusMessage,
                    type: 'success'
                }, function () {
                    if($("tbody tr").length == 1)
                    {
                        currentTarget.closest('tr').remove();
                        showPreloader();
                        // console.log("inside");
                        location.reload();
                    }
                    else {
                        currentTarget.closest('tr').remove();
                    }
                });
            }
            else
            {
                swal({
                    title: "Error!",
                    text: statusMessage,
                    type: 'error'
                }, function () {
                });
            }
        });
    });
    $('.copy-me').click(function () {
        var siteUrl = $('#hfBaseUrl').val();
        var template = $(this).attr('data-target-id');
        var currentTarget = $(this);

        showPreloader();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: siteUrl + "/done-me",
            data: {
                send: 'admin-copy-template',
                id: template,
            }
        }).done(function (result) {
            var json = $.parseJSON(result);
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;
            // console.log(data);
            hidePreloader();

            if(statusCode == 200)
            {
                swal({
                    title: "Success!",
                    text: statusMessage,
                    type: 'success'
                }, function() {
                    window.location.reload(true);
                });

            }
            else
            {
                swal({
                    title: "Error!",
                    text: statusMessage,
                    type: 'error'
                }, function () {
                });
            }


         });
     });
    $(document.body).on('click', '.change-status' ,function() {
        var siteUrl = $('#hfBaseUrl').val();
        var template = $(this).attr('data-target-id');
        var status = $(this).attr('data-status');
        var currentTarget = $(this);
        var parentSel = currentTarget.parent('.status');

        showPreloader();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: siteUrl + "/done-me",
            data: {
                send: 'admin-template-status',
                id: template,
                status: status,
            },
            // contentType: false,
            // cache: false,
            // processData: false,
            // data: formData,
        }).done(function (result) {
            var json = $.parseJSON(result);
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;

            if(status == 'drafts')
            {
                parentSel.html('<span class="inactive change-status" data-target-id="'+template+'" data-status="active">Drafts</span>');
            }
            else
            {
                parentSel.html('<span class="active change-status" data-target-id="'+template+'" data-status="drafts">Active</span>');
            }


            hidePreloader();

            if(statusCode == 200)
            {

                // if($("tbody tr").length != 1)
                // {
                //     currentTarget.closest('tr').remove();
                // }

                // console.log("length ");
                // console.log($("tbody tr").length);
                swal({
                    title: "Success!",
                    text: statusMessage,
                    type: 'success'
                }, function () {
                });
            }
            else
            {
                swal({
                    title: "Error!",
                    text: statusMessage,
                    type: 'error'
                }, function () {
                });
            }
        });
    });

    $(".import-template").click(function () {
        var mainModel = $('#main-modal');
        $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
        $(mainModel).removeClass('welcome-process');
        $(mainModel).addClass('modal-import-template');

        var html = '';

        html += '<div class="modal-body" style="padding-top: 0px !important;">\n' +
            '                                <h3 style="color: #3c8dbc;font-weight: bold;text-align: center;" class="modal-title p-b-10">IMPORT TEMPLATE WITH JSON</h3>\n' +

            '                                <div class="row">\n' +
            '                                    <div class="col-md-12">\n' +
            '                                        <div class="user-text-content">\n' +
            '                                            <div class="p-20">\n' +
            '                                                <textarea id="json"></textarea>\n' +
            '                                                <span class="help-block"></span>\n' +
            '                                            </div>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +

            '                                </div>\n' +
            '                            </div>';

        html +='<div class="modal-footer">';
        html +='<button type="button" class="btn btn-primary update-import">Import</button>';
        html +='<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
        html +='</div>';

        mainModel.modal('show');
        $(".modal-header").after(html);
    });
});

$(document.body).on('click', '.update-import', function(e)
{
    var response = $("#json").val().trim();
    var importSource = $(".import-template").attr("data-source");

    var errorHandler = $("span.help-block");

    if(response === '')
    {
        errorHandler.removeClass('hide-me');
        errorHandler.addClass('error');
        errorHandler.html('Please paste your json code.');

        return false;
    }
    else if(response.length < 100)
    {
        errorHandler.removeClass('hide-me');
        errorHandler.addClass('error');
        errorHandler.html('Please paste your json code.');
        return false;
    }
    else
    {
        errorHandler.removeClass('error');
        errorHandler.addClass('hide-me');
    }

    var siteUrl = $('#hfBaseUrl').val();
    var currentTarget = $(this);

    showPreloader();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: siteUrl + "/done-me",
        data: {
            send: 'admin-save-template',
            title: "Import Template",
            subject: "Import Template",
            template_source: importSource,
            type: 'import',
            response: response
        },
    }).done(function (result) {
        var json = $.parseJSON(result);
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        var data = json.data;

        if(statusCode == 200)
        {
            if(importSource === 'patient_campaign')
            {
                location.href = siteUrl+'/admin/templates/patient-email-template/'+data.id;
            }
            else
            {
                location.href = siteUrl+'/admin/templates/email-template/'+data.id;
            }
        }
        else
        {
            hidePreloader();
            swal({
                title: "Error!",
                text: statusMessage,
                type: 'error'
            }, function () {
            });
        }
    });
});
