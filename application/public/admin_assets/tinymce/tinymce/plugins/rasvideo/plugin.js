/**
 *
 * var editor - global editor instance
 *
 */
tinymce.PluginManager.add('rasvideo', function(editor, url) {
    editor.addButton('rasvideo', {
        icon: 'none',
        image: url + '../../../../../css/images/flash_icon.png',
        text: 'Embed video',
        tooltip: 'Insert video from another site',
        stateSelector: 'div[data-video-plugin]',
        onclick: function() {
            showPopup(editor);
        }
    });

    editor.addMenuItem('rasvideo', {
        text: 'Edit plugin',
        image: url + '../../../../../css/images/flash_icon.png',
        onPostRender: function() {
            handleDisabledState(this, 'div.videoPlugin')
        },
        context: 'delete',
        prependToContext: true,
        menu:
        [{
            text: 'Edit this video',
            onclick: function() {
                //return focus to main editor instance
                editor.focus();
                showPopup(editor);
            },
            context: 'insert'
        },
        {
            text: 'Remove video',
            onclick: function() {
                deletePlugin('videoPlugin');
            },
            context: 'delete'
        }]
    });

    /**
     * Populates popupObject with necessary data, and passes it to open method of windowManager
     * effectively opening the popup.
     * Supports adding video title, while supporting legacy containers which do not have that entry.
     * Any legacy video will be editable, with option to add title to it. cms issue #15
     *
     * @return void
     */
    function showPopup () {
        var popupObject, propertiesToSend;
        popupObject = preparePopupObject();

        propertiesToSend = {
            window: window,
            editor_id : editor.editor_id,
            popup: popupObject
        };

        popup = editor.windowManager.open(popupObject, propertiesToSend);

        //editing, so insert existing code in embed video container
        if (($(editor.selection.getNode()).hasClass('mceNonEditable'))
            && ($(editor.selection.getNode()).hasClass('videoPlugin'))
            && ($(editor.selection.getNode()).html() !== '')) {

            //insert code in popup and trigger preview
            $('#embedVideo').ready(function() {
                $('#embedVideo').html($(editor.selection.getNode()).html()).promise().done(function(e) {
                    //enable auto preview when editing
                    $('#previewVideo').html($('#embedVideo').val());
                    $('#videoTitle').val($(editor.selection.getNode()).data('title'));
                });
            });
        }
    }

    /**
     * Creates popupObject required for popup creation, and sets all handlers
     * all handlers must be passed through to parent from iframe
     *
     * @return object popupObject
     */
    function preparePopupObject() {
        var popupObject;
        var container ='<div style="overflow: hidden;padding:0 0 20px 40px;">' +
            '<label for="videoTitle" style="display:block;float:left">Unesite naslov videa:</label>' +
            '<input type="text" value="" size="20" id="videoTitle" name="videoTitle" style="float:left;width:400px;border:1px solid lightgray;height:30px;" /></div>' +

            '<div style="float:left;width:32%;margin-right:20px;height:480px">' +
            '<label for="embedVideo" style="display:block;">Unesite embed kod:</label>' +
            '<textarea id="embedVideo" style="border:solid 1px lightgray;width:100%;height:95%;white-space:normal;" name="embedVideo"></textarea></div>' +

            '<div id="previewVideo" style="float:left;height:83%;width:65%"></div>';

        popupObject =
        {
            title : "Embed video",
            width : 900,
            height : 550,
            close_previous : "no",
            resizable: "yes",
            autoscroll: "yes",
            body: [
                {
                    title: 'Enter embed code',
                    type: 'panel',
                    html: container
                }
            ],
            buttons: [
            {
                text: "Preview",
                onclick: function(e) {
                    previewVideo();
                }
            },
            {
                text: "Insert",
                onclick: function(e) {
                    insertContent();
                }
            },
            {
                text: "Close",
                onclick: function() {
                    tinymce.activeEditor.windowManager.close();
                }
            }]
        };

        return popupObject;
    }

    /**
     * Inserts code back into main editor window, closing the popup
     *
     * @return void
     */
    function insertContent() {
        //determine videoId
        var videoId = null;
        if (typeof $(tinyMCE.activeEditor.selection.getNode()).data('bodyVideoId') !== 'undefined') {
            videoId = $(tinyMCE.activeEditor.selection.getNode()).data('bodyVideoId');
        }
        detectPlugin('rasvideo');
        if ($('#embedVideo').val() !== '') {
            var articleId = null;
            if (typeof getParams()['articleId'] !== "undefined") {
                articleId = getParams()['articleId'];
            }

            var data = {
                'code': $('#embedVideo').val(),
                'title': $('#videoTitle').val(),
                'articleId': articleId,
                'videoId': videoId
            };
            $.post('/backend/article/saveVideo', data, function(videoId) {
                if (videoId) {
                    var container = '<div class="mceNonEditable pluginContainer videoPlugin videoWrapper twelvecol '
                        + detectVideoProvider($('#embedVideo').val()) + '" data-video-plugin="1" data-title="'
                        + $('#videoTitle').val() + '" data-body-video-id="' + videoId + '">';
                    container += $('#embedVideo').val();
                    container += '</div>';

                    //this "hack" is to make tiny place cursor after plugin placeholder
                    container += '<p><br data-mce-bogus="1"></p>';

                    editorGlobal.insertContent(container);
                    popup.close();
                } else {
                    alert('Failed to save video.');
                }
            });
        } else {
            popup.close();
        }
    }

    function detectVideoProvider(embedCode) {
        var type = 'unknown';
        if ((embedCode.indexOf('you.') !== -1) || (embedCode.indexOf('youtube') !== -1)) {
            type = 'youtubeVideo';
        } else if (embedCode.indexOf('vimeo') !== -1) {
            type = 'vimeoVideo';
        } else if (embedCode.indexOf('facebook') !== -1) {
            type = 'facebookVideo';
        } else if (embedCode.indexOf('dailymotion') !== -1) {
            type = 'dailymotionVideo';
        } else if (embedCode.indexOf('vine.co') !== -1) {
            type = 'vineVideo';
        } else if (embedCode.indexOf('liveleak') !== -1) {
            type = 'liveleakVideo';
        } else if (embedCode.indexOf('break.com') !== -1) {
            type = 'breakVideo';
        } else if (embedCode.indexOf('mvp') !== -1) {
            type = 'onetVideo';
        }

        return type;
    }

    function previewVideo() {
        $('#previewVideo').html($('#embedVideo').val());
    }
});