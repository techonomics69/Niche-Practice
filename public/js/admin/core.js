function showPreloader() {
    var preloader = $('.preloader');
    preloader.show();
    $("body").addClass('hide-overflow');
    preloader.addClass('preloader-opacity');
}


function hidePreloader() {
    var preloader = $('.preloader');
    preloader.removeClass('preloader-opacity');
    $("body").removeClass('hide-overflow');
    preloader.hide();
}

function resetLoaderButton($this) {
    $this.attr("disabled", false);
    $this.html($this.data('original-text'));
}

function showLoaderButton(target, message) {
    // console.log("showLoaderButton");
    var $this = $(target);
    $this.attr("disabled", true);
    var loadingText;

    if(message && message !== '')
    {
        loadingText = '<i class="fa fa-circle-o-notch fa-spin" style="margin-right: 5px;"></i>'+ message +' ...';
    }
    else
    {
        loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> Processing...';
    }

    if ($this.html() !== loadingText) {
        $this.data('original-text', $this.html());
        $this.html(loadingText);
    }

    return $this;
}

/**
 * if value is empty then return true.
 * else not empty return false.
 * @param val
 * @returns {boolean}
 */
function isEmptyValNormal(val) {
    if((!val))
    {
        if(val == 0)
        {
            return false;
        }

        return true;
    }

    return false;
    // return (!val) ? true : false;
}

function dataURItoBlob(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else
        byteString = unescape(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], {type:mimeString});
}
$(document.body).on('click', '.sub-menu', function()
{
    $(this).next(".nav-second-level").slideToggle();
    $(this).find(".dropdown").toggleClass("rotate");
});

// $(document.body).on('click', '.sub-menu', function()
// {
//     $('.sidebar-collapse',this).find(".nav-second-level").stop().slideToggle('slow');
//     $(this).find(".dropdown").toggleClass("rotate");
// });
/*function searchData()
{
    var filter = document.getElementById('intellisearchval').value.toLowerCase();

    var ul = document.getElementById('myList');
    var li = ul.getElementsByTagName('li');

    for(var i=0;i<li.length;i++)
    {
        var a = li[i].getElementsByTagName('a')[0];

        var textValue = a.textContent;

        if(textValue.toLowerCase().indexOf(filter))
        {
            li[i].style.display = '';
        }
        else
        {
            li[i].style.display="none";
        }
    }
}*/
function searchData() {
    let input = document.getElementById('intellisearchval').value;
    input=input.toLowerCase();
    let x = document.getElementsByClassName('listItems');

    for (var i = 0; i < x.length; i++) {
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            x[i].style.display="none";
        }
        else {
            x[i].style.display="list-item";
        }
    }
}
