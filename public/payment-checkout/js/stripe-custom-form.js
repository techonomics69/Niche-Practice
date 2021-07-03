function getNextMonth(duration_in_months){
    // console.log(duration_in_months);
    var nextMonth='';
    if(duration_in_months==null){
        nextMonth='second';
    }
    else if(duration_in_months!=null){
        if(duration_in_months==1){
            nextMonth='second';
        }
        else if(duration_in_months==2){
            nextMonth='third';
        }
        else if(duration_in_months==3){
            nextMonth='fourth';
        }
        else if(duration_in_months==4){
            nextMonth='fiveth';
        }
        else if(duration_in_months==5){
            nextMonth='sixth';
        }
        else if(duration_in_months==6){
            nextMonth='seventh';
        }
        else if(duration_in_months==7){
            nextMonth='eighth';
        }
        else if(duration_in_months==8){
            nextMonth='nineth';
        }
        else if(duration_in_months==9){
            nextMonth='tenth';
        }
        else if(duration_in_months==10){
            nextMonth='eleventh';
        }
        else if(duration_in_months==11){
            nextMonth='twelveth';
        }
        else if(duration_in_months==12){
            nextMonth='thirteenth';
        }
        else{
            nextMonth= duration_in_months+1;
        }
    }
    return nextMonth;
}

(function() {
    'use strict';

    var elements = stripe.elements({
        fonts: [
            {
                cssSrc: 'https://fonts.googleapis.com/css?family=Source+Code+Pro',
            },
        ],
        // Stripe's examples are localized to specific languages, but if
        // you wish to have Elements automatically detect your user's locale,
        // use `locale: 'auto'` instead.
        locale: window.__exampleLocale
    });

    // Floating labels
    var inputs = document.querySelectorAll('.example.example2 .input');
    Array.prototype.forEach.call(inputs, function(input) {
        input.addEventListener('focus', function() {
            input.classList.add('focused');
        });
        input.addEventListener('blur', function() {
            input.classList.remove('focused');
        });
        input.addEventListener('keyup', function() {
            if (input.value.length === 0) {
                input.classList.add('empty');
            } else {
                input.classList.remove('empty');
            }
        });
    });

    var elementStyles = {
        base: {
            iconColor: '#666EE8',
            color: '#32325D',
            fontWeight: 400,
            fontFamily: 'Open Sans, sans-serif',
            fontSize: '14px',
            fontSmoothing: 'antialiased',

            '::placeholder': {
                color: '#CFD7DF'
            },
            ':-webkit-autofill': {
                color: '#e39f48'
            }
        },
        invalid: {
            color: '#E25950',

            '::placeholder': {
                color: '#FFCCA5'
            }
        }
    };

    var elementClasses = {
        focus: 'focused',
        empty: 'empty',
        invalid: 'invalid'
    };

    var cardNumber = elements.create('cardNumber', {
        style: elementStyles,
        classes: elementClasses
    });
    cardNumber.mount('#credit_card_number');

   var cardExpiry = elements.create('cardExpiry', {
        style: elementStyles,
        classes: elementClasses
    });
    cardExpiry.mount('#credit-card-expiry-date');

    var cardCvc = elements.create('cardCvc', {
        style: elementStyles,
        classes: elementClasses,
        placeholder: 'CVV'
    });
    cardCvc.mount('#credit-card-cvc');

    function setOutcome(result) {
        var successElement = document.querySelector('.success');
        var errorElement = document.querySelector('.error');
        successElement.classList.remove('visible');
        errorElement.classList.remove('visible');

        if (result.token) {
            // In this example, we're simply displaying the token
            successElement.querySelector('.token').textContent = result.token.id;
            successElement.classList.add('visible');

            // In a real integration, you'd submit the form with the token to your backend server
            //var form = document.querySelector('form');
            //form.querySelector('input[name="token"]').setAttribute('value', result.token.id);
            //form.submit();
        } else if (result.error) {
            errorElement.textContent = result.error.message;
            errorElement.classList.add('visible');
        }
    }

    var cardBrandToPfClass = {
        'visa': 'pf-visa',
        'mastercard': 'pf-mastercard',
        'amex': 'pf-american-express',
        'discover': 'pf-discover',
        'diners': 'pf-diners',
        'jcb': 'pf-jcb',
        'unknown': 'pf-credit-card'
    };

    function setBrandIcon(brand) {
        var brandIconElement = document.getElementById('brand-icon');
        var pfClass = 'pf-credit-card';
        if (brand in cardBrandToPfClass) {
            pfClass = cardBrandToPfClass[brand];
        }
        for (var i = brandIconElement.classList.length - 1; i >= 0; i--) {
            brandIconElement.classList.remove(brandIconElement.classList[i]);
        }
        brandIconElement.classList.add('pf');
        brandIconElement.classList.add(pfClass);
    }

    cardNumber.on('change', function(event) {
        // Switch brand logo
        if (event.brand) {
            setBrandIcon(event.brand);
        }
    });

    registerElements([cardNumber, cardExpiry, cardCvc], 'example2');
})();

/**
 * this section hide we don't need annual subscription. Only going for home.
 */
function paymentOptionSelector() {
    $(".payment-plan").change(function() {
        if( $(this).is(":checked") ) {
            var val = $(this).val();
            var userBillingPackage = $(this).attr('data-package');

            var couponSection = $(".coupon-section");
            var footerNote = $(".footer-note");

            var price = $(this).attr('data-price');

            var selectedPackage = $(".selected-package");

            var totalAmount = $(".total-amount").attr("data-amount");
            var finalAmount = $(".final-amount");

            var finalOriginalAmount = finalAmount.attr("data-original-price");

            $(".billing-cycle-buttons label").removeClass('active');
            $(this).closest('label').addClass('active');

            // console.log("val " + val);

            if(val === 'yearly')
            {
                finalAmount.html('<span><b>$ '+price+'</b> /year</span>');
                couponSection.hide();

                // totalamount is monthly amount
                var yearlyPossibleAmount = totalAmount*12;

                couponSection.hide();
                footerNote.show();
                footerNote.html('<label>If yearly billing cycle is selected, pay $'+price+' instead of $'+yearlyPossibleAmount+'. instead of Billed Monthly - makes $'+yearlyPossibleAmount+' annually.</label>');

                // totalAmount.html('<b> </b>');
            }
            else
            {
                finalAmount.html('<span><b>$ '+price+'</b> /month</span>');
                couponSection.show();

                footerNote.hide();
            }
        }
    });
}
