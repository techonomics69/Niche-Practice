'use strict';

// var stripe = Stripe(stripeKey);
// console.log("ley " + stripeKey);
var stripe = Stripe(stripeKey);

function ValidateEmail(mail) {
    if (/\S+@\S+\.\S+/.test(mail))
    {
        return true;
    }
    else{
        return false;
    }
}

function registerElements(elements, exampleName) {
    var formClass = '.' + exampleName;
    var example = document.querySelector(formClass);
    var form = example.querySelector('form');

    var resetButton = example.querySelector('a.reset');
    var error = form.querySelector('.error');
    var errorMessage = error.querySelector('.message');

    function enableInputs() {
        Array.prototype.forEach.call(
            form.querySelectorAll(
                "input[type='text'], input[type='email'], input[type='tel'], input[type='password']"
            ),
            function(input) {
                input.removeAttribute('disabled');
            }
        );
        elements[0].update({ disabled: false });
        elements[1].update({ disabled: false });
        elements[2].update({ disabled: false });
    }

    function disableInputs() {
        Array.prototype.forEach.call(
            form.querySelectorAll(
                "input[type='text'], input[type='email'], input[type='tel'], input[type='password']"
            ),
            function(input) {
                input.setAttribute('disabled', 'true');
            }
        );
        elements[0].update({ disabled: true });
        elements[1].update({ disabled: true });
        elements[2].update({ disabled: true });
    }

    function triggerBrowserValidation() {
        // The only way to trigger HTML5 form validation UI is to fake a user submit
        // event.
        var submit = document.createElement('input');
        submit.type = 'submit';
        submit.style.display = 'none';
        form.appendChild(submit);
        submit.click();
        submit.remove();
    }

    // Listen for errors from each Element, and show error messages in the UI.
    var savedErrors = {};
    elements.forEach(function(element, idx) {
        element.on('change', function(event) {
            if (event.error) {
                var errorCode=event.error.code;
                var errorMsg=event.error.message;

                if(errorCode=='incomplete_number' || errorCode=='invalid_number' || errorCode=='incorrect_number'){
                    var spanEl=$('#credit_card_number_error');
                    spanEl.removeClass('hide-me').addClass('errorMsg');
                    $("small", spanEl).html(errorMsg);
                }
                else if(errorCode=='incomplete_expiry' || errorCode=='invalid_expiry_year_past'  || errorCode=='invalid_expiry_year'){
                    var spanEl=$('#credit_card_expiry_date_error');
                    spanEl.removeClass('hide-me').addClass('errorMsg');
                    $("small", spanEl).html(errorMsg);
                }
                else if(errorCode=='incomplete_cvc'){
                    var spanEl=$('#credit_card_cvc_error');
                    spanEl.removeClass('hide-me').addClass('errorMsg');
                    $("small", spanEl).html(errorMsg);
                }
            }
            else {
                if (event.elementType=='cardNumber'){
                    var spanEl1=$('#credit_card_number_error');
                    spanEl1.addClass('hide-me').removeClass('errorMsg');
                    $("small", spanEl1).text('');
                }
                if (event.elementType=='cardExpiry'){
                    var spanEl2=$('#credit_card_expiry_date_error');
                    spanEl2.addClass('hide-me').removeClass('errorMsg');
                    $("small", spanEl2).text('');
                }
                if (event.elementType=='cardCvc'){
                    var spanEl3=$('#credit_card_cvc_error');
                    spanEl3.addClass('hide-me').removeClass('errorMsg');
                    $("small", spanEl3).text('');
                }
            }
        });
    });

    // Listen on the form's 'submit' handler...
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        $('span.help-block small').text('');
        $('span.help-block').closest('.form-group').removeClass('has-error');
        $('span.help-block').addClass('hide-me').removeClass('errorMsg');


        Array.prototype.forEach.call(
            form.querySelectorAll(
                "input[type='text'], input[type='email'], input[type='password']"
            ),
            function(input) {
                // console.log("input");
                // console.log(input);

                // console.log("input 2");
                // console.log($(input).attr("id"));

                var spanEl=$(input).next("span");

                if($(input).val()==''){
                    spanEl.removeClass('hide-me').addClass('errorMsg');
                    $(input).closest('.form-group').addClass('has-error');
                    $("small", spanEl).html("Required Field");
                }
                else if($(input).val() !== '' && $(input).val().length < 8 && $(input).attr("id") === 'password'){
                    spanEl.removeClass('hide-me').addClass('errorMsg');
                    $(input).closest('.form-group').addClass('has-error');
                    $("small", spanEl).html("Minimum 8 characters");
                }
                else{
                    if($(input).attr('type')=='email'){
                        var email=$(input).val();
                        var validEmailCheck=ValidateEmail(email);
                        if(validEmailCheck==false){
                            spanEl.removeClass('hide-me').addClass('errorMsg');
                            $(input).closest('.form-group').addClass('has-error');
                            $("small", spanEl).html("Enter Valid Email");
                        }
                    }
                }
            }
        );

        //Trigger HTML5 validation UI on the form if any of the inputs fail validation.

        var plainInputsValid = true;
        Array.prototype.forEach.call(form.querySelectorAll('input'), function(input) {
            // console.log("new");
            // console.log(input);
            // console.log("Here Input");
            // console.log($(input).attr("id"));
            if (input.checkValidity && !input.checkValidity()) {
                plainInputsValid = false;
                return;
            }
            else if($(input).val().length < 8 && $(input).attr("id") === 'password' )
            {
                plainInputsValid = false;
                return;
            }

        });
        // console.log("plainInputsValid");
        // console.log(plainInputsValid);

        if (!plainInputsValid) {
            triggerBrowserValidation();
            return;
        }



        // Show a loading screen...
        example.classList.add('submitting');

        // Disable all inputs.
        disableInputs();

        // Gather additional customer data we may have collected in our form.
        var name_on_credit_card = form.querySelector('#name_on_credit_card');
        var additionalData = {
            name: name_on_credit_card ? name_on_credit_card.value : undefined
        };
        var selected_strategy = $('input[name="exampleRadios"]:checked').val();
        var business_name=$('#business_name').val();
        var first_name_val=$('#first_name').val();
        var last_name_val=$('#last_name').val();
        var phone_number=$('#phone_number').val();
        var email_val=$('#email').val();
        var password_val=$('#password').val();
        var name_on_credit_card_val=$('#name_on_credit_card').val();

        // var name_on_credit_card_val=$('#name_on_credit_card').val();
        var couponCode = $(".coupon-code-section").attr("data-coupon");
        var amount = $(".final-amount").attr("data-amount");
        var packageAmount = $(".total-amount").attr("data-amount");
        // var selectedPackage = $(".selected-package").attr("data-package");

        // var selectedPackage = $(".choose-plan-list li.active .btn-package-select").attr("data-package");
        var selectedPackage = $("#selectedPackage").val();

        var zipCode = $("#zip_code").val();

        var durationInMonths = $(".coupon-code-section").attr("data-duration_in_months");

        // Use Stripe.js to create a token. We only need to pass in one Element
        // from the Element group in order to create a token. We can also pass
        // in the additional customer data we collected in our form.

        $('#subscribe_now_button').button('loading');
        showPreloader();

        var card_details={};

        stripe.createToken(elements[0], additionalData).then(function(result) {
            // console.log(result);
            //console.log(additionalData);

            var errorElement = document.querySelector('.error');
            errorElement.classList.remove('visible');
            var errorMessage = errorElement.querySelector('.message');

            if (result.token) {
                var token=result.token;
                var token_id=token.id;
                var brand=token.card.brand;
                var last4=token.card.last4;
                var exp_month=token.card.exp_month;
                var exp_year=token.card.exp_year;
                var name_on_card=token.card.name;

                card_details = {
                    'token_id':token_id,
                    'brand': brand,
                    'last4': last4,
                    'exp_month': exp_month,
                    'exp_year': exp_year,
                    'name_on_card': name_on_card,
                    'business_name': business_name,
                    'FirstName': first_name_val,
                    'LastName': last_name_val,
                    'phone_number': phone_number,
                    'Email': email_val,
                    'Password': password_val,
                    'Amount': amount,
                    'packageAmount': packageAmount,
                    'CouponCode': couponCode,
                    'SubscriptionID': selectedPackage,
                    'durationInMonths': durationInMonths,
                    'zipCode': zipCode,
                    'selected_strategy' : selected_strategy,
                    send: 'billing-make-payment'
                };

                window.localStorage.setItem("card_details", JSON.stringify(card_details));
                // console.log(window.localStorage.getItem("card_details"));

                makePayment(card_details);

                // setTimeout(function(){
                //
                // }, 500);

                //registerUser(first_name_val,last_name_val,email_val,password_val,card_details);
            }
            else if (result.error) {
                var errorCode=result.error.code;
                var errorMsg=result.error.message;

                if(errorCode=='incomplete_number' || errorCode=='invalid_number' || errorCode=='incorrect_number'){
                    var spanEl=$('#credit_card_number_error');
                    spanEl.removeClass('hide-me').addClass('errorMsg');
                    $("small", spanEl).html(errorMsg);
                }
                else if(errorCode=='incomplete_expiry' || errorCode=='invalid_expiry_year_past' || errorCode=='invalid_expiry_year'){
                    var spanEl=$('#credit_card_expiry_date_error');
                    spanEl.removeClass('hide-me').addClass('errorMsg');
                    $("small", spanEl).html(errorMsg);
                }
                else if(errorCode=='incomplete_cvc'){
                    var spanEl=$('#credit_card_cvc_error');
                    spanEl.removeClass('hide-me').addClass('errorMsg');
                    $("small", spanEl).html(errorMsg);
                }
                else if(errorCode=='card_declined'){
                    errorMessage.innerText = result.error.message;
                    errorElement.classList.add('visible');
                }
                else{
                    errorMessage.innerText = result.error.message;
                    errorElement.classList.add('visible');
                }

                enableInputs();
                example.classList.remove('submitting');
                $('#subscribe_now_button').button('reset');
                hidePreloader();
            }
            else {
                // Otherwise, un-disable inputs.
                enableInputs();
                example.classList.remove('submitting');
                $('#subscribe_now_button').button('reset');
                hidePreloader();

            }
        });
    });

    function makePayment(card_details)
    {
        // console.log('card_details');
        // console.log(card_details.selected_strategy);
        // if( card_details.selected_strategy == 'option2' ){
        //     $('#modal-campaign').modal('show');
        // }
        // return;
        localStorage.removeItem('card_details');
        // console.log(window.localStorage.getItem("card_details"));

        var baseUrl = $('#hfBaseUrl').val();

        $('span.help-block small').text('');
        $('span.help-block').closest('.form-group').removeClass('has-error');
        $('span.help-block').addClass('hide-me').removeClass('errorMsg');

        var errorElement = document.querySelector('.error');
        errorElement.classList.remove('visible');
        var errorMessage = errorElement.querySelector('.message');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url:  baseUrl + "/done-me",
            data: card_details,
            success: function (response, status) {
                // console.log(response);
                var statusCode = response._metadata.outcomeCode;
                var statusMessage = response._metadata.outcome;
                var errors = response.errors;
                var message = response._metadata.message;
                var baseUrl = $('#hfBaseUrl').val();
                // console.log(message);

                if(statusCode==200){
                    window.localStorage.setItem("card_details", JSON.stringify(card_details));
                    // console.log(window.localStorage.getItem("card_details"));

                    setTimeout(function(){
                        // location.href = baseUrl+'/confirm-payment';
                        var baseUrl = $('#hfBaseUrl').val();

                        swal({
                            title: "Successful!",
                            text: 'Payment Successful.',
                            type: "success",
                            allowEscapeKey : false,
                            allowOutsideClick: false
                        }, function () {
                            location.href = baseUrl + '/campaigns-library';
                            // if( card_details.selected_strategy == 'option1' ){
                            //     // hidePreloader();
                            //     // console.log("option 1");
                            //     // $('#modal-campaign-package1').modal('show');
                            //     location.href = baseUrl + '/task-list?user=subcribed';
                            //     // console.log('i am one that pinged');
                            //
                            //
                            //
                            //     // $(document).ready(function () {
                            //     //     console.log('i am 2 that pinged');
                            //     //     $('#modal-campaign-package1').modal('show');
                            //     //     setTimeout(function () {
                            //     //         console.log('i am three that pinged');
                            //     //         $('#modal-campaign-package1').modal('show');
                            //     //     }, 10000);
                            //     // });
                            // }
                            // if( card_details.selected_strategy == 'option2' ){
                            //     // console.log("option 2");
                            //     hidePreloader();
                            //     $('#modal-campaign-package2').modal('show');
                            // }
                            // else{
                            //     console.log("option 3");
                            //     location.href = baseUrl + '/campaigns-library';
                            // }
                        });
                        // return false;
                    }, 500);
                }
                else{
                    var checkFieldsErrors=errors.length;
                    // console.log(checkFieldsErrors);

                    if(checkFieldsErrors!=0){
                        $('html, body').animate({ scrollTop: 0 }, 'fast');

                        if(errors && errors != '')
                        {
                            $.each(errors, function (index, value) {
                                var errorSelector = $("#"+value.map).next("span");
                                errorSelector.removeClass('hide-me');
                                $("#"+value.map).closest('.form-group').addClass('has-error');
                                errorSelector.addClass('errorMsg');
                                $("small", errorSelector).html(value.message);
                            })
                        }
                    }
                    else{
                        errorMessage.innerText = message;
                        errorElement.classList.add('visible');
                    }

                    hidePreloader();
                }
                enableInputs();
                example.classList.remove('submitting');
                $('#subscribe_now_button').button('reset');
            },
            error: function (data, status) {
                errorMessage.innerText = 'OOPs! Something went wrong...';
                errorElement.classList.add('visible');
                enableInputs();
                example.classList.remove('submitting');
                $('#subscribe_now_button').button('reset');
                hidePreloader();
            }
        })
    }


    function registerUser(firstName,LastName,Email,Password,card_details){

        localStorage.removeItem('card_details');
        // console.log(window.localStorage.getItem("card_details"));

        var baseUrl = $('#hfBaseUrl').val();

        $('span.help-block small').text('');
        $('span.help-block').closest('.form-group').removeClass('has-error');
        $('span.help-block').addClass('hide-me').removeClass('errorMsg');

        var errorElement = document.querySelector('.error');
        errorElement.classList.remove('visible');
        var errorMessage = errorElement.querySelector('.message');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url:  baseUrl + "/registerPaidUser",
            data: {
                first_name: firstName,
                last_name: LastName,
                email: Email,
                password: Password,
                password_confirmation: Password
            },
            success: function (response, status) {
                // console.log(response);
                var statusCode = response._metadata.outcomeCode;
                var statusMessage = response._metadata.outcome;
                var errors = response.errors;
                var message = response._metadata.message;
                var baseUrl = $('#hfBaseUrl').val();
                // console.log(message);

                if(statusCode==200){
                    window.localStorage.setItem("card_details", JSON.stringify(card_details));
                    // console.log(window.localStorage.getItem("card_details"));

                    setTimeout(function(){
                        location.href = baseUrl+'/confirm-payment';
                        return false;
                    }, 500);
                }
                else{
                    var checkFieldsErrors=errors.length;
                    // console.log(checkFieldsErrors);
                    if(checkFieldsErrors!=0){
                        $('html, body').animate({ scrollTop: 0 }, 'fast');

                        if(errors && errors != '')
                        {
                            $.each(errors, function (index, value) {
                                var errorSelector = $("#"+value.map).next("span");
                                errorSelector.removeClass('hide-me');
                                $("#"+value.map).closest('.form-group').addClass('has-error');
                                errorSelector.addClass('errorMsg');
                                $("small", errorSelector).html(value.message);
                            })
                        }
                    }
                    else{
                        errorMessage.innerText = message;
                        errorElement.classList.add('visible');
                    }
                }
                enableInputs();
                example.classList.remove('submitting');
                $('#subscribe_now_button').button('reset');
            },
            error: function (data, status) {
                errorMessage.innerText = 'OOPs! Something went wrong...';
                errorElement.classList.add('visible');
                enableInputs();
                example.classList.remove('submitting');
                $('#subscribe_now_button').button('reset');
            }
        })
    }

    $("form input[type='text'], form input[type='email'], form input[type='password']").on('blur keyup', function(){
        var input=$(this);
        var spanEl=input.next("span");
        if(input.val()==''){
            spanEl.removeClass('hide-me').addClass('errorMsg');
            input.closest('.form-group').addClass('has-error');
            $("small", spanEl).html("Required Field");
        }
        else if(input.val() !== '' && input.val().length < 8 && input.attr("id") === 'password'){
            spanEl.removeClass('hide-me').addClass('errorMsg');
            input.closest('.form-group').addClass('has-error');
            $("small", spanEl).html("Minimum 8 characters");
        }
        else{
            if(input.attr('type')=='email'){
                var email=input.val();
                var validEmailCheck=ValidateEmail(email);
                if(validEmailCheck==false){
                    spanEl.removeClass('hide-me').addClass('errorMsg');
                    input.closest('.form-group').addClass('has-error');
                    $("small", spanEl).html("Enter Valid Email");
                }
                else{
                    spanEl.addClass('hide-me').removeClass('errorMsg');
                    input.closest('.form-group').removeClass('has-error');
                    $("small", spanEl).text("");
                }
            }
            else{
                spanEl.addClass('hide-me').removeClass('errorMsg');
                input.closest('.form-group').removeClass('has-error');
                $("small", spanEl).text("");
            }
        }
    });
}




