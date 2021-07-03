$(function () {
    $(document.body).on('submit', 'form.validate-me', function(e)
    {
        e.preventDefault();
        // console.log("call B");
        // console.log(e);

        // console.log("err");
        // console.log(errorFound);

        if (!errorFound) {
            // console.log("validation passed");

            var $this = $(".submit");
            $this.attr("disabled", true);
            var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> Login Processing...';

            if ($this.html() !== loadingText) {
                $this.data('original-text', $this.html());
                $this.html(loadingText);
            }

            login();
        }

    });

    $( "#forgot-pass" ).submit(function( event ) {
        event.preventDefault();
        // console.log($('input[name="_token"]').val());
        var email = $('#email').val();
        var siteUrl = $('#hfBaseUrl').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: siteUrl+ '/password/email',
            data: {
                'email': email
            }
        }).done(function (result) {
            // console.log(result);
            var json = $.parseJSON(result);
            var statusMessage = json.status_message;
            var alert = $(".response-message");
            alert.show();
            if (json.status_code == 302) {
                alert.html('<div class="alert alert-danger">'+statusMessage+'</div>');
            } else {
                alert.html('<div class="alert alert-success">'+statusMessage+'</div>');
            }
        });

        return false;
      });
      $( "#passwordUpdate" ).submit(function( event ) {
        event.preventDefault();
        // console.log($('input[name="_token"]').val());
        var token = $('#token').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        // console.log(token);
        // console.log(email);
        // console.log(password);
        // console.log(confirm_password);

        var siteUrl = $('#hfBaseUrl').val();
        if (password == confirm_password) {
            var alert = $(".response-message");
            alert.hide();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: siteUrl+ '/password/update',
                data: {
                    'token': token,
                    'email': email,
                    'password': password,
                }
            }).done(function (result) {
                // console.log(result);
                var json = $.parseJSON(result);
                var statusMessage = json.status_message;
                var alert = $(".response-message");
                alert.show();
                alert.html('<div class="alert alert-success">'+statusMessage+'</div>');
                var baseUrl = $('#hfBaseUrl').val();
                location.href = baseUrl+'/login';
            });
        } else {
            var alert = $(".response-message");
                alert.show();
                alert.html('<div class="alert alert-danger">Password and Confirm password not match.</div>');
        }


        return false;
      });
});
function login(email, password, source)
{
    var baseUrl = $('#hfBaseUrl').val();

    // console.log("emai; " + email);

    if(!email)
    {
        email = $("#email").val();
    }

    if(!password)
    {
        password = $("#password").val();
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + '/login',
        data: {
            email:email,
            password: password
        }
    }).done(function (result) {
        // parse data into json
        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;

        var alert = $(".response-message");
        alert.show();

        var $this = $(".submit");

        if(statusCode == 200)
        {
            if(source !== 'register')
            {
                alert.html('<div class="alert alert-success">'+statusMessage+'</div>');
            }

            location.href = baseUrl;
        }
        else if(statusCode == 403)
        {
            var registerUrl = baseUrl+'/register';
            var loginUrl = baseUrl+'/login';

            $this.attr("disabled", false);
            $this.html($this.data('original-text'));
            alert.html('<div class="alert alert-danger"> <div style="color: #000000;text-align: center;font-size: 16px;"> <p style="font-weight: 600;">Looks like your account is no longer active!</p> <div>Sign up for a new account, or <a href="javascript:void(0)" style="text-decoration: underline;color: #01a1fe;font-size: 16px;font-weight: 600;">contact us</a></div> </div> </div>');
        }
        else
        {
            $this.attr("disabled", false);
            $this.html($this.data('original-text'));
            alert.html('<div class="alert alert-danger">'+statusMessage+'<a href="'+baseUrl+'/admin-register"> <u>Sign up</u></a> </div>');
        }
    });
}
$(document).ajaxComplete(function myErrorHandler(event, xhr, ajaxOptions, thrownError) {
    // alert("Ajax request completed with response code " + xhr.status);
    // swal
    if(xhr.status == 419)
    {
        location.reload();
    }
});
