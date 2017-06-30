/**
 *
 * var editor - global editor instance
 *
 */
const POLL_URL = tinymce.baseURL + '/../../../article/poll?context=1';
var pollAction = 'create';

tinymce.PluginManager.add('raspoll', function(editor, url) {
    editor.addButton('raspoll', {
        icon: 'none',
        image: url + '../../../../../css/images/poll_icon.png',
        text: 'Insert poll',
        tooltip: 'Insert/edit poll',
        stateSelector: 'div[data-poll-id]',
        onclick: function() {
            showPopup(editor);
        }
    });

    editor.addMenuItem('raspoll', {
        text: 'Edit plugin',
        image: url + '../../../../../css/images/poll_icon.png',
        onPostRender: function() {
            handleDisabledState(this, 'div.pollPlugin')
        },
        context: 'delete',
        prependToContext: true,
        menu:
            [{
                text: 'Edit this poll',
                onclick: function() {
                    //return focus to main editor instance
                    editor.focus();
                    showPopup(editor);
                },
                context: 'insert'
            },
                {
                    text: 'Remove poll',
                    onclick: function() {
                        deletePlugin('pollPlugin');
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

        // are we updating ?
        if (($(editor.selection.getNode()).hasClass('mceNonEditable'))
        && ($(editor.selection.getNode()).hasClass('pollPlugin'))) {
            //append edit info to path
            popupObject.file += '&pollId=' +
                $(editor.selection.getNode()).data('pollId');
            pollAction = 'update';
        }

        propertiesToSend = {
            window: window,
            editor_id : editor.editor_id,
            popup: popupObject
        };

        popup = editor.windowManager.open(popupObject, propertiesToSend);
    }

    /**
     * Creates popupObject required for popup creation, and sets all handlers
     * all handlers must be passed through to parent from iframe
     *
     * @return obj popupObject
     */
    function preparePopupObject() {
        var popupObject =
        {
            file : POLL_URL,
            title : "Insert/edit poll",
            width : 1200,
            height : 700,
            close_previous : "no",
            resizable: "yes",
            // events
            onInit: function(e) {
                init();
            }
        };

        return popupObject;
    }
});

/**
 * Inserts selected poll back into main editor window, closing the popup.
 * Replaces any plugin that is selected in active editor.
 *
 * @return void
 */
function insertPoll(pollId) {
    //only insert content if creating, editing does not have impact on plugin container
    if (pollAction === 'create') {
        detectPlugin('raspoll');
        var container = '<div class="mceNonEditable pluginContainer pollPlugin twelvecol" data-poll-id="' + pollId + '"></div>';

        //this "hack" is to make tiny place cursor after plugin placeholder
        container += '<br />';

        editorGlobal.insertContent(container);
    }
    popup.close();
}