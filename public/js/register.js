
$(function () {
    $("#industry").change(function () {
        var selectedIndustry = $(this).val();
        var siteUrl = $('#hfBaseUrl').val();

        // console.log("selected is  " + selectedIndustry);

        if (selectedIndustry !== '') {
            // console.log("not empty ");

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "GET",
                url: siteUrl + "/industry-niches",
                data: {
                    'industry': selectedIndustry
                }
            }).done(function (result) {
                // parse data into json
                var json = $.parseJSON(result);

                // get data
                var statusCode = json.status_code;
                var statusMessage = json.status_message;
                var data = json.data;

                // console.log("status code " + statusCode);
                // console.log("statusMessage " + statusMessage);
                // console.log(data);

                if (statusCode == 200) {
                    if (data) {
                        var html = '';
                        html += '<option value="">Select a Niche</option>';
                        $.each(data, function (index, value) {
                            html += '<option value="' + value.id + '">';
                            html += value.niche;
                            html += '</option>';
                        });

                        if (html !== '') {
                            $("#niche").attr("disabled", false);
                            $("#niche").html(html);
                        }
                    }
                }

                // location.href = baseUrl+'/thank-you';
            });
        } else {
            $("#niche").html("<option>SELECT A NICHE</option>");
            $("#niche").attr("disabled", true);
        }

    });
});

$(document.body).on('submit', 'form.validate-me', function(e)
{
    e.preventDefault();
    // console.log("call B");
    // console.log(e);
    // return;
    // var isUpdate = $('#isUpdatedDetail').val();
    // console.log("error before validation" + errorFound);

    // again validating if no validation field left.
    // validationChecker();

    // console.log("error after validation" + errorFound);

    var alertResponse = $(".response-message");

    alertResponse.hide();

    // alert("errorFound");
    // alert(errorFound);
    //
    // return false;
    if (!errorFound) {
        // console.log("validation passed");
        var baseUrl = $('#hfBaseUrl').val();

        var $this = $(".submit");
        $this.attr("disabled", true);
        var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> Registering...';

        if ($this.html() !== loadingText) {
            $this.data('original-text', $this.html());
            $this.html(loadingText);
        }


        var data = [];
        var formData = false;
        if (window.FormData) formData = new FormData();

        $('.validate-me input, .validate-me select').each(function () {

            var isRequired = $(this).attr('data-required');
            var custId = $('#custId').val();
            console.log(custId);
            formData.append('u_id', custId);
            var name = $(this).attr('name');
            var ID = $(this).attr('id');
            var value = $(this).val();
            var businessDiscoverySelection = $(".business-discovery-status").val();

            if (name === 'phone' && value === 'not_found') {
                value = '';
            }

            // if(businessDiscoverySelection === 'auto')
            // {
            //
            // }
            formData.append(name, value);

            // data.push({name: value});
        });


        var email = $("#email").val();
        formData.append('email', email);
        var password  = $("#password").val();
        // console.log(data);
        // console.log("ba " + baseUrl);

        // var userData = formData;
        //
        // console.log("userData");
        // console.log(userData);

        // data = {
        //     'name' : 'abdul',
        //     'f' : '12',
        // };

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: baseUrl + '/admin-register',
            // data: data
            contentType: false,
            cache: false,
            processData: false,
            data: formData
        }).done(function (result) {
            // parse data into json
            var json = $.parseJSON(result);

            // get data
            var statusCode = json.status_code;
            var statusMessage = json.status_message;

            alertResponse.show();

            $this.attr("disabled", false);
            $this.html($this.data('original-text'));


            if(statusCode == 200)
            {
                $(".action-center ").hide();
                alertResponse.html(
                    '<div class="alert alert-success">'+statusMessage+'</div>'
                    + '<div class="loading-bar" style="text-align: center;"> <span class="loading-text" style="font-size: 15px;font-weight: 700;display: none;">Logging In app</span>' +
                    ' <img src="'+baseUrl+'/public/images/Loading-bar.gif"> ' +
                    '</div>'
                );

                login(email, password, 'register');
            }
            else
            {
                alertResponse.html('<div class="alert alert-danger">'+statusMessage+'</div>');
            }

            // console.log(json);

            // hidePreloader();
        });
    }
});

