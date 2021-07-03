function getVolumeForManuallyAddedKeywords(tags) {
    // console.log(tags);
    var keywords = tags.join(';');
    // console.log(keywords);

    var formData = false;
    if (window.FormData) formData = new FormData();

    formData.append('send', 'get-manual-keyword-volume');
    formData.append('keyword', keywords);

    var baseUrl = $('#hfBaseUrl').val();
    var isUserAllow = $('#user_allow').val();

    if(isUserAllow === 'yes')
    {
        var businessId = $('#business_id').val();
        formData.append('business_id', businessId);
    }
    else
    {
        var email = $('#email').val();
        formData.append('email', email);
        formData.append('missToken', true);
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/done-me",
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        success: function (result) {
            // parse data into json
            var json = $.parseJSON(result);
            // console.log(json);
            // get data
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var data = json.data;
            // console.log(data);

            var responseArray=[];
            $.each(data, function (index,value) {
                var obj={
                    'keyword': value.keyword,
                    'volume': value.volume
                };
                responseArray.push(obj);
            });
            // console.log(responseArray);

            // var selectedKeywordsCounter = $(".keyword-manager-modal .keyword-counter");
            // var selectedKeywordCount = parseInt(selectedKeywordsCounter.html());

            var keywordId = '';
            var html = '';

            var keywordStateContainer = $(".keywords-empty-state");
            var selectedKeywordsContainer = $(".selected-keywords");
            var selectedKeywordsData = $(".selected-keywords-data");

            $.each(responseArray, function (index,value) {
                keywordId = "keyword-"+ ++totalSuggestedKeywords;

                var matchedStatus = false;
                matchedStatus = detectSelectedBlock(value.volume);

                if (matchedStatus === false) {
                    selectedKeywordsData.append(selectedBlock(keywordId, value.keyword, value.volume));
                } else {
                    $("#" + matchedStatus).closest("div.keyword-data").before(selectedBlock(keywordId, value.keyword, value.volume));
                }
                //html += selectedBlock(keywordId, value.keyword, value.volume);
            });

            keywordStateContainer.hide();

            selectedKeywordsContainer.show();
            selectedKeywordsData.show();
            //selectedKeywordsData.append(html);

            var selectedKeywordsCounter = $(".selected-keywords-data .keyword-data");
            var selectedKeywordCount = selectedKeywordsCounter.length;
            selectedKeywordCount= parseInt(5-selectedKeywordCount);
            $(".selected-keywords .keyword-counter").html(selectedKeywordCount);

            $('#updateKeywords').modal('hide');

            setTimeout(function () {
                hidePreloader();
            }, 100);

            setKeywordButtonStatus();
            setNextButtonStatus();
        },
        error: function () {
            swal("", "OOPs! Something went wrong...", "error");
            hidePreloader();
        }
    });
}

$(function () {
        totalSuggestedKeywords = 0;

        updateSelectionKeywords();

        setKeywordButtonStatus();
        setNextButtonStatus();

        if(typeof(keywords_screen)!='undefined'){
            if(keywords_screen=='true'){
                $(".next-btn").attr({
                    "data-trigger":"hover",
                    "data-container": "body",
                    "data-toggle": "popover",
                    "data-placement-sm":"top",
                    "data-content": "Please select keywords to proceed.",
                    "data-original-title":""
                });
                $(".next-btn").popover('destroy');
                initiatePopover();

                $(".next-btn").addClass('disabled').attr('disabled','disabled');
            }
        }
});



