@extends('index')

@section('pageTitle', 'Login')

@section('content')
    <div class="container">
        <div class="wrapper login-page">
            <form method="post" role="form" class="form-signin validate-me">

                <div class="login-logo">
                    <img align="NichePractice" src="{{ asset('public/images/logo-register.png') }}" class="logo">
                </div>

                <div class="response-message" style="display: none;"></div>

                {{--<div class="form-group" style="margin-bottom: 10px;">--}}
                    {{--<label style="font-size: 16px;font-weight: 600;color: #403e3e;float: left;">Sign in</label>--}}
                    {{--<p style="float: right;color: #2db1fe;font-size: 15px;font-weight: 600;">or--}}
                        {{--<a href="{{ route('register') }}" style="color: #2db1fe;text-decoration: underline;">create an account</a>--}}
                    {{--</p>--}}
                {{--</div>--}}
                <div class="row" style="display: flex; align-items: center">
                    <div class="col-sm-4 text-left"><h2 style="font-weight: normal">Sign In</h2></div>
                    <div class="col-sm-8 text-right" style="display: none;">
                        <span style="color: #2db1fe;font-size: 15px;font-weight: 600;">or</span>
                        <a href="{{ route('register') }}" style="color: #2db1fe;text-decoration: underline;">create an account</a>
                    </div>
                </div>

                <div class="form-group putin active">
                    <input class="input-field form-control" type="text" id="email" data-required="true" />
                    <label class="input-label" for="email">
                        <span class="label-text">Email</span>
                    </label>
                    <span class="help-block hide-me"><small></small></span>
                </div>
                <div class="form-group putin active">
                    <input class="input-field form-control" type="password" id="password" data-required="true" />
                    <label class="input-label" for="password">
                        <span class="label-text">Password</span>
                    </label>
                    <span class="help-block hide-me"><small></small></span>
                </div>

                <button class="btn btn-lg btn-login btn-block submit" name="Submit" value="Login" type="Submit">Login</button>

                <div class="forgot-container">
                    <a href="{{ route('forgot-password') }}">Forget password?</a>
                </div>

{{--                <button class="abc">HI Test me</button>--}}

{{--                <div id="paypal-button-container"></div>--}}
{{--                <script src="https://www.paypal.com/sdk/js?client-id=AWHO7ZbEXsN4m6vgS21yHv-EbLtEtbyCivZVO1-zHoJvU9CHvvA4aPpe_IdVidj8XEIV8HpcrEJ2F96g&currency=USD" data-sdk-integration-source="button-factory"></script>--}}

                <script>
                        // paypal.Buttons({
                        //     style: {
                        //         shape: 'pill',
                        //         color: 'gold',
                        //         layout: 'vertical',
                        //         label: 'paypal',
                        //
                        //     },
                        //     createOrder: function(data, actions) {
                        //         return actions.order.create({
                        //             purchase_units: [{
                        //                 amount: {
                        //                     value: '1'
                        //                 }
                        //             }]
                        //         });
                        //     },
                        //     onApprove: function(data, actions) {
                        //         return actions.order.capture().then(function(details) {
                        //             alert('Transaction completed by ' + details.payer.name.given_name + '!');
                        //         });
                        //     }
                        // }).render('#paypal-button-container');
                </script>
                <script>
                    // function renderMe() {
                    //     paypal.Buttons({
                    //         style: {
                    //             shape: 'pill',
                    //             color: 'gold',
                    //             layout: 'vertical',
                    //             label: 'paypal',
                    //
                    //         },
                    //         createOrder: function(data, actions) {
                    //             return actions.order.create({
                    //                 purchase_units: [{
                    //                     amount: {
                    //                         value: '1'
                    //                     }
                    //                 }]
                    //             });
                    //         },
                    //         onApprove: function(data, actions) {
                    //             return actions.order.capture().then(function(details) {
                    //                 alert('Transaction completed by ' + details.payer.name.given_name + '!');
                    //             });
                    //         }
                    //     }).render('#paypal-button-container');
                    // }
                </script>
            </form>
        </div>
    </div>

    <input type="hidden" id="currentPage" value="login" />
@endsection

@section('css')

