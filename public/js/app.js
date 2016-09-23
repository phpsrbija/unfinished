$(document).ready(function () {

    $(document).on('click', 'a', function (event) {
        var uri = window.location.pathname + window.location.search;
        var url = $(this).attr("href");
        var replace = (uri == url) ? true : false;
        var fragment = ($(this).data("subcontent") !== undefined); // set only for sub-content

        var options = fragment ?
                {container: $("#sub-content"), fragment: '#sub-content', replace: replace} :
                {container: $("#content"), replace: replace};

        $.pjax.click(event, options);
        event.preventDefault();
    });

    // Some events...
    $(document).on('pjax:click	', function () {
        //console.log('klikete bum');
    });

    $(document).on('pjax:send', function () {
        //console.log('send request...');
    })

    $(document).on('pjax:complete', function () {
        //console.log('complete');
    });

    $(document).on('pjax:popstate', function () {
        //console.log('popstate - back/forward');
    });
});