$(document.body).on('click', '.next-btn', function () {
    if($(this).hasClass('disabled')){
        return false;
    }

    var tags = $('.tags-data').val();

    var selectedKeywordsContainer = $(".selected-keywords-data");
    var keywords = [];
    var dataCollection = [];
    var nextScreen = $(this).attr("data-href");

    var formData = false;
    if (window.FormData) formData = new FormData();

    $('.keyword-data', selectedKeywordsContainer).each(function() {
        dataCollection =
                    {
                        'keyword': $(this).attr("data-keyword-value"),
                        'volume': ($(this).attr("data-keyword-volume")) ? $(this).attr("data-keyword-volume") : '',
                        'rank': ($(this).attr("data-keyword-rank")) ? $(this).attr("data-keyword-rank") : ''
                        // 'rank': $(this).attr("data-keyword-rank")
                    };

        keywords.push (dataCollection);
    });

    if(keywords.length === 0)
    {
        return false;
    }
    else
    {
        if (keywords.length > 5) {
            swal("", "You can only add 5 keywods.", "error");
        }
        else if(keywords.length >0)
        {
            showPreloader();
            var baseUrl = $('#hfBaseUrl').val();
            var isUserAllow = $('#user_allow').val();

            formData.append('send', 'add-local-keyword');
            formData.append('keyword', keywords);

            // console.log("total keywords");
            // console.log(keywords);

            if(isUserAllow === 'yes')
            {
                data = {
                    'send': 'add-local-keyword',
                    'keyword': keywords
                };
            }
            else
            {
                var email = $('#email').val();
                formData.append('email', email);
                formData.append('missToken', true);

                data = {
                    'send': 'add-local-keyword',
                    'keyword': keywords,
                    'email': email,
                    'missToken': true
                };
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                type: "POST",
                url: baseUrl + "/done-me",
                data: data
                // contentType: false,
                // cache: false,
                // processData: false,
                // data: formData
            }).done(function (result) {
                var json = $.parseJSON(result);

                var statusCode = json.status_code;
                var statusMessage = json.status_message;

                if (statusCode === 200) {
                    // console.log("new");
                    // call needed here to run background to gather data,
                    var businessStatus = $("#business_status").val();

                    if(isUserAllow === 'yes')
                    {
                        updateKeywordsRank('user');
                    }
                    else
                    {
                        updateKeywordsRank();
                    }

                    if(businessStatus && businessStatus === 'completed')
                    {
                        hidePreloader();

                        swal({
                            title: "Successful!",
                            text: statusMessage,
                            type: "success"
                        }, function () {
                            showPreloader();
                            location.reload();
                        });
                    }
                    else
                    {
                        setTimeout(function() {
                            location.href = nextScreen
                        }, 1000);
                    }
                }
            });
        }
        else
        {
            swal("", "You have not selected any keyword.", "error");
        }
    }
});

/*
- Linked with Manual keyword form popup
- when button clicks that keyword will be part of selected kwyrods area in keywords screen.
 */
$(document.body).on('click', '.save-keywords', function ()
{
    var currentPage = $('#currentPage').val();

    var tagsContainer = $('.tags-data');
    var tags = tagsContainer.tagsinput('items');
    var tagsError = $('.tags-error');
    var tagsSuccess = $('.tags-success');
    tagsError.hide();
    tagsSuccess.hide();

    var selectedKeywordsCounter = $(".keyword-manager-modal .keyword-counter");
    var selectedKeywordCount = parseInt(selectedKeywordsCounter.html());


    // tags not empty
    if( tags.length >=1 )
    {
        // console.log("processing");
        // tagsArr = tags.split(',');

        showPreloader();
        tagsError.hide();
        tagsError.html('');

        // console.log("vefore tmodal " + totalSuggestedKeywords);

        var keywordId = '';
        var html = '';

        var keywordStateContainer = $(".keywords-empty-state");
        var selectedKeywordsContainer = $(".selected-keywords");
        var selectedKeywordsData = $(".selected-keywords-data");

        var keywordBtn = $(".add-keyword-btn");
        keywordBtn.show();
        keywordBtn.addClass('left m-t-40');

        getVolumeForManuallyAddedKeywords(tags);

        // $.each(tags, function (index,value) {
            // console.log(value);
        //     keywordId = "keyword-"+ ++totalSuggestedKeywords;
        //
        //     html += selectedBlock(keywordId, value);
        // });
        //
        // keywordStateContainer.hide();
        //
        // selectedKeywordsContainer.show();
        // selectedKeywordsData.show();
        // selectedKeywordsData.append(html);
        //
        // $(".selected-keywords .keyword-counter").html(selectedKeywordCount);
        //
        // $('#updateKeywords').modal('hide');
        //
        // setTimeout(function () {
        // hidePreloader();
        //     }, 100);
        //
        // setKeywordButtonStatus();
        // setNextButtonStatus();
    }
    else {
        if (selectedKeywordCount === 0) {
            tagsError.show();
            tagsError.html("You have already selected 5 keywords. Please save keywords or delete some selected keywords to add more.");

            setKeywordButtonStatus();
            setNextButtonStatus();
        }
        else
        {
            // console.log("elseif");
            tagsError.show();
            tagsError.html('Keyword is required.');
        }
    }

});

