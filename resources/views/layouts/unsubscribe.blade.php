<!DOCTYPE html>
<html lang="en">
<head>
    <title>Unsubscribe</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link type="text/css" href="{{ asset('public/font-awesome/4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" />
    <style>
        body{
            background: #E8E8E8;
        }
        .unsub-message{
            margin-top: 90px;
            margin-bottom: 90px;
            font-size: 30px;
        }
    </style>
</head>
<body>

@if(empty($unsubscriptionStatus))
<div class="container py-3" style="max-width: 60%; background-color: white; margin-top: 100px;">

{{--    <header class="text-center my-4">--}}
        @if(!empty($logo))
            <?php
//            $logoUrl = url('storage/app/'.$logo);
            ?>
{{--            <img src="{{ $logoUrl }}" alt="" style="max-width: 215px;">--}}
        @else
{{--            <h3 class="mb-4">{{ $name }}</h3>--}}
        @endif
{{--    </header>--}}

    <div class="row">
        <div class="col-sm-12">
            <h3 class="mb-4 text-center" style="font-weight: 400;">Unsubscribe from messages</h3>
            <p class="text-center">Are you sure you want to unsubscribe from <b>{{ $name }}</b></p>
            <p class="m-0 text-center"><label for="email" style="font-weight: bold">Email Address</label></p>
            <div class="text-center d-flex justify-content-center">
                <input type="email" id="email" class="form-control" value="{{ $email }}" placeholder="Enter Your Email" readonly style="width: 250px; border: 0; border-radius: 0; background-color: #F7F7F7; text-align: center;" />
            </div>
            <span class="error-missing" style="color: red;font-size: 14px;padding-bottom: 10px;display: none;float: left;width: 100%;">Email missing. Please check your unsubscribe link in your inbox.</span>
{{--            <p>If this isn't your email address you haven't been added to any lists and there is no need to unsubscribe.</p>--}}
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary unsubscribe-me mt-3" style="width: 200px; border: 0; border-radius: 0;">Unsubscribe</button>
            </div>
                {{--            <p><small>Note: In each email you receive, there will be a link to unsubscribe or change areas of interest.</small></p>--}}

            <input type="hidden" id="identifier" value="{{ $businessId }}" />
            <input type="hidden" id="refer" value="{{ $refer }}" />
            <input type="hidden" id="referSource" value="{{ !empty($referSource) ? $referSource : '' }}" />
        </div>
        <div style="margin-left: 17px;" class="text-center alert-manager"></div>
    </div>
</div>

<input type="hidden" id="hfBaseUrl" value="{{ URL('/') }}" />
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
@else
    <div class="container py-3" style="max-width: 60%; background-color: white; margin-top: 100px;">



        <div class="row">
            <div class="col-sm-12">

                <p class="text-center unsub-message">You have successfully unsubscribed.</p>
            </div>

        </div>
    </div>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

@if(empty($unsubscriptionStatus))
<script>
    $(".unsubscribe-me").click(function () {
        var siteUrl = $('#hfBaseUrl').val();

        var identifier = $("#identifier").val();
        var email = $("#email").val();
        var refer = $("#refer").val();
        var referSource = $("#referSource").val();

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
                identifier: identifier,
                referSource: referSource
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
                location.reload();
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
@endif
</body>
</html>
