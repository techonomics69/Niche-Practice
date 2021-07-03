$(document.body).on('submit', 'form.validate-business', function(e)
{
    // console.log("submit");
    e.preventDefault();

    // console.log("error status " + window.businessErrorFound);
    // console.log("error status " + businessErrorFound);

    if(!businessErrorFound)
    {
        // console.log("good to go");

        var address = $("#address").val();
        var phone = $("#phone").val();
        var website = $("#web-url").val();

        var formData = new FormData();

        formData.append('send', 'update-business-profile');
        formData.append('address', address);
        formData.append('phone', phone);
        formData.append('website', website);

        var targetButton = $(".btn-save", $(this));
        var $this = showLoaderButton(targetButton, "Saving");

        var baseUrl = $('#hfBaseUrl').val();
        var url= baseUrl + "/done-me";

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            contentType: false,
            cache: false,
            processData: false,
            data: formData,
            url:  url
        }).done(function (result) {
            // parse data into json
            var json = $.parseJSON(result);

            // get data
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;

            resetLoaderButton($this);

            if( statusCode == 200 ) {
                swal({
                    title: "Successful!",
                    text: statusMessage,
                    type: "success"
                }, function () {});
            }
            else
            {
                swal("", statusMessage, "error");
            }
        });

    }
});