/*
- search for suggested keywords for user.
- User can select keywords from suggestion
 */
$(document).on('click', '.btn-search', function (e)
{
    var searchForm=$('#search-form');

    $(".btn-search").removeClass("active");
    $(this).addClass("active");

    e.preventDefault();

    $(".suggested-keywords .alert-danger").hide();
    var searchFor = $("#search").val();
    var alertContainer = searchForm.find('span.error-span');
    var baseUrl = $('#hfBaseUrl').val();

    var isUserAllow = $('#user_allow').val();

    var keywordStateContainer = $(".keywords-empty-state");
    var selectedKeywordsContainer = $(".selected-keywords");
    var selectedKeywordsData = $(".selected-keywords-data");

    // SUGGESTED
    var suggestedKeywordsContainer = $(".suggested-keywords");
    var suggestedKeywordsData = $(".suggested-keywords-data");
    var keywordBtn = $(".add-keyword-btn");


    alertContainer.addClass('hide-me');
    alertContainer.removeClass('error');

    if(searchFor === '')
    {
        alertContainer.removeClass('hide-me');
        alertContainer.addClass('error');
    }
    else
    {
        keywordStateContainer.hide();
        suggestedKeywordsData.hide();
        $(".img-loader").show();

        alertContainer.addClass('hide-me');
        alertContainer.removeClass('error');

        var $this = $(this);
        //var $this = $(".btn-search", searchForm);
        $(".btn-search").attr("disabled", 'disabled');
        var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';

        if ($this.html() !== loadingText) {
            $this.data('original-text', $this.html());
            $this.html(loadingText);
        }

        // var tryProcedure = 0;
        var formData = false;
        if (window.FormData) formData = new FormData();

        if($this.attr('data-type')=='related'){
            formData.append('send', 'suggested-keyword');
        }
        if($this.attr('data-type')=='broad'){
            formData.append('send', 'get-broadmatch-keyword');
        }

        formData.append('keyword', searchFor);

        if(isUserAllow === 'yes')
        {
            var businessId = $('#business_id').val();
            formData.append('business_id', businessId);
        }
        else
        {
            var email = $('#email').val();
            formData.append('email', email);
            formData.append('missToken', true);
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: baseUrl + "/done-me",
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
            var data = json.data;

            var html = '';

            $(".btn-search").removeAttr("disabled");
            $this.html($this.data('original-text'));

            $(".img-loader").hide();

            // console.log("status code " + statusCode);

            if(statusCode === 200)
            {
                selectedKeywordsContainer.show();

                var keywordId = '';


                if(data.length >= 1)
                {
                    keywordBtn.show();
                    keywordBtn.addClass('left m-t-40');

                    // console.log("vefore to " + totalSuggestedKeywords);
                    $.each(data, function(index, value)
                    {
                        keywordId = "keyword-"+ ++totalSuggestedKeywords;

                        html += suggestedBlock(keywordId, value.keyword, value.volume);
                    });

                    suggestedKeywordsContainer.show();
                    suggestedKeywordsData.show();
                    suggestedKeywordsData.html(html);
                }
                else
                {
                    suggestedKeywordsContainer.hide();
                    suggestedKeywordsData.html('');
                }


                initiatePopover();
            }
            else if(statusCode === 404)
            {
                /**
                 * hide selected keyword container if we have not selected keywords.
                 */
                // if(selectedKeywordsData === '')
                // {
                //     selectedKeywordsContainer.hide();
                // }

                suggestedKeywordsData.hide();
                keywordStateContainer.show();

                html = '';

                html +='<img src="'+baseUrl+'/public/images/keyword-empty.png" alt="">';
                html += '<div class="empty-state-desc"><h4>';
                html += statusMessage;
                html += ' or add keywords yourself';
                html += '</h4></div>';

                keywordStateContainer.html(html);

                keywordBtn.show();
                keywordBtn.removeClass('left m-t-40');
            // <img src="{{ asset('public/images/keyword-search.png') }}">
            //     <h4 class="m-t-35">Describe your business and search to see suggested keywords to choose from.</h4>
            }
            else
            {
                alertContainer.removeClass('hide-me');
                alertContainer.addClass('error');
                alertContainer.html(statusMessage);
            }
        });
    }
});