@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/js/login.js?ver='.$appFileVersion) }}"></script>
    <script>
        $(function () {
            $('input.input-field').each(function(e){
                // console.log("each");
                // console.log($(this).val());
                if( $(this).val() !== '' ) {
                    $(this).parent().addClass('active')
                }
                $(this).on('focus', focus);
                $(this).on('blur', blur);
            });
        });



        // $(".abc").click(function () {
        //     var script = document.createElement("script");
        //     script.setAttribute("src", 'https://www.paypal.com/sdk/js?client-id=AWHO7ZbEXsN4m6vgS21yHv-EbLtEtbyCivZVO1-zHoJvU9CHvvA4aPpe_IdVidj8XEIV8HpcrEJ2F96g&currency=USD');
        //     script.setAttribute("data-sdk-integration-source", "button-factory");
        //     var head = document.head;
        //     head.insertBefore(script, head.firstChild);
        //
        //     setTimeout(function () {
        //         console.log("hi");
        //         renderMe();
        //     },500);
        // });

        //     window.onload = function() {
        //     // $(this).click();
        //         setTimeout(function () {
        //             $('input.input-field').each(function(e){
        //                 console.log("each");
        //                 console.log($(this).val());
        //                 if( $(this).val() !== '' ) {
        //                     $(this).parent().addClass('active')
        //                 }
        //                 $(this).on('focus', focus);
        //                 $(this).on('blur', blur);
        //             });
        //         },500);
        // };

        function focus(e) {
            $(this).parent().addClass('active')
        }
        function blur(e) {
            if( e.target.value.trim() === '' ) {
                $(this).parent().removeClass('active')
            }
        }
        // $('input.input-field').bind('change', function(){
        //     // $('input.input-field').each(function(e){
        //         if( $(this).val() !== '' ) {
        //             $(this).parent().addClass('active')
        //         }
        //         $(this).on('focus', focus);
        //         $(this).on('blur', blur);
        //     // });
        // });
        // (function(){
        //     $('input.input-field').each(function(e){
        //         if( $(this).val() !== '' ) {
        //             $(this).parent().addClass('active')
        //         }
        //         $(this).on('focus', focus);
        //         $(this).on('blur', blur);
        //     });
        //     function focus(e) {
        //         $(this).parent().addClass('active')
        //     }
        //     function blur(e) {
        //         if( e.target.value.trim() === '' ) {
        //             $(this).parent().removeClass('active')
        //         }
        //     }
        // })();
    //
    //     $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
    //         if ( options.dataType == 'script' || originalOptions.dataType == 'script' ) {
    //             options.cache = true;
    //         }
    //     });
    //
    //     var strTest = '<div id="paypal-button-container"></div>\n' +
    //         '<script src="https://www.paypal.com/sdk/js?client-id=AWHO7ZbEXsN4m6vgS21yHv-EbLtEtbyCivZVO1-zHoJvU9CHvvA4aPpe_IdVidj8XEIV8HpcrEJ2F96g&currency=USD" data-sdk-integration-source="button-factory"><\/script>\n'+
    // ' <script>'+
    //     '  paypal.Buttons({\n' +
    //     '      style: {\n' +
    //     '          shape: \'pill\',\n' +
    //     '          color: \'gold\',\n' +
    //     '          layout: \'vertical\',\n' +
    //     '          label: \'paypal\',\n' +
    //     '          \n' +
    //     '      },\n' +
    //     '      createOrder: function(data, actions) {\n' +
    //     '          return actions.order.create({\n' +
    //     '              purchase_units: [{\n' +
    //     '                  amount: {\n' +
    //     '                      value: \'1\'\n' +
    //     '                  }\n' +
    //     '              }]\n' +
    //     '          });\n' +
    //     '      },\n' +
    //     '      onApprove: function(data, actions) {\n' +
    //     '          return actions.order.capture().then(function(details) {\n' +
    //     '              alert(\'Transaction completed by \' + details.payer.name.given_name + \'!\');\n' +
    //     '          });\n' +
    //     '      }\n' +
    //     '  }).render(\'#paypal-button-container\');\n' +
    //     '<\/script>';



    //     var strTest = '<div id="paypal-button-container"></div>\n' +
    // ' <script>\n'+
    //     '  paypal.Buttons({\n' +
    //     '<\/script>';

        // var str2 = '<div id="paypal-button-container"></div>\n' +
        //     '<script src="https://www.paypal.com/sdk/js?client-id=AWHO7ZbEXsN4m6vgS21yHv-EbLtEtbyCivZVO1-zHoJvU9CHvvA4aPpe_IdVidj8XEIV8HpcrEJ2F96g&currency=USD" data-sdk-integration-source="button-factory"><\/script>';
        //
        // var str = '<div id="paypal-button-container"></div>\n' +
        //     '<script src="https://www.paypal.com/sdk/js?client-id=AWHO7ZbEXsN4m6vgS21yHv-EbLtEtbyCivZVO1-zHoJvU9CHvvA4aPpe_IdVidj8XEIV8HpcrEJ2F96g&currency=USD" data-sdk-integration-source="button-factory"><\/script>\n' +
        //     '<script>\n' +
        //     'alert("hi");' +
        //     '<\/script>';
        //
        // console.log("parse");
        // // console.log($.parseJSON(strTest));
        // str = strTest.replace(/\n/g, '');
        // str2 = str.replace(/<script>.*?<\/script>/g, '');
        // // str = str.replace(/<script>\n.*?<\/script>/g, '');
        //
        //
        // console.log("check ");
        // console.log(str2);


        // strTest = strTest.replace(/<script>.*?<\/script>/g, '');
        //
        // console.log("str");
        // console.log(strTest);

        // var str = 'abc:def <script src="abc"><\/script> ge kk ' +
        //     '<script>' +
        //     'alert("hi");<\/script>';
        //     str = str.replace(/<script>.*?<\/script>/g, '');
        // console.log(str);




    //     $("form").html(str2);
    //
    // var modifiedScript = strTest.split('<script>').pop().split('<\/script>')[0];
    //
    // console.log("modifiedScript the things");
    // console.log(modifiedScript);
    //
    //     setTimeout(function () {
    //         console.log("inside");
    //         $("form").append('<script>'+modifiedScript.replace(/\"/g, "")+'<\/script>');
    //     },1000);
    //
    //
    //     str = strTest.replace(/\n/g, '');
    //     str2 = str.replace(/<script>.*?<\/script>/g, '');
    //     console.log("check ");
    //     console.log(str2);
    //     $("form").html(str2);
    //
    //     var modifiedScript = strTest.split('<script>').pop().split('<\/script>')[0];
    //
    //     console.log("modifiedScript the things");
    //     console.log(modifiedScript);
    //
    //     setTimeout(function () {
    //         console.log("inside");
    //         $("form").append('<script>'+modifiedScript.replace(/\"/g, "")+'<\/script>');
    //     },1000);


