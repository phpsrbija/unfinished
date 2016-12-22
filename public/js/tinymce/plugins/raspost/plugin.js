/**
 *
 * var editor - global editor instance
 *
 */
var embedCodeContainer = '', intervalId = '', savedParagraph = '';
tinymce.PluginManager.add('raspost', function(editor, url) {
    editor.addButton('raspost', {
        icon: '',
        text: 'Embed post',
        tooltip: 'Embed post',
        stateSelector: 'div[data-post-plugin]',
        onclick: function() {
            showPopup(editor);
        }
    });

    editor.addMenuItem('raspost', {
        text: 'Edit plugin',
        onPostRender: function() {
            handleDisabledState(this, 'div.postPlugin')
        },
        context: 'delete',
        prependToContext: true,
        menu:
        [{
            text: 'Edit this post',
            onclick: function() {
                //return focus to main editor instance
                editor.focus();
                showPopup(editor);
            },
            context: 'insert'
        },
        {
            text: 'Remove post',
            onclick: function() {
                deletePlugin('postPlugin');
            },
            context: 'delete'
        }]
    });

    /**
     * Populates popupObject with necessary data, and passes it to open method of windowManager
     * effectively opening the popup
     *
     * @param editor
     *
     * @return void
     */
    function showPopup (editor) {
        var popupObject, propertiesToSend;
        popupObject = preparePopupObject();

        propertiesToSend = {
            window: window,
            editor_id : editor.editor_id,
            popup: popupObject
        };
        popupObject.scrollbars = true;

        popup = editor.windowManager.open(popupObject, propertiesToSend);

        //attach paste handler to embed field in order to save embed code which needs to be entered in article body
        //preview is only rendered for admin to see it
        $(popup.getEl()).find('#embedPost').on('input', function() {
            appendPreview();
        });
    }

    /**
     * Creates popupObject required for popup creation, and sets all handlers
     * all handlers must be passed through to parent from iframe
     *
     * @return obj popupObject
     */
    function preparePopupObject() {
        var popupObject;
        var container = '<div style="float:left;width:30%;margin-right:40px;height:500px">' +
            '<textarea id="embedPost" style="border:solid 1px lightgray;width:100%;height:100%" name="embedPost"></textarea></div>' +
            '<div id="previewPost" style="float:left;height:100%;"></div>';

        popupObject =
        {
            title : "Embed post",
            width : 900,
            height : 550,
            close_previous : "no",
            resizable: "yes",
            autoscroll: "yes",
            body: [
                {
                    title: 'Embed form',
                    type: 'panel',
//                    layout: 'grid',
                    html: container
                }
            ],
            buttons: [{
                text: "Close",
                onclick: function() {
                    tinymce.activeEditor.windowManager.close();
                }
            },
            {
                text: "Insert",
                onclick: function(e) {
                    insertContent();
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
        detectPlugin('raspost');
        if ($('#embedPost').val() !== '') {
            var container = '<div class="mceNonEditable pluginContainer postPlugin embed-responsive clearfix '
                + detectVideoType($('#embedPost').val()) + '" data-post-plugin="1">';
            if (detectVideoType($('#embedPost').val()) === 'cocaColaPost') {
                container += '<img src="' + $('#embedPost').val() + '" width="100%" alt="coca cola">';
            } else {
                container += $('#embedPost').val();
            }
            container += '</div>';
            //this "hack" is to make tiny place cursor after plugin placeholder
            container += '<br />';

            editorGlobal.insertContent(container);
        }
        popup.close();
    }

    function detectVideoType(embedCode) {
        var type = 'unknown notSelfResponsive';

        if (embedCode.indexOf('facebook') !== -1) {
            type = 'facebookPost';
        } else if (embedCode.indexOf('twitter-tweet') !== -1) {
            type = 'twitterPost';
        } else if (embedCode.indexOf('imgur.com') !== -1) {
            type = 'imgurPost';
        } else if (embedCode.indexOf('instagram') !== -1) {
            type = 'instagramPost';
        } else if (embedCode.indexOf('mvp') !== -1) {
            type = 'onetVideo';
        } else if ((embedCode.indexOf('d2ue81d0nkdkc0.cloudfront.net') !== -1) && (embedCode.indexOf('/image.gif') !== -1)) {
            type = 'cocaColaPost notSelfResponsive';
        } else if (embedCode.indexOf('vine') !== -1) {
            type = 'vinePost';
        } else if (embedCode.indexOf('giphy')) {
            type = 'giphyPost notSelfResponsive';
        } else if (embedCode.indexOf('vimeo') !== -1) {
            type = 'vimeoPost';
        } else if (embedCode.indexOf('vine.co') !== -1) {
            type = 'vinePost';
        } else if ((embedCode.indexOf('you.') !== -1) || (embedCode.indexOf('youtube') !== -1)) {
            type = 'youtubePost';
        }

        return type;
    }

    function appendPreview() {
        embedCodeContainer = $('#embedPost').val();
        $('#previewPost').html(embedCodeContainer);
    }
});
