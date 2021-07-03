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
                // console.log("loaded");

                if (statusCode == 200) {
                    if (data) {
                        var html = '';
                        html += '<option value="">SELECT A NICHE</option>';
                        html += '<option value="0">All Niches</option>';

                        $.each(data, function (index, value) {
                            html += '<option value="' + value.id + '">';
                            html += value.niche;
                            html += '</option>';
                        });

                        var nicheSelected = $("#niche").attr("data-selected-target");


                        if (html !== '') {
                            $("#niche").attr("disabled", false);
                            $("#niche").html(html);
                            $("#niche").select2();

                            if(nicheSelected && nicheSelected !== '')
                            {
                                $("#niche").val(nicheSelected);
                                $("#niche").select2();
                            }
                        }
                        else
                        {
                            $("#niche").html("");
                            $("#niche").select2();
                        }
                    }

                }

                // location.href = baseUrl+'/thank-you';
            });
        }
        else {
            $("#niche").html("<option value=''>Select Niche</option>");
            $("#niche").change();
            $("#niche").attr("disabled", true);
        }

    });

    $("#industry").change();
});