$(document.body).on('click', '.add-keyword-btn', function() {
    var selectedKeywordsCounter = $(".selected-keywords .keyword-counter");
    var selectedKeywordCount = parseInt(selectedKeywordsCounter.html());

    if(selectedKeywordCount === 0)
    {
        return false;
    }
    else
    {
        var mainModel = $('#main-modal');
        $(".modal-body, .modal-footer, .validate-me", mainModel).remove();
        $(mainModel).removeClass('welcome-process');
        $(mainModel).addClass('keywords-manager');


        var id = 'updateKeywords';

        $(mainModel).attr('id', id );

        var html = '';
        html += '<div class="modal-body">';
        html += '<div class="keyword-manager-modal">';

        html += '<div class="text-muted m-b-15">Enter keywords that you find best (<span class="keyword-counter">'+selectedKeywordCount+'</span> Left).</div>';
        html += '<div class="keyword_settings_wrapper">';

        html += '<div class="form-group">';

        html += '<div class="keyword-tags">';
        html += '<input class="tags-data" type="text" value="" data-role="tagsinput" autofocus>';
        html += '</div>';

        html += '<div class="p-b-10 left">';
        html += '<span class="help-text-phone-number" style="display: block;margin-top: 5px;margin-bottom: 0px;color: #737373;"><small>Type in keywords and press enter to separate each keyword.</small></span>';
        html += '<span class="alert alert-danger tags-error" style="display: none; padding: 8px;margin-top: 7px;float: left;margin-bottom: 0;"></span>';
        html += '<span class="alert alert-success tags-success" style="display: none; padding: 8px;margin-top: 7px;float: left;margin-bottom: 0;"></span>';
        html += '</div>';

        html += '</div>';

        html += '</div>';

        html += '</div>';


        html +='<div class="modal-footer">';
        // html +='<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
        html +='<button type="button" class="btn btn-primary save-keywords">Add Keywords</button>';
        html +='</div>';

        html +='</div>';


        mainModel.modal('show');
        $(".modal-header").after(html);


        $(".modal-title").remove();
        $('.modal-header').append('<h4 class="modal-title">Enter Keywords</h4>');
        // $('.modal-body', '#'+id).html(html);

        $('#updateKeywords .tags-data').tagsinput({
            trimValue: true // remove space from start & end
        });

        setTimeout(function () {
            $('#updateKeywords .bootstrap-tagsinput input').click();
        },500);

    }
});

$(document.body).on('hidden.bs.modal', '#updateKeywords', function () {
    $("#updateKeywords .modal-body, .modal-footer").remove();
    $("#updateKeywords").attr("id", "main-modal");
    // $("#updateKeywords .modal-header .modal-title").remove();
});

