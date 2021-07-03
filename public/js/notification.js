/**
 * Created by: Abdul Rehman
 * Replacement of Down feature
 *
 *
 * We down this feature as we can not achieve
 * Ai bot functioanlity till first release.
 *
 * Load chat history
 * Send chat message on click
 * Schedule message
 * infinite scroll functionality
 * initiateCustomLibrary()
 */

$(function() {
    loadChatHistory();
    var chatList = $('.notificationsbox');

    // Each time the user scrolls
    chatList.scroll(function (e) {
        var scrollBottom = $(chatList).scrollTop() + $(chatList).height();

        var chatContainer = $(chatList)[0].scrollHeight - 3;

        // console.log("bottom " + chatList.ScrollBottom());
        if (scrollBottom >= chatContainer) {
            loadChatHistory();
        }
    });
});

$(document).on('click','.notificationsbox li',function(e)
{
    e.preventDefault();
    var baseUrl = $('#hfBaseUrl').val();

    if(isEmptyValNormal($(this).attr('id')))
    {
        return false;
    }

    // $(this).closest('li').css("background-color", "red");
    // return false;
    showPreloader();

    var notifyId = $(this).attr('data-chat-identity');
    var url = $(this).attr("data-href");

    var time = 0;

    if($(this).attr('class') === 'unread')
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: baseUrl + "/done-me",
            data: {
                'send': 'update-chat-status',
                'chat_identity': notifyId
            }
        }).done(function (result) {
            // parse data into json
            var json = $.parseJSON(result);

            // get data
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
        });

        time = 1000;
    }

    setTimeout(function () {
        window.location.href = url;
    }, time)


});


/**
 * Load chat history which is between Madison and user.
 *
 * @returns {boolean}
 */