google.maps.event.addDomListener(window, 'load', function () {

    // console.log("yes");

    var places = new google.maps.places.Autocomplete(document.getElementById('practice-name'));
    // $("#practice-name").attr("placeholder", "");
    // console.log("places ");
    // console.log(places.getPlace);
    // var searchResult = new google.maps.places.SearchBox(document.getElementById('practice-name'));

    google.maps.event.addListener(places, 'place_changed', function () {

        // places = places.setFields(['icon', 'name']);

        // console.log("place_changed ");
        var selectedPlace = places.getPlace();

        // console.log(selectedPlace);

        var practiceContainer = $(".practice-container");
        practiceContainer.hide();

        if (selectedPlace) {
            $(".business-discovery-status").val('auto');
            hideManualBusinessSection();

            var pacContainer = $(".pac-container");
            var manualBusinessContainer = $(".manual-business-box");
            var selectedBusinessContainer = $(".business-selected-box");
            var manualBusinessBox = $(".manual-add-business");
            var practiceName = $("#practice-name").val();

            var businessName = selectedPlace.name;
            var businessPhoneNumber = '';
            var addressType = '';
            var formattedAddress = '';

            businessPhoneNumber = (selectedPlace.formatted_phone_number) ? selectedPlace.formatted_phone_number : '';

            // if(selectedPlace.address_components && selectedPlace.address_components !== '')
            // {
            //     console.log("not empty componesnts");
            //     $.each(selectedPlace.address_components, function(index, value)
            //     {
            //         console.log("val " + index);
            //         console.log(value);
            //         addressType = value.types[0];
            //         // addressName = value.short_name;
            //
            //         if(addressType === 'route' || addressType === 'locality' || addressType === 'administrative_area_level_1' || addressType === 'country')
            //         {
            //             if(value.short_name)
            //             {
            //                 formattedAddress += value.short_name;
            //
            //                 if(addressType !== 'country')
            //                 {
            //                     formattedAddress += ', ';
            //                 }
            //             }
            //         }
            //
            //         console.log("type " + addressType);
            //         console.log("addressName " + value.short_name);
            //         console.log("formattedAddress " + formattedAddress);
            //
            //         // $addressName = $addressComponents['long_name'];
            //     });
            // }


            // remove business name from all the name
            formattedAddress = practiceName.replace(businessName, "");
            // console.log("formattedAddress " + formattedAddress);


            $("#practice-name").val(businessName);

            // console.log("web " + selectedPlace.website);
            if(selectedPlace.website)
            {
                $("#website").val(selectedPlace.website);
            }

            var address_components = selectedPlace.address_components;
            // console.log('address_components');
            // console.log(address_components);
            for (let index = 0; index < address_components.length; index++) {
                if (address_components[index].types[0] == 'country') {
                    // console.log(selectedPlace.address_components[index].long_name);
                    $("#country").val(selectedPlace.address_components[index].long_name);
                } else if (address_components[index].types[0] == 'administrative_area_level_1') {
                    // console.log(selectedPlace.address_components[index].long_name);
                    $("#state").val(selectedPlace.address_components[index].long_name);
                } else if (address_components[index].types[0] == 'administrative_area_level_2') {
                    // console.log(selectedPlace.address_components[index].long_name);
                    $("#city").val(selectedPlace.address_components[index].long_name);
                } else if (address_components[index].types[0] == 'postal_code') {
                    // console.log(selectedPlace.address_components[index].long_name);
                    $("#postal_code").val(selectedPlace.address_components[index].long_name);
                }
            }

            if (businessPhoneNumber !== '') {
                $("#phone").val(businessPhoneNumber);
            } else {
                $("#phone").val('not_found');
            }

            // console.log('formattedAddress > before');
            // console.log(formattedAddress);

            formattedAddress = $.trim(formattedAddress);

            // console.log('formattedAddress > after');
            // console.log(formattedAddress);

            if (formattedAddress.charAt(0) === ',' || formattedAddress.charAt(0) === '.') {
                formattedAddress = formattedAddress.substring(1, formattedAddress.length);
            }
            // console.log("Final formattedAddress " + formattedAddress);

            selectedBusinessContainer.show();
            $(".pac-matched", selectedBusinessContainer).html(businessName);

            if (formattedAddress !== '' && businessPhoneNumber !== '') {
                // formattedAddress = formattedAddress + ' | ' + businessPhoneNumber;
                $(".address-detail", selectedBusinessContainer).html(formattedAddress + ' | ' + businessPhoneNumber);
            } else if (formattedAddress === '' || businessPhoneNumber === '') {
                // console.log("some thing missing");
                $(".address-detail", selectedBusinessContainer).html(formattedAddress + businessPhoneNumber);
            }

            if(formattedAddress !== '')
            {
                // console.log("address is not empty");
                $("#business-address").val(formattedAddress);
            }

            // console.log("outside componesnts");

            manualBusinessContainer.hide();
            $(".form-group, .heading-default").css("visibility", 'visible');
        }
    });
});

$(".close-me").click(function () {
    $(".business-discovery-status").val('manual');
    // showManualBusinessSection();
    $(".business-selected-box").hide();
    var practiceContainer = $(".practice-container");
    practiceContainer.show();
    $("#practice-name").val("");
    $(".practice-container .putin").removeClass('active');
});

