$(document.body).on('click', '.request-edit' ,function() {
    // $('.remove-business-body, .social-module, .local-module, .select-business-body').hide();

    var mainModel = $('#main-modal');
    $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
    // $(".welcome-process", mainModel).remove();
    $(mainModel).removeClass('welcome-process');
    $(mainModel).addClass('request-edit-interface');

    var html = '';

    html += '<div class="modal-body p-t-0">\n' +
        '          <div class="row">\n' +
        '    \n' +
        '              <div class="col-sm-12">\n' +
        '    <h2 class="modal-heading m-t-0" style="text-transform: uppercase;">General Edit Request:</h2>\n' +
        '                  <textarea name="requestForm" id="requestForm" placeholder="Let the writer know what\'s working, what isn\'t and be as specific as possible..."></textarea>\n' +
        '              </div>\n' +
        '          </div>\n' +
        '        </div>';

        html +='<div class="modal-footer">\n' +
        '          <button type="button" class="btn btn-primary left">Send to writer</button>\n' +
        '          <button type="button" class="btn btn-default left" data-dismiss="modal">Go back</button>\n' +
        '        </div>';

    mainModel.modal('show');
    $(".modal-header").after(html);
});

$('#main-modal').on('hidden.bs.modal', function () {
    var mainModel = $('#main-modal');
    $(".modal-body, .modal-footer, .validate-me, .schedule-heading", mainModel).remove();
});