$(document.body).on('beforeItemAdd', '.tags-data', function (event) {
    var tag = event.item;

    // console.log("event ");
    // console.log(event);

    var selectedKeywordsCounter = $(".keyword-manager-modal .keyword-counter");
    var selectedKeywordCount = parseInt(selectedKeywordsCounter.html());

    if(selectedKeywordCount >0 && selectedKeywordCount <= 5)
    {
        $(".tags-error").hide();
        selectedKeywordsCounter.html(--selectedKeywordCount);
    }
    else
    {
        // console.log("hide tag " + tag);
        // console.log("event 2");
        // console.log(event);
        // $('.tags-data').tagsinput('remove', tag);

        // set to true to prevent the item getting added
        event.cancel = true;

        // setTimeout(function () {
            // console.log("hide tag " + tag);
            // console.log("event 2");
            // console.log(event);
        //     // $('.tags-data').tagsinput('remove', tag);
        //
        //     event.cancel = true;
        //     // event.cancel = true;
        // }, 100);

        $(".tags-error").show();
        $(".tags-error").html("You have already selected 5 keywords. Please save keywords or delete some selected keywords to add more.");
    }

    //
    // event.remove();
});

$(document.body).on('beforeItemRemove', '.tags-data', function (event) {
    var tag = event.item;

    // event.preventDefault();
    // console.log("removal tag " + tag);
    var selectedKeywordsCounter = $(".keyword-manager-modal .keyword-counter");
    var selectedKeywordCount = parseInt(selectedKeywordsCounter.html());

    $(".tags-error").hide();

    // Increment the counter
    selectedKeywordsCounter.html(++selectedKeywordCount);
});

$(document.body).on('click', '.keyword-reset', function () {
    // console.log("reset " + $(this).closest("label").next('input').is(':checked'));
    // console.log($(this));

    // $(this).removeClass('keyword-reset');
    // $(this).attr("disabled", true);

    // checkbox enabled before assign. because checkbox disabled in selection mode.
    $(this).closest("label").next('input').attr("disabled", false);
    $(this).closest("label").next('input').addClass("keyword-toggle");
    // $(this).closest("label").next('input').trigger();
});

/**
 * Clicks on checkbox and make appropriate actions.
 */
$(document.body).on('click', '.keyword-toggle', function () {
    $(this).attr("disabled", true);
    // console.log("calling");

    var checked = ($(this).is(':checked') === true) ? 1 : 0;
    var parentElement = $(this).closest(".keyword-data");
    var elementLabel = parentElement.find('label');

    // console.log("I'm clicked" + checked);
    // console.log($(this));

    var keywordId = $(this).attr("id");
    var keyword = parentElement.attr("data-keyword-value");
    var rank = parentElement.attr("data-keyword-rank");
    var volume = parentElement.attr("data-keyword-volume");
    var targetType = parentElement.attr("data-keyword-type");

    var selectedKeywordsData = $(".selected-keywords-data");
    var suggestedKeywordsData = $(".suggested-keywords-data");

    var selectedKeywordsCounter = $(".keyword-counter");
    var selectedKeywordCount = parseInt(selectedKeywordsCounter.html());

    var matchedStatus = false;

    // console.log("I'm keyword" + keyword);

    // if(targetType === 'suggested')
    // {
    //     parentElement.popover('hide');
    // }

    /**
     * If element is checked then mark as selected keyword.
     * Move this into selected area from suggested
     */
    if (checked === 1) {
        // console.log("label ");
        // console.log(elementLabel);

        // go in if user not 5 keywords.
        if(selectedKeywordCount >0 && selectedKeywordCount <= 5)
        {
            $(".suggested-keywords .alert-danger").hide();
            parentElement.popover('hide');
            // Decrement the counter
            selectedKeywordsCounter.html(--selectedKeywordCount);

            elementLabel.removeClass('label-off');
            elementLabel.addClass('label-on');

            // console.log("before");

            // console.log("before going " + volume);
            matchedStatus = detectSelectedBlock(volume);

            parentElement.fadeOut(500, function()
            {
                // console.log("after");
                parentElement.remove();

                if(matchedStatus === false)
                {
                    selectedKeywordsData.append(selectedBlock(keywordId, keyword, volume, rank));
                }
                else
                {
                    $("#"+matchedStatus).closest("div.keyword-data").before(selectedBlock(keywordId, keyword, volume, rank));
                }
            });
        }
        else
        {
            $(this).attr('checked', false);
            $(this).attr("disabled", false);

            var currentPage = $('#currentPage').val();

            $(".suggested-keywords .alert-danger").show();

            if(currentPage === 'settings_keywords')
            {
                $(".suggested-keywords .alert-danger").html("You have already selected 5 keywords. Please delete some selected keywords to add more.");
            }
            else
            {
                $(".suggested-keywords .alert-danger").html("You have already selected 5 keywords. Please proceed to next screen or delete some selected keywords to add more.");
            }
        }
    } else {
        $(".suggested-keywords .alert-danger").hide();
        /**
         * If element is un-checked then move this into Suggested area.
         */
            // Increment the counter
            selectedKeywordsCounter.html(++selectedKeywordCount);

        elementLabel.removeClass('label-on');
        elementLabel.addClass('label-off');
        $(this).attr("disabled", false);
        // parentElement.remove();
        // suggestedKeywordsData.append(suggestedBlock(keywordId, keyword, volume, rank));

        matchedStatus = detectSuggestedBlock(volume);

        parentElement.fadeOut(100, function()
        {
            parentElement.remove();

            if(matchedStatus === false)
            {
                suggestedKeywordsData.append(suggestedBlock(keywordId, keyword, volume, rank));
            }
            else
            {
                $("#"+matchedStatus).closest("div.keyword-data").before(suggestedBlock(keywordId, keyword, volume, rank));
            }

            // suggestedKeywordsData.append(suggestedBlock(keywordId, keyword, volume, rank));
        });
    }

    // $('.keyword-reset').unbind('click');
    setKeywordButtonStatus();
    setNextButtonStatus();
});