function loadChatHistory()
{
    var baseUrl = $('#hfBaseUrl').val();
    var chatRetrievalDate = '';
    var chatPage = $('#chatPage').val();

    if(chatPage !== '') {
        $('.mini-loader').show();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: "POST",
            url: baseUrl + "/done-me",
            data: {
                send: 'retrieve-chat-history',
                chatNumber: chatPage // Page number
                // of chat loading
            }
        }).done(function (result) {
            // parse data into json
            var json = $.parseJSON(result);

            // get data
            // console.log('json');
            // console.log(json);
            // return;
            var statusCode = json.status_code;
            var statusMessage = json.status_message;
            var messageDay = json.messageDate;

            $('.mini-loader').hide();

            if (statusCode === 200) {
                var html = '';
                var i = 0;
                var data = json.data;
                var messageStatus = '';

                if (data !== '') {

                    if(data.unread != 0) {
                        $('.notify').show();
                        $('.notify span').html(data.unread);
                    }
                    if(data.unread == 0 && chatPage == 1){
                        $('.read-all-notification').html('All Notification\'s Read');
                        $('.read-all-notification').removeAttr('id');
                        $('.read-all-notification').removeAttr('style');
                    }

                    var notificationImage = '';

                    $.each(data.notifications, function (index, value) {
                        messageStatus = (value.read === 1) ? 'read' : 'unread';
                        var message = value.message;

                        if(message.indexOf("Tripadvisor") >=0)
                        {
                            notificationImage = baseUrl + '/public/images/icons/tripadvisor.png';
                        }
                        else if(message.indexOf("Yelp") >=0)
                        {
                            notificationImage = baseUrl + '/public/images/yelp.png';
                        }
                        else if(message.indexOf("Google Places") >=0)
                        {
                            notificationImage = baseUrl + '/public/images/google.png';
                        }
                        else if(message.indexOf("Facebook") >=0)
                        {
                            notificationImage = baseUrl + '/public/images/001-facebook.png';
                        }
                        else if(message.indexOf("website") >=0)
                        {
                            // console.log("message " + message);
                            notificationImage = baseUrl + '/public/images/icons/website.png';
                        }
                        else if(message.indexOf("Zocdoc") >=0)
                        {
                            // console.log("message " + message);
                            notificationImage = baseUrl + '/public/images/icons/zocdoc-large.png';
                        }
                        else if(message.indexOf("Healthgrades") >=0)
                        {
                            // console.log("message " + message);
                            notificationImage = baseUrl + '/public/images/icons/healthgrades-large.png';
                        }
                        else if(message.indexOf("Ratemd") >=0)
                        {
                            // console.log("message " + message);
                            notificationImage = baseUrl + '/public/images/icons/ratemd-large.png';
                        }
                        else
                        {
                            // console.log("message " + message);
                            notificationImage = baseUrl + '/public/images/citation.png';
                        }

                        var marketingUrl = '';

                        if(value.notification_type == 'link_building')
                        {
                            marketingUrl = baseUrl+'/link-building';
                        }
                        else
                        {
                            // marketingUrl = baseUrl+'/task/module/marketing-plan?objective='+value.objective_parent+'&task='+value.business_task_id;
                            marketingUrl = baseUrl+'/monitor-your-reviews';
                        }

                        html += '<li class="'+messageStatus+'" data-href="'+marketingUrl+'" id="message-' + value.id + '" data-chat-identity="'+value.id+'">';
                        // html += '<a href="'+marketingUrl+'" data-chat-identity="'+value.chat_id+'">';

                        html += '<div class="media notification-item">';

                        html += '<div class="media-left"><img src="'+notificationImage+'" alt="..." style="max-width:35px" /></div>';
                        html += '<div class="media-body">';
                        html += '<div class="mail-desc">' + message + '</div>';
                        html += '<div><span class="time">' + value.messageFormattedTime + '</span></div>';
                        html += '</div>';

                        html += '</div>';

                        // html += '</a>';
                        html += '</li>';

                        // if (value.unread == 1) {
                        //     unread = unread + value.unread
                        // }
                        // i++;
                    });

                    $('.notificationsbox').append(html);

                    // if chat page is zero
                    if (chatPage < 1) {
                        chatPage = 1; // assign 1 to chatPage for next increment to 2
                    }

                    chatPage++;
                    $("#chatPage").val(chatPage);

                    initiateNotificationScroll();
                }
                else
                {
                    $("#chatPage").val('');
                }

                // var unreadContainer = $('.unread-alert');
                //
                // if(unread > 0) {
                //     unreadContainer.show();
                //     unreadContainer.html(unread);
                //     $('#unread-total-messages').val(unread);
                // }
                //
                // var currentScrollHeight;
                // if(chatPage > 1)
                // {
                //     $(html).insertAfter('.message-center .chat-list .loader');
                //     // $('.chat-list').prepend(html);
                //
                //     /**
                //      * Action to auto scroll down when chat history
                //      * area height changed.
                //      *
                //      * oldChatHeight = last value which set after chat history load
                //      * newChatHeight = current value of scroll height on chat area.
                //      */
                //     var oldChatHeight = getChatScrollheight();
                //
                //     /**
                //      * Again set new height, may be new messages came in chat area and
                //      * new height does not set, so again set new height.
                //      */
                //     setChatScrollheight();
                //     var newChatHeight = getChatScrollheight();
                //
                //     currentScrollHeight = newChatHeight - oldChatHeight;
                //
                //     /**
                //      * Scroll chat to specific area.
                //      */
                //     chatToBottom(currentScrollHeight);
                // }
                // else {
                //     // $('.message-center .chat-list .loader').after(html);
                //     $(html).insertBefore('.message-center .chat-list .typing-status');
                //     chatToBottom();
                // }
                //
                // if(data !== '')
                // {
                //     // if chat page is zero
                //     if(chatPage < 1)
                //     {
                //         chatPage = 1; // assign 1 to chatPage for next increment to 2
                //     }
                //
                //     chatPage++;
                //     $("#chatPage").val(chatPage);
                // }
                //
                // initiateCustomLibrary();
                // initateTimeScheduler();
                // initiateCarousel();
            }
            else
            {
                if (chatPage == 1) {
                    // $('.notificationsbox').append('<li style="text-align: center;margin-top: 8px;">You have not received any notification yet.</li>');
                    $('.notificationsbox').append('<li style="text-align: center;margin-top: 8px;">There are no notifications</li>');
                    $('.read-all-notification').html('');
                    $('.read-all-notification').removeAttr('id');
                    $('.read-all-notification').removeAttr('style');
                }

                $("#chatPage").val('');
            }
        });
    }
    return false;
}

