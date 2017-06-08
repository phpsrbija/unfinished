//can come from config and be a 'global' var
//var facebookAppId = 221979587895376; //test
var facebookAppId = 714501398737847;

window.fbAsyncInit = function(){
    FB.init({appId: facebookAppId, status: true, cookie: true, xfbml: true });
};

(function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if(d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id;
    js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
    ref.parentNode.insertBefore(js, ref);
}(document, /*debug*/ false));

function postToFbFeed(title, url, image){
    var obj = {method: 'feed', link: url, picture: image, name: title, app_id: facebookAppId}; //, description: desc
    function callback(response){}
    FB.ui(obj, callback);
}

function postToTwitter(title, link) {
    var url = 'http://twitter.com/home?status=' + encodeURIComponent(title + ' => ' + link);

    window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=400')
}

function postToLinkedIn(title, link) {
    var url = 'http://www.linkedin.com/shareArticle?mini=true&title=' + encodeURIComponent(title) + '&url=' + link
        + '&source=PHP%20Srbija';

    window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=400')
}

function getFacebookEngagementCount(url) {
    var count = 0;
    $.get(url, function(json) {
        if (typeof json.share != "undefined") {
            count = JSON.stringify(json.share.share_count);
            count += JSON.stringify(json.share.comment_count);
        }
    }, 'JSON');

    return count;
}

function getLinkedInEngagementCount(url) {
    var count = 0;
    $.get(url, function(json) {
        if (typeof json.count != "undefined") {
            count = json.count;
        }
    }, 'JSON');

    return count;
}

function setSocialEngagementCount(element) {
    var count = 0;
    var lnUrl = 'http://www.linkedin.com/countserv/count/share?url=' + element.prop('href') + '&format=json';
    var fbUrl = 'http://graph.facebook.com/v2.2/?id=' + element.prop('href') + '&fields=og_object{engagement}';
    count += getFacebookEngagementCount(fbUrl);
    // count += getLinkedInEngagementCount(lnUrl); cors.....

    $('.total-shares').html(count);
}

$(document).ready(function() {
    $('.facebook-share').click(function(e) {
        e.preventDefault();
        var elem = $(this).parent();
        postToFbFeed(elem.data('title'), elem.prop('href'), elem.data('image'));
    });

    $('.facebook-share-list').click(function(e) {
        e.preventDefault();
        var elem = $(this).parent().parent();
        postToFbFeed(elem.data('title'), elem.prop('href'), elem.data('image'));
    });

    $('.twitter-share').click(function(e) {
        e.preventDefault();
        var elem = $(this).parent();
        postToTwitter(elem.data('title'), elem.prop('href'));
    });

    $('.linkedin-share').click(function(e) {
        e.preventDefault();
        var elem = $(this).parent();
        postToLinkedIn(elem.data('title'), elem.prop('href'));
    });

    if ($('.social-icons a').length > 0) {
        setSocialEngagementCount($('.social-icons a'));
    }
});