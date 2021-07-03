<!DOCTYPE html>
<html lang="en">
<head>
    <title>Unsubscribe</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link type="text/css" href="{{ asset('public/font-awesome/4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" />
    <style>
        @media screen and (max-width: 480px){
            .unsubemail{
                font-size: 17px !important;
            }
            .unsubtitle{
                font-size: 52px !important;
            }
        }
        @media screen and (max-width: 320px) {
            .unsubtitle {
                font-size: 35px !important;
            }
        }

    </style>
</head>
<body style="background: white;">


<div class="container py-5" style="max-width: 590px;">
    <div class="row">
        <div class="col-sm-12" style="border: 1px solid red; padding: 45px; ">
            <h3 class="mb-4 text-center unsubtitle"  style="font-size: 56px;">We're sorry to see you go.<img src="{{ asset('public/images/sademoji.png') }}" style="width: 50px; margin-left: 10px;">
            </h3>
            <div class="text-center border" style="padding: 30px 0px 30px 0px; margin-top: 70px; border-radius: 7px;">
                <p style="margin-bottom: 5px;">Your email address: <b>{{ $name }}</b></p>
                <h3 class="unsubemail" style="margin-bottom: 15px;">steven@gmail.com</h3>
                <span class="error-missing" style="color: red;font-size: 14px;padding-bottom: 10px;display: none;float: left;width: 100%;">Email missing. Please check your unsubscribe link in your inbox.</span>
                <p style="margin: 0px !important;">has been <strong> successfully unsubscribed</strong> from the </br> email list.</p>
                <p style="margin: 0px !important;">We'll miss you</p>
            </div>
            <p class="text-center" style="margin-top: 10px;" >Powered by:<img src="{{ asset('public/images/logo-register.png') }}" style="width: 90px; margin-left: 10px;"></p>


            <input type="hidden" id="identifier" value="{{ $businessId }}" />
            <input type="hidden" id="refer" value="{{ $refer }}" />
        </div>
        <div style="margin-left: 17px;" class="text-center alert-manager"></div>
    </div>
</div>

<input type="hidden" id="hfBaseUrl" value="{{ URL('/') }}" />
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<script>
    $(".unsubscribe-me").click(function () {
        var siteUrl = $('#hfBaseUrl').val();

        var identifier = $("#identifier").val();
        var email = $("#email").val();
        var refer = $("#refer").val();

        var alertManager = $(".alert-manager");
        alertManager.hide();
        alertManager.removeClass("text-success text-danger");

        if(email == '')
        {
            $(".error-missing").show();
            return false;
        }

        $(".error-missing").hide();
        // console.log(template);

        var $this = $(".unsubscribe-me");
        $this.attr("disabled", true);
        var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> Processing...';

        if ($this.html() !== loadingText) {
            $this.data('original-text', $this.html());
            $this.html(loadingText);
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: siteUrl + "/done-me",
            data: {
                send: 'unsubscribe-me',
                email: email,
                refer: refer,
                identifier: identifier
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

            $this.attr("disabled", false);
            $this.html($this.data('original-text'));

            alertManager.show();
            alertManager.html(statusMessage);

            if(statusCode == 200)
            {
                alertManager.addClass("text-success");
            }
            else
            {
                alertManager.addClass("text-danger");
            }
        }).fail(function () {
            $this.attr("disabled", false);
            $this.html($this.data('original-text'));

            alertManager.show();
            alertManager.addClass("text-danger");
            alertManager.html("Please try again later.");
        });
    });
</script>


</body>
</html>