/**
 * when it finds number is greater than any selector it will return
 * @param volume
 * @returns {boolean}
 */
function detectSelectedBlock(volume)
{
    var matched = false;

    var selectedKeywordsData = $(".selected-keywords-data");
    var currentVolume = 0;
    $('.keyword-data', selectedKeywordsData).each(function() {
        currentVolume = ($(this).attr('data-keyword-volume')) ? parseInt($(this).attr('data-keyword-volume')) : 0;

        if(parseInt(volume) > currentVolume)
        {
            matched = $(this).find(".nocheckbox").attr('id');

            return false;
        }
    });

    return matched;
}

function detectSuggestedBlock(volume)
{
    var matched = false;

    var suggestedKeywordsData = $(".suggested-keywords-data");
    var currentVolume = 0;
    $('.keyword-data', suggestedKeywordsData).each(function() {
        //
        //
        currentVolume = ($(this).attr('data-keyword-volume')) ? parseInt($(this).attr('data-keyword-volume')) : 0;

        // console.log("Current Volume " + volume + " type " + Number.isInteger(parseInt(volume)));
        // console.log("val " + currentVolume + " second type " + Number.isInteger(parseInt($(this).attr('data-keyword-volume'))));

        if(parseInt(volume) > currentVolume)
        {
            // console.log("matched Integer If");
            matched = $(this).find(".nocheckbox").attr('id');

            return false;
        }
        // console.log("counter working ");
    });

    // console.log("Loop Finished " + matched);

    return matched;
}

function suggestedBlock(keywordId, keyword, volume, rank) {
    var html = '';
    rank = (rank) ? rank : "";
    volume = (volume) ? volume : "";

    html +='<div class="left keyword-data '+keywordId+'" data-keyword-type="suggested" data-keyword-rank="'+rank+'" data-keyword-value="'+keyword+'" data-keyword-volume="'+volume+'" data-trigger="hover" data-container="body" data-toggle="popover" data-placement-sm="top" data-content="'+volume+'" data-original-title="Monthly Search Volume">';

    html +='<label class="label-off" for="'+keywordId+'">';
    html += '<p class="keyword-text">'+ keyword +'</p>';
    html +='<span>';
    html += (volume) ? volume : "N/A";
    html +='</span>';
    html +='</label>';
    html +='<input class="nocheckbox keyword-toggle" type="checkbox" id="'+keywordId+'">';

    html +='</div>';

    return html;
}

function selectedBlock(keywordId, keyword, volume, rank) {
    var html = '';
    rank = (rank) ? rank : "";
    volume = (volume) ? volume : "";

    html +='<div class="left keyword-data '+keywordId+'" data-keyword-type="selected" data-keyword-rank="'+rank+'" data-keyword-value="'+keyword+'" data-keyword-volume="'+volume+'">';

    html +='<label class="label-on keyword-show" for="'+keywordId+'">';
    html += '<p class="keyword-text">'+ keyword +'</p>';
    html +='<span class="keyword-value">';
    html += (volume) ? volume : "N/A";
    html +='</span>';
    html +='<span class="keyword-reset">x</span>';
    html +='</label>';
    html +='<input class="nocheckbox" type="checkbox" id="'+keywordId+'" checked="checked" disabled="disabled">';

    html +='</div>';

    return html;
}



function initiatePopover()
{
    // console.log("iniaitae");

    $('[data-toggle="popover"]').popover({
        'placement': function(tt, trigger) {
            var $trigger = $(trigger);
            var windowWidth = $(window).width();

            var xs = $trigger.attr('data-placement-xs');
            var sm = $trigger.attr('data-placement-sm');
            var md = $trigger.attr('data-placement-md');
            var lg = $trigger.attr('data-placement-lg');
            var general = $trigger.attr('data-placement');

            return (windowWidth >= 1200 ? lg : undefined) ||
                (windowWidth >= 992 ? md : undefined) ||
                (windowWidth >= 768 ? sm : 'top') ||
                xs ||
                general ||
                "top";
        }
    });
}

/*
0 left = all keywords has been filled. -> Show tooltip and disable the button.
n (1-5)Left = user has selection (n) keyword. -> remove tooltip and Enable the button.
*/
function setKeywordButtonStatus() {
    var selectedKeywordsCounter = $(".selected-keywords .keyword-counter");
    var selectedKeywordCount = parseInt(selectedKeywordsCounter.html());
    var targetBtn = $(".add-keyword-btn");

    /*
    - show tooltip with message
    - disable the button
     */
    if (selectedKeywordCount === 0) {
        // console.log("dis");
        targetBtn.addClass("disabled");
        targetBtn.attr({
            "data-trigger":"hover",
            "data-container": "body",
             "data-toggle": "popover",
            "data-placement-sm":"top",
             "data-content": "Unable to add. Maximum keywords have been selected.",
             "data-original-title":""
        });

        initiatePopover();
    }
    else
    {
        // console.log("remove and destroy");
        targetBtn.removeClass("disabled");
        targetBtn.popover('destroy');

        targetBtn.removeAttr("data-trigger data-container data-toggle data-placement-sm data-content data-original-title");
    }
}

/*
5 left = No keyword has been selected. -> Show tooltip and disable the button.
n (0-4)Left = user has selection (n) keyword. -> Remove tooltip and Enable the button.
*/
function setNextButtonStatus() {
    var selectedKeywordsCounter = $(".selected-keywords .keyword-counter");
    var selectedKeywordCount = parseInt(selectedKeywordsCounter.html());
    var targetBtn = $(".next-btn");

    /*
    - No keyword has been selected.
    - show tooltip with message
    - disable the button
     */
    if (selectedKeywordCount === 5) {
        targetBtn.addClass("disabled").attr('disabled','disabled');
        targetBtn.attr({
            "data-trigger":"hover",
            "data-container": "body",
             "data-toggle": "popover",
            "data-placement-sm":"top",
             "data-content": "Please select keywords to proceed.",
             "data-original-title":""
        });

        initiatePopover();
    }
    else
    {
        targetBtn.removeClass("disabled").removeAttr('disabled');
        targetBtn.popover('destroy');

        targetBtn.removeAttr("data-trigger data-container data-toggle data-placement-sm data-content data-original-title");
    }
}

function isValueExist(arr,val)
{
    if(arr.length === 1)
    {
        if(Number.isInteger(val) === false)
        {
            val = val.toLowerCase();
        }

        // var arr = ['a','b','c','d','e', 50, 'Abdul', "Rehman78", 60, 62.25];
        // var arr = ['a','b','c','d','e', 'Abdul', "Rehman78"];
        var i = arr.length;
        var currentElement;

        while (i--) {
            currentElement = arr[i];
            // console.log("element index" + i);
            // console.log("element " + currentElement);

            if(Number.isInteger(currentElement) === false)
            {
                currentElement = currentElement.toLowerCase();
            }

            if (currentElement === val) return i;
        }
        return -1;
    }
}