// $(function()
// {
//     loadChatHistory();
//     var chatList = $('.chat-list');
//
//     // Each time the user scrolls
//     chatList.scroll(function(e) {
//         if (chatList.scrollTop() === 0) {
//             loadChatHistory();
//         }
//     });
//
//     /**
//      * sent messgae when user hit enter on
//      * chat area screen.
//      */
//     $("#chat-message").keyup(function (event) {
//         if (event.keyCode == 13) {
//             $('#send-message').click();
//             return false;
//         }
//     });
//
// });
//
// /**
//  * Load chat history which is between Madison and user.
//  *
//  * @returns {boolean}
//  */
// function loadChatHistory()
// {
//     var baseUrl = $('#hfBaseUrl').val();
//     var chatRetrievalDate = '';
//     var chatPage = $('#chatPage').val();
//
//     $('.chat-list .loader').show();
//
//     $.ajax({
//         headers: {
//             'X-CSRF-TOKEN': $('input[name="_token"]').val()
//         },
//         type: "POST",
//         url: baseUrl + "/retrieve-chat-history",
//         data: {
//             chatNumber: chatPage // Page number
//             // of chat loading
//         }
//     }).done(function (result) {
//         // parse data into json
//         var json = $.parseJSON(result);
//
//         // get data
//         var statusCode = json.status_code;
//         var statusMessage = json.status_message;
//         var messageDay = json.messageDate;
//
//         $('.chat-list .loader').hide();
//
//         if (statusCode === 200) {
//             var html = '';
//             var i = 0;
//             var data = json.data;
//             var unread = 0;
//             $.each(data, function (index, value) {
//
//                 // console.log("chat " + value.ChatId +" va " + value.thirdPartyUrl);
//                 // if (i === 0) {
//                 //     // html += '<li class="message-day">';
//                 //     // html +=     '<p style="text-align:center;">'+ messageDay + '</p>';
//                 //     // html += '</li>';
//                 // }
//
//                 // use as a class
//                 var messageSender = (value.sender === 1) ? 'madison' : 'user';
//
//                 var message = value.message;
//                 message += '<input type="hidden" class="reply-now-val" value="'+value.thirdPartyUrl+'" />';
//
//                 html += showMessageContent(value.ChatId, messageSender, message, true, value.messageFormattedTime, value.action);
//
//                 if(value.unread == 1) {
//                     unread = unread + value.unread
//                 }
//                 i++;
//             });
//
//             var unreadContainer = $('.unread-alert');
//
//             if(unread > 0) {
//                 unreadContainer.show();
//                 unreadContainer.html(unread);
//                 $('#unread-total-messages').val(unread);
//             }
//
//             var currentScrollHeight;
//             if(chatPage > 1)
//             {
//                 $(html).insertAfter('.message-center .chat-list .loader');
//                 // $('.chat-list').prepend(html);
//
//                 /**
//                  * Action to auto scroll down when chat history
//                  * area height changed.
//                  *
//                  * oldChatHeight = last value which set after chat history load
//                  * newChatHeight = current value of scroll height on chat area.
//                  */
//                 var oldChatHeight = getChatScrollheight();
//
//                 /**
//                  * Again set new height, may be new messages came in chat area and
//                  * new height does not set, so again set new height.
//                  */
//                 setChatScrollheight();
//                 var newChatHeight = getChatScrollheight();
//
//                 currentScrollHeight = newChatHeight - oldChatHeight;
//
//                 /**
//                  * Scroll chat to specific area.
//                  */
//                 chatToBottom(currentScrollHeight);
//             }
//             else {
//                 // $('.message-center .chat-list .loader').after(html);
//                 $(html).insertBefore('.message-center .chat-list .typing-status');
//                 chatToBottom();
//             }
//
//             if(data !== '')
//             {
//                 // if chat page is zero
//                 if(chatPage < 1)
//                 {
//                     chatPage = 1; // assign 1 to chatPage for next increment to 2
//                 }
//
//                 chatPage++;
//                 $("#chatPage").val(chatPage);
//             }
//
//             initiateCustomLibrary();
//             initateTimeScheduler();
//             initiateCarousel();
//         }
//     });
//
//     return false;
// }
//
// /**
//  * This method load top 5 google search result and display in carousel.
//  * @param searchFor
//  * @returns {boolean}
//  */
// function loadGoogleSearchResult(searchFor)
// {
//     var baseUrl = $('#hfBaseUrl').val();
//
//     $.ajax({
//         headers: {
//             'X-CSRF-TOKEN': $('input[name="_token"]').val()
//         },
//         type: "GET",
//         url: baseUrl + "/retrieve-google-search",
//         data: {
//             searchFor: searchFor // searching for
//         }
//     }).done(function (result) {
//         // parse data into json
//         var json = $.parseJSON(result);
//
//         // get data
//         var statusCode = json.status_code;
//         var statusMessage = json.status_message;
//
//         if (statusCode === 200) {
//             var html = '';
//             var data = json.data;
//
//             html += '<li class="google-result">';
//             html += '<div id="googleResult" class="carousel slide" data-ride="carousel">';
//
//             html += '<div class="carousel-inner" role="listbox">';
//
//             var i = 0;
//             $.each(data, function (index, value) {
//
//                 var activeSlide = (i == 0) ? 'active' : '';
//
//                 html += '<div class="item '+activeSlide+'">';
//
//                 html += '<div class="google-searche-item">';
//
//                 html += '<h3><a href="' + value.url + '" target="_blank">' + value.title + '</a></h3>';
//                 html += '<h4>' + value.url + '</h4>';
//                 html += '<div class="description">' + value.description + '</div>';
//
//                 html += '</div>'; // google-searche-item
//
//                 html += '</div>'; // item
//
//                 i++;
//             });
//
//             html += '</div>'; //carousel-inner
//
//             html += '<a class="left carousel-control" href="#googleResult" role="button" data-slide="prev"><i class="fa fa-angle-left" aria-hidden="true"></i><span class="sr-only">Previous</span></a>';
//             html += '<a class="right carousel-control" href="#googleResult" role="button" data-slide="next"><i class="fa fa-angle-right" aria-hidden="true"></i><span class="sr-only">Next</span></a>';
//
//             html += '</div></li>';
//
//             $(html).insertBefore('.message-center .chat-list .typing-status');
//
//             initiateBootstrapCarousel();
//             chatToBottom();
//         }
//     });
//
//     return false;
// }
//
// /**
//  * user typed message send by press send button.
//  */
// $('#send-message').click(function()
// {
//     var message = $.trim($('#chat-message').val());
//
//     if (message !== '') {
//         // $("#send-message").attr("disabled", true);
//         var baseUrl = $('#hfBaseUrl').val();
//
//         $('#chat-message').val('');
//         var chatList = $('.chat-list');
//
//         var html = '';
//         html += '<li class="processing-message user">';
//         html +=     '<div class="chat-image"><span><i class="mdi mdi-account"></i></span></div>';
//         html +=     '<div class="chat-body">';
//         html +=         '<div class="chat-text">';
//         html +=             '<p>'+message+'</p>';
//         html +=         '</div>';
//         html +=     chatTime('Just Now');
//         html +=     '</div>';
//
//         html += '</li>';
//
//         $(html).insertBefore('.message-center .chat-list .typing-status');
//
//         chatToBottom();
//
//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': $('input[name="_token"]').val()
//             },
//             type: "POST",
//             url: baseUrl + "/send-madison-message",
//             data: {
//                 message: message
//             }
//         }).done(function (result) {
//                 success(result);
//         });
//         return false;
//     }
//     else {
//         return false;
//     }
// });
//
//
// $(document).on('click','.open-small-chat',function(){
// // $('.unread-alert').click(function()
// // {
//
//     var unreadContainer = $('.unread-alert');
//     var unreadMessages = $('#unread-total-messages').val();
//
//     if (unreadMessages > 0) {
//         // $("#send-message").attr("disabled", true);
//         var baseUrl = $('#hfBaseUrl').val();
//
//         unreadContainer.hide();
//
//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': $('input[name="_token"]').val()
//             },
//             type: "POST",
//             url: baseUrl + "/user-read-message"
//         }).done(function (result) {
//             // parse data into json
//             var json = $.parseJSON(result);
//
//             // get data
//             var statusCode = json.status_code;
//             var statusMessage = json.status_message;
//
//             if(statusCode == 200)
//             {
//                 $('#unread-total-messages').val(0);
//             }
//             else
//             {
//                 console.log(result);
//             }
//
//         });
//         return false;
//
//     }
//
// });
//
// function success(result)
// {
//     // parse data into json
//     var json = $.parseJSON(result);
//
//     // get data
//     var statusCode = json.status_code;
//     var statusMessage = json.status_message;
//
//     $("#send-message").attr("disabled", false);
//
//     var message = '';
//     var html = '';
//     var agentMessage = '';
//     var chatId = '';
//     var agentChatId = '';
//     var messageFormattedTime = '';
//     var agentMessageFormattedTime = '';
//
//     if (statusCode === 200) {
//         var data = json.data;
//
//         // user chat data retrieving
//         message = data[0].message;
//         chatId = data[0].chat_id;
//         messageFormattedTime = data[0].messageFormattedTime;
//
//         // checking agent response
//         if (data[1]) {
//             agentMessage = data[1].message;
//             agentChatId = data[1].chat_id;
//             agentMessageFormattedTime = data[1].messageFormattedTime;
//         }
//         else
//         {
//             agentMessage = 'No Result Found';
//             agentChatId = '';
//             agentMessageFormattedTime = data[0].messageFormattedTime;
//         }
//
//         $('#chat-message').val('');
//
//         if (data[0] !== "") {
//             message = data[0].message;
//         }
//     }
//     else {
//         message = statusMessage
//     }
//
//     $('.processing-message').remove();
//     html += '<li class="user" id="message-'+chatId+'">';
//     html +=     '<div class="chat-image"><span><i class="mdi mdi-account"></i></span></div>';
//     html +=     '<div class="chat-body">';
//     html +=         '<div class="chat-text">';
//     html +=             '<p>'+message+'</p>';
//     html +=         '</div>';
//     html +=     chatTime('Just Now');
//     html +=     '</div>';
//     html += '</li>';
//
//     if(agentMessage !== '')
//     {
//         html += '<li class="madison" id="message-'+agentChatId+'" style="display: none;">';
//         html +=     '<div class="chat-image"><span>M</span></div>';
//         html +=     '<div class="chat-body">';
//         html +=         '<div class="chat-text">';
//         html +=             '<p>'+agentMessage+'</p>';
//         html +=         '</div>';
//         html +=     chatTime('Just Now');
//         html +=     '</div>';
//         html += '</li>';
//     }
//
//     // madison start typing
//
//     // $('.typing-status').show();
//     $( html ).insertBefore('.message-center .chat-list .typing-status');
//     showCentralMessage('.message-center .chat-list');
//
//     /**
//      * This is again confirm that agent response is returned from madison.
//      */
//     if(agentChatId !== '') {
//         /**
//          * this will load top 5 google search result and display in carousel.
//          * message is user message which is used for search from google.
//          */
//         loadGoogleSearchResult(message);
//     }
//     setTimeout(function()
//     {
//         $("#message-"+chatId + " .chat-time").html(messageFormattedTime);
//         if(agentMessage !== '')
//         {
//             $("#message-"+agentChatId + " .chat-time").html(agentMessageFormattedTime)
//         }
//     }, 60000);
//
//     chatToBottom();
// }
//
// function chatToBottom(heightToScroll) {
//     var chatList = $('.message-center .chat-list');
//
//     var scrollTo_int = ( heightToScroll ) ? heightToScroll : chatList.prop('scrollHeight');
//
//     $('.chat-list').slimScroll({
//         scrollTo: scrollTo_int + 'px',
//         height: '400',
//         start: 'bottom',
//         alwaysVisible: true
//     });
//
//     setChatScrollheight();
//
//     return scrollTo_int;
// }
//
//
// function setChatScrollheight()
// {
//     var currentHeight = $('.chat-list').prop('scrollHeight');
//     $('#chatContainerHeight').val(currentHeight);
// }
//
// function getChatScrollheight()
// {
//     return $('#chatContainerHeight').val();
// }
//
// /**
//  * this method give the functionality of chat scheduler.
//  * 1)
//  * marketing task (which add task)
//  * reminder task (set reminder of already added task.)
//  *
//  * 2)
//  * click on a link and open it in a new tab.
//  *
//  * Initiate when:
//  * chat history load [ loadchathistory() ]
//  * when new message appear through ajax and it again initiate [ scheduleResponse(result, chatQueueNumber, thisObj) ]
//  */
// function initiateCustomLibrary()
// {
//     var baseUrl = $('#hfBaseUrl').val();
//
//     // 1)
//     $('.add-marketing, .set-schedule').unbind().click(function()
//     {
//         var message = $(this).val();
//         // var message = 'Add to Marketing Plan';
//
//         var chatQueueNumber = Math.floor(Math.random()*90000) + 10000;
//
//         var html = '';
//         html = transitionMessage(message, chatQueueNumber, $(this));
//
//         var parent = $(this).closest('li').attr('id');
//         parent = parent.replace("message-", "");
//
//         $.ajax({
//             context: this,
//             headers: {
//                 'X-CSRF-TOKEN': $('input[name="_token"]').val()
//             },
//             type: "POST",
//             url: baseUrl + "/set-message-schedule",
//             data: {
//                 message: message,
//                 parent: parent
//             }
//         }).done(function (result) {
//             // $(this).closest('.actions').show();
//             scheduleResponse(result, chatQueueNumber, $(this));
//         });
//     });
//
//     // 2
//     $('.reply-now').click(function()
//     {
//         var messageId = $(this).closest('li').attr('id');
//         var reviewUrl = $('.reply-now-val', '#'+messageId).val();
//
//         if(reviewUrl) {
//             window.open(reviewUrl, '_blank');
//
//             // $('.replyValue', '#'+messageId).click();
//         }
//     });
// }
//
// function transitionMessage(message, chatProcessNumber, thisObj)
// {
//     var html = '';
//
//     html += '<li class="processing-message-'+chatProcessNumber+' user">';
//     html +=     '<div class="chat-image"><span><i class="mdi mdi-account"></i></span></div>';
//     html +=     '<div class="chat-body">';
//     html +=         '<div class="chat-text">';
//     html +=             '<p>'+message+'</p>';
//     html +=         '</div>';
//     html +=     '</div>';
//
//     html += '</li>';
//
//     thisObj.closest('.actions').fadeOut(300, function(){
//         // $(this).remove();
//         thisObj.closest('li').after(html);
//     });
//
//     return html;
// }
//
// function scheduleResponse(result, chatQueueNumber, thisObj)
// {
//     // parse data into json
//     var json = $.parseJSON(result);
//
//     // get data
//     var statusCode = json.status_code;
//     var statusMessage = json.status_message;
//
//     var message = '';
//     var html = '';
//     var chatId = '';
//     var action = '';
//
//     if(statusCode) {
//         if (statusCode === 200) {
//             var data = json.data;
//
//             if (data) {
//                 // user chat data retrieving
//                 message = data.message;
//                 chatId = data.chat_id;
//                 action = data.action;
//             }
//             else {
//                 message = statusMessage;
//             }
//         }
//         else {
//             chatId = 'error';
//             message = statusMessage
//         }
//
//         html = showMessageContent(chatId, 'madison', message, false, '', action);
//
//         $(".processing-message-" + chatQueueNumber).after(html);
//         initiateCustomLibrary();
//         initiateCarousel();
//         initateTimeScheduler();
//     }
// }
//
// function replyButtonFeature()
// {
//     var html = '';
//     html += '<div class="actions margin-top10">';
//     html +=     '<div class="quick-links-list">';
//     html +=         '<div class="item" style="width: 82px;float: left;margin-right: 7px;">';
//     html +=             '<input class="btn btn-sm reply-now" type="button" value="Reply Now" />';
//     html +=             '<input class="btn btn-sm replyValue add-marketing" type="button" value="Reply Now" style="display:none;" />';
//     // html +=          '<a href="https://www.w3schools.com" onclick="window.open(window.location.href, \'_blank\');">Reply Now!</a>';
//     html +=          '</div>';
//     html +=         '<div class="item" style="width: auto;float: left;">';
//     html +=             '<input class="btn btn-sm add-marketing" type="button" value="Add to Marketing Plan" />';
//     html +=          '</div>';
//     html +=     '</div>';
//     html += '</div>';
//
//     return html;
// }
//
//
// function setSchedulerButton()
// {
//     var html = '';
//     html += '<div class="actions margin-top10">';
//     html +=     '<div class="quick-links-list owl-carousel owl-theme">';
//     html +=         '<div class="item">';
//     html +=             '<input class="btn btn-sm set-schedule" type="button" value="No thanks" />';
//     html +=          '</div>';
//     html +=         '<div class="item">';
//     html +=             '<input class="btn btn-sm set-schedule" type="button" value="Today" />';
//     html +=          '</div>';
//     html +=         '<div class="item">';
//     html +=             '<input class="btn btn-sm set-schedule" type="button" value="Tomorrow" />';
//     html +=          '</div>';
//     html +=         '<div class="item">';
//     html +=             '<input class="btn btn-sm showTimePicker" type="button" value="Specify a Due Date" />';
//     html +=             '<input class="btn btn-sm timerValue set-schedule" type="button" value="" style="display:none;" />';
//     html +=          '</div>';
//     html +=     '</div>';
//     html +=         '<input class="schedule-message" type="hidden" value="" />';
//     html += '</div>';
//
//     return html;
// }
//
// function initateTimeScheduler()
// {
//     $('.showTimePicker').click(function()
//     {
//         var html = '';
//
//         var messageId = $(this).closest('li').attr('id');
//
//         html += '<div class="timePickerSelection" data-chat-reference="'+messageId+'">';
//         html +=    '<div class="input-group pickerBox datetimepicker">';
//         html +=        '<input class="timeSelected" value="" type="text" class="form-control" />';
//         html +=        '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
//         html +=     '</div>';
//         html +=    '<div class="menu-action">';
//         html +=       '<div class="close-me"><i class="fa fa-times" aria-hidden="true"></i></div>';
//         html +=       '<div class="done-me"><i class="fa fa-check" aria-hidden="true"></i></div>';
//         html +=    '</div>';
//         html += '</div>';
//
//
//         $(this).closest('.quick-links-list').fadeOut(300, function(){
//             // $(this).remove();
//             $(this).closest('li').after(html);
//
//             $('.close-me').click(function(){
//                 var targetRefId = $(this).closest('.timePickerSelection').attr('data-chat-reference');
//
//                 $(this).closest('.timePickerSelection').fadeOut(300, function(){
//                     // $(this).remove();
//                     $(this).closest('.timePickerSelection').remove();
//                     $('.actions .schedule-message', '#'+targetRefId).val('');
//                     $('.quick-links-list', '#'+targetRefId).show();
//                 });
//             });
//
//             $('.done-me').click(function() {
//                 var targetRefId = $(this).closest('.timePickerSelection').attr('data-chat-reference');
//                 var timerValue = $(this).closest('.timePickerSelection').find('.timeSelected').val();
//
//                 if (timerValue) {
//                     $(this).closest('.timePickerSelection').fadeOut(300, function(){
//                         $(this).closest('.timePickerSelection').remove();
//                         $('.actions .schedule-message', '#' + targetRefId).val(timerValue);
//                         $('.actions .timerValue', '#' + targetRefId).val(timerValue);
//                         $('.actions .timerValue', '#' + targetRefId).click();
//                     });
//                 }
//
//                 // $(this).closest('.timePickerSelection').fadeOut(300, function(){
//                 //     // $(this).remove();
//                 //     $(this).closest('.timePickerSelection').remove();
//                 //     $('.actions .schedule-message', '#'+targetRefId).val('');
//                 //     $('.quick-links-list', '#'+targetRefId).show();
//                 // });
//             });
//
//             initiateTimePicker();
//         });
//
//
//         // html = transitionMessage(message, chatQueueNumber);
//         //
//         // var parent = $(this).closest('li').attr('id');
//         // parent = parent.replace("message-", "");
//     });
// }
//
// function showMessageContent(chatId, messageSender, message, showTime, messageTime, action)
// {
//     var html = '';
//
//     if (messageSender == 'user' || messageSender > 1) {
//         html += '<li class="user" id="message-' + chatId + '">';
//         html += '<div class="chat-image"><span><i class="mdi mdi-account"></i></span></div>';
//     }
//     else {
//         html += '<li class="madison" id="message-' + chatId + '">';
//         html += '<div class="chat-image"><span>M</span></div>';
//     }
//
//     html +=     '<div class="chat-body">';
//     html +=         '<div class="chat-text">';
//     html +=             '<p>'+message+'</p>';
//     html +=         '</div>';
//
//     if(showTime) {
//         var textTime = ( messageTime !== '') ? messageTime : 'Just Now';
//         html += chatTime(textTime);
//     }
//
//     if(action === 'reply_awaiting') {
//         html += replyButtonFeature();
//     }
//     else if(action === 'set_schedule') {
//         html += setSchedulerButton();
//     }
//
//     html +=     '</div>';
//     html += '</li>';
//
//     return html;
// }
//
//
// /**
//  * render chattime with html
//  * @param time
//  * @returns {string}
//  */
// function chatTime(time)
// {
//     var html = '';
//     html += '<div class="chat-time">';
//     html +=  time;
//     html += '</div>';
//
//     return html;
// }

