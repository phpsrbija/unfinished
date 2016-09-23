$(document).ready(function () {

    $(document).on('click', 'a', function (event) {
        var uri = window.location.pathname + window.location.search;
        var url = $(this).attr("href");
        var fragment = ($(this).data("subcontent") !== undefined); // set only for sub-content

        if (uri != url) {
            if (!fragment) {
                $.pjax.click(event, {container: $("#content")});
            } else {
                $.pjax.click(event, {container: $("#sub-content"), fragment: '#sub-content'});
            }
        }
        else {
            if (!fragment) {
                $.pjax.reload('#content');
            } else {
                $.pjax.reload('#sub-content', {fragment: '#sub-content'});
            }
        }

        event.preventDefault();
    });


    // Eventi koji se sve mogu desiti na pjax
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
        //console.log('popstate madafaka');
    });
});