function updateSelectionKeywords()
{
    var selectedkeywords = $("#selected_keywords").val();
    var selectedKeywordsData = $(".selected-keywords-data");

    if(selectedkeywords !== '')
    {
        var selectedKeywordsCounter = $(".selected-keywords .keyword-counter");
        var selectedKeywordCount = parseInt(selectedKeywordsCounter.html());

        var data = JSON.parse(selectedkeywords);
        var totalKeywords = data.length;

        if(totalKeywords >0)
        {
            var keywordId = '';
            $.each(data, function(index, value)
            {
                if(index <=5)
                {
                    keywordId = "keyword-"+ ++totalSuggestedKeywords;

                    selectedKeywordsData.append(selectedBlock(keywordId, value.keyword, value.volume, value.rank));
                }
            });

            if(totalKeywords > 5)
            {
                totalKeywords = 5;
            }

            selectedKeywordsCounter.html(selectedKeywordCount - totalKeywords);
        }


        // if (totalKeywords > 5) {
        //     swal("", "You can only add 5 keywods.", "error");
        // }
        // else if(totalKeywords >0)
        // {
        //     showPreloader();
        //     var baseUrl = $('#hfBaseUrl').val();
        //     var isUserAllow = $('#user_allow').val();
        //
        //     formData.append('send', 'add-local-keyword');
        //     formData.append('keyword', keywords);
        //
            // console.log("total keywords");
            // console.log(keywords);
        //
        //     if(isUserAllow === 'yes')
        //     {
        //         formData.append('missToken', true);
        //
        //         data = {
        //             'send': 'add-local-keyword',
        //             'keyword': keywords,
        //             'missToken': true
        //         };
        //     }
        //     else
        //     {
        //         var email = $('#email').val();
        //         formData.append('email', email);
        //
        //         data = {
        //             'send': 'add-local-keyword',
        //             'keyword': keywords,
        //             'email': email
        //         };
        //     }
        //
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('input[name="_token"]').val()
        //         },
        //         type: "POST",
        //         url: baseUrl + "/done-me",
        //         data: data
        //         // contentType: false,
        //         // cache: false,
        //         // processData: false,
        //         // data: formData
        //     }).done(function (result) {
        //         var json = $.parseJSON(result);
        //
        //         var statusCode = json.status_code;
        //         var statusMessage = json.status_message;
        //
                // console.log("new");
                // console.log(result);
        //
        //         if (statusCode === 200) {
                    // console.log("new");
        //             // call needed here to run background to gather data,
        //
        //             setTimeout(function() {
        //                 location.href = nextScreen
        //             }, 1000);
        //         }
        //     });
        // }
        // else
        // {
        //     swal("", "You have not selected any keyword.", "error");
        // }

    }
}

/*----------*/

$(document).on('mouseover', '.keyword-show', function (e){
    var width=$(this).width();
    $(this).find('.keyword-value').hide();
    $(this).find('.keyword-reset').css('display','inline-block');
    $(this).css('min-width', (width+20)+'px');
});

$(document).on('mouseout', '.keyword-show', function (e){
    var width=$(this).width();
    $(this).find('.keyword-value').css('display','inline');
    $(this).find('.keyword-reset').hide();
    $(this).css('min-width', (width+20)+'px');
});
$(window).resize(function(){
    $('.popover').popover('hide');
});


function updateKeywordsRank() {
    var baseUrl = $('#hfBaseUrl').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        type: "POST",
        url: baseUrl + "/done-me",
        data: {
            'send': 'get-keyword-rank'
        }
    }).done(function (result) {
        // parse data into json
        var json = $.parseJSON(result);

        // get data
        var statusCode = json.status_code;
        var statusMessage = json.status_message;

        // console.log("keyword " + result);
    });
}
