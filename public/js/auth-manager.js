window.appName = 'NichePractice';
// console.log(window.appName);

// $(window).load(function(){
//     console.log("loading");
//     setTimeout(function () {
//         runAuthAction();
//     }, 1000);
// });

$(document.body).on('click', '.connect-auth', function() {
    var type = $(this).attr("data-type").toLowerCase();
    var baseUrl = $('#hfBaseUrl').val();

    if(type)
    {
        var id = 'auth-manager-modal';

        var html = '';
        html += '<div class="social-module">';

        html += '<div class="'+type+'-connect-icon"></div>';

        html += '<div class="social-modal-content">';
        html += '<h3>Authorize '+window.appName+' on '+type.charAt(0).toUpperCase() + type.substr(1).toLowerCase()+'</h3>';

        html += '<div class="social-list">';
        html += '<label>By connecting your account, you will be able to:</label>';
        html += '<ul>';
        html += '<li>Receive viral content recommendations from '+window.appName+' and share them to your '+type.charAt(0).toUpperCase() + type.substr(1).toLowerCase()+' profile.</li>';
        html += '<li>Monitor activity and manage posts.</li>';
        html += '</ul>';
        html += '</div>';
        html += '</div>';

        html +='</div>';

        loadModal(id);

        $('#'+id).addClass('confirmation-modal');
        $('.modal-dialog', '#'+id).addClass('modal-lg modal-dialog-centered');
        $(".modal-title",'#'+id).remove();
        $('.modal-body', '#'+id).html(html);

        html = '';
        html +='<div class="modal-footer">';
        html +='<button type="button" class="btn '+type+'-widget-btn connect-in" data-type="'+type+'">';

        html += 'Connect ' + type.charAt(0).toUpperCase() + type.substr(1).toLowerCase();

        html +='</button>';

        html +='</div>';

        $('.modal-content', '#'+id).append(html);
    }
});

$(document.body).on('click', '.connect-in', function() {
    showPreloader();
    // var type = $(this).attr("data-type");
    var type = $("#actionRequest").val();
    var baseUrl = $('#hfBaseUrl').val();
    var currentPage = $('#currentPage').val();
    var business_id = $('#business_id').val();

    if(type)
    {
        if(currentPage === 'social_post_settings' || currentPage === 'get_started')
        {
            location.href = baseUrl + '/auth-manager?type='+type+'&referType='+currentPage+'&business_id='+business_id;
        }
        else if(currentPage === 'promotions')
        {
            location.href = baseUrl + '/auth-manager?type='+type+'&referType='+currentPage+'&business_id='+business_id+'&promotion='+window.btoa(window.templateId);
        }
        else
        {
            location.href = baseUrl + '/auth-manager?type='+type+'&business_id='+business_id;
        }
    }
});

$(document.body).on('hidden.bs.modal', '#auth-manager-modal', function() {
    var modelId = $("#auth-manager-modal");

    // $(".modal-header .modal-title", modelId).remove();
    modelId.removeClass("confirmation-modal");
    $(".modal-dialog", modelId).removeClass("modal-lg modal-dialog-centered");
    $(".modal-footer", modelId).remove();
});


function runAuthAction()
{
    // console.log("runAuthAction");
    var accessTokenSelector = $('#auth-response');
    var accessToken = accessTokenSelector.val();
    var actionType = accessTokenSelector.attr("data-type");
    var message = '';
    // console.log("runnng " + accessToken);
    // console.log("actionType " + actionType);

    if(accessTokenSelector.length === 1)
    {
        if(accessToken === 'success')
        {
            message = actionType + ' successfully connected.';

            //swal("", message, "success");

            swal({
                title: "",
                text: message,
                type: 'success',
            },function(){
                var uri = window.location.toString();
                if (uri.indexOf("?") > 0) {
                    var clean_uri = uri.substring(0, uri.indexOf("?"));
                    window.history.replaceState({}, document.title, clean_uri);
                }
            });


        }
        else
        {
            message = accessTokenSelector.attr("data-message");
            //swal("", message, "error");

            swal({
                title: "",
                text: message,
                type: 'error',
            },function(){
                var uri = window.location.toString();
                if (uri.indexOf("?") > 0) {
                    var clean_uri = uri.substring(0, uri.indexOf("?"));
                    window.history.replaceState({}, document.title, clean_uri);
                }
            });




        }
    }
}