$("#practice-name").on('keyup focus blur', function (e) {
    // console.log("event");
    // console.log(e.type);

    var inputVlaue = $(this).val();

    // console.log($(this).val());

    var pacContainer = $(".pac-container");
    var manualBusinessContainer = $(".manual-business-box");
    var manualBusinessBox = $(".manual-add-business");
    var html = '';

    if (e.type === 'keyup') {
        $(".form-group, .heading-default").css("visibility", 'hidden');
        $(".business-section").css("visibility", 'visible');

        if (pacContainer.find(manualBusinessBox).length === 0) {
            pacContainer.append('<div class="manual-add-business"><span class="item-query"><span class="pac-matched">Can\'t find your business?</span></span>Add your business manually</div>');
        }

        setTimeout(function () {
            if ($(".heading-default").css('visibility') === 'hidden') {
                manualBusinessContainer.show();
            }
        }, 1500);

        // if(pacContainer.css('display') === 'block')
        // {
        //
        // }

        // inputVlaue
    } else if (e.type === 'focus') {

        if (inputVlaue === '') {
            return false;
        }
        $(".form-group, .heading-default").css("visibility", 'hidden');
        $(".business-section").css("visibility", 'visible');

        if (pacContainer.find(manualBusinessBox).length === 0) {
            pacContainer.append('<div class="manual-add-business"><span class="item-query"><span class="pac-matched">Can\'t find your business?</span></span>Add your business manually</div>');
        }

        setTimeout(function () {
            if ($(".heading-default").css('visibility') === 'hidden') {
                manualBusinessContainer.show();
            }
        }, 1500);
    } else if (e.type === 'blur') {
        // pacContainer.css('display', 'block !important');
    }

    // var service = new google.maps.places.AutocompleteService();
    // console.log("oi");
    // console.log(service);
    // console.log(service.getQueryPredictions({input: document.getElementById('practice-name').value}, callback));
    //
    // console.log("searchResult ");
    // console.log(service);
});

$(document).click(function (e) {

    // console.log("eeee");
    // console.log(e);
    // console.log("target");
    // console.log(e.target);

    // console.log("toElement");
    // console.log(e.originalEvent.path[0]);


    // if($(e.target).is('div.white-box'))
    if ($(e.target).is('body')) {
        // console.log("wh");
        var pacContainer = $(".pac-container");
        var manualBusinessContainer = $(".manual-business-box");
        var manualBusinessBox = $(".manual-add-business");

        manualBusinessContainer.hide();
        $(".form-group, .heading-default").css("visibility", 'visible');

        showManualBusinessSection();
    } else {
        // console.log("else");
    }

    // if($(e.target).is('#MainCanvas, #MainCanvas *'))return;
    // $('#MainCanvas').hide();
});

$(document).on('click', '.manual-add-business', function (e) {
    // console.log("over");
    var pacContainer = $(".pac-container");
    var manualBusinessContainer = $(".manual-business-box");
    var manualBusinessBox = $(".manual-add-business");

    manualBusinessContainer.hide();
    $(".form-group, .heading-default").css("visibility", 'visible');

    $(".business-discovery-status").val('manual');
    showManualBusinessSection();
});

function showManualBusinessSection() {
    // console.log("manual Called show");
    if ($(".business-discovery-status").val() === 'manual') {
        var phone = $(".optional-section #phone");
        var website = $(".optional-section #website");

        // console.log("manual if");
        $(".optional-section").show();
        phone.attr('data-required', true);

        phone.val("");
        website.val("");
    }
}

function hideManualBusinessSection() {
    // console.log("manual Called Hide");
    if ($(".business-discovery-status").val() === 'auto') {
        var phone = $(".optional-section #phone");
        var website = $(".optional-section #website");

        // console.log("hide if");
        $(".optional-section").hide();

        phone.val('not_found').blur();
        website.val("");
    }
}

function callback(predictions, status) {
    // console.log("upd");
    // console.log("status");
    // console.log(status);
    // console.log("predictions");
    // console.log(predictions);
    return true;
}

function login(email, password, source)
{

    var baseUrl = $('#hfBaseUrl').val();

    if(email === '')
    {
        email = $("#email").val();
    }

    if(password === '')
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
            password: password,
            source: source
        }
    }).done(function (result) {
        // parse data into json
        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;

        var alertResponse = $(".response-message");
        alertResponse.show();

        if(statusCode == 200)
        {
            if(source !== 'register')
            {
                alertResponse.html('<div class="alert alert-success">'+statusMessage+'</div>');
            }

            location.href = baseUrl;
        }
        else
        {
            if(statusCode == 2)
            {
                location.href = baseUrl;
            }
            else
            {
                alertResponse.html('<div class="alert alert-danger">'+statusMessage+'</div>');
            }
        }
    });
}