{{--        $("form").html('<div id="paypal-button-container"></div>\n' +--}}
{{--            '<script src="https://www.paypal.com/sdk/js?client-id=AWHO7ZbEXsN4m6vgS21yHv-EbLtEtbyCivZVO1-zHoJvU9CHvvA4aPpe_IdVidj8XEIV8HpcrEJ2F96g&currency=USD" data-sdk-integration-source="button-factory"><\/script>' +--}}
{{--            '<script>\n' +--}}
{{--            '  paypal.Buttons({\n' +--}}
{{--            '      style: {\n' +--}}
{{--            '          shape: \'pill\',\n' +--}}
{{--            '          color: \'gold\',\n' +--}}
{{--            '          layout: \'vertical\',\n' +--}}
{{--            '          label: \'paypal\',\n' +--}}
{{--            '          \n' +--}}
{{--            '      },\n' +--}}
{{--            '      createOrder: function(data, actions) {\n' +--}}
{{--            '          return actions.order.create({\n' +--}}
{{--            '              purchase_units: [{\n' +--}}
{{--            '                  amount: {\n' +--}}
{{--            '                      value: \'1\'\n' +--}}
{{--            '                  }\n' +--}}
{{--            '              }]\n' +--}}
{{--            '          });\n' +--}}
{{--            '      },\n' +--}}
{{--            '      onApprove: function(data, actions) {\n' +--}}
{{--            '          return actions.order.capture().then(function(details) {\n' +--}}
{{--            '              alert(\'Transaction completed by \' + details.payer.name.given_name + \'!\');\n' +--}}
{{--            '          });\n' +--}}
{{--            '      }\n' +--}}
{{--            '  }).render(\'#paypal-button-container\');\n' +--}}
{{--            '<\/script>');--}}

{{--    // $("form").html($.getScript("http://ajax/test.js", function(data, textStatus, jqxhr) {--}}
{{--    //     console.log(data); //data returned--}}
{{--    //     console.log(textStatus); //success--}}
{{--    //     console.log(jqxhr.status); //200--}}
{{--    //     console.log('Load was performed.');--}}
{{--    // }));--}}

{{--     $("form").html('<script src="https://www.paypal.com/sdk/js?client-id=AWHO7ZbEXsN4m6vgS21yHv-EbLtEtbyCivZVO1-zHoJvU9CHvvA4aPpe_IdVidj8XEIV8HpcrEJ2F96g&currency=USD"><\/script>');--}}

    {{--    <script src="https://www.paypal.com/sdk/js?client-id=AWHO7ZbEXsN4m6vgS21yHv-EbLtEtbyCivZVO1-zHoJvU9CHvvA4aPpe_IdVidj8XEIV8HpcrEJ2F96g&currency=USD" data-sdk-integration-source="button-factory"></script>--}}


    </script>
@endsection