function initiateNotificationScroll()
{
    $('.notificationsbox').slimScroll({
        height: '320px'
    });
}

$(document.body).on('click','#read-all-notification',function(e){
    showPreloader();
    var siteUrl = $('#hfBaseUrl').val();
    $.ajax({
       headers: {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
       },
       type: 'POST',
        url: siteUrl + '/done-me',
       data: {
           send: 'read-all-notification'
       }
    }).done(function(result) {

        var json = $.parseJSON(result);
        var statusCode = json.status_code;
        var statusMessage = json.status_message;
        $('.read-all-notification').html('All Notification\'s Read');
        $('.read-all-notification').removeAttr('id');
        $('.read-all-notification').removeAttr('style');
        if(statusCode == 200){
            location.href = siteUrl + '/monitor-your-reviews';
        }
        else{
            hidePreloader();
            swal({
                title: 'Error',
                type: 'error',
                text: statusMessage
            })
        }
    });

    // $( "ul.notificationsbox .unread" ).each( function( index, element ){
    //     // console.log( 'abc');
    //     $( this ).click();
    // });
});

// var countUnread = 0;
// var countRead = 0;
// setTimeout(function () {
//
//     var target =  $("ul.notificationsbox").find("li");
//     if (target.length > 0) {
//         $( "ul.notificationsbox li" ).each(function( index, element ){
//
//             var classUnreadCheck = $( this ).hasClass('unread');
//             if(classUnreadCheck == true) {
//                 countUnread++;
//             }
//         });
//         $( "ul.notificationsbox li" ).each(function( index, element ){
//
//             var classReadCheck = $( this ).hasClass('read');
//             if(classReadCheck == true) {
//                 countRead++;
//             }
//
//         });
//         if((countUnread) == 0 && (countRead > 0)){
//             $('.read-all-notification').html('All Notification\'s Read');
//         }
//         else if((countUnread > 0) && (countRead > 0)) {
//             $('.read-all-notification').attr('id', 'read-all-notification');
//             $('.read-all-notification').css('cursor', 'pointer');
//             $('#read-all-notification').html('Read All');
//
//         }
//         else{
//             $('.read-all-notification').html('Notification\'s Not Found');
//         }
//     }
// },3500);

