/**
 *
 * var editor - global editor instance
 *
 */
const GALLERY_URL = tinymce.baseURL + '/../../../article/gallery?context=1';
var galleryAction = 'create';

tinymce.PluginManager.add('rasgallery', function(editor, url) {
    editor.addButton('rasgallery', {
        icon: 'none',
        image: url + '../../../../../css/images/galerija_icon.png',
        text: 'Insert gallery',
        tooltip: 'Insert/edit gallery',
        stateSelector: 'div[data-gallery-id]',
        onclick: function() {
            showPopup(editor);
        }
    });

    editor.addMenuItem('rasgallery', {
        text: 'Edit plugin',
        image: url + '../../../../../css/images/galerija_icon.png',
        onPostRender: function() {
            handleDisabledState(this, 'div.galleryPlugin')
        },
        context: 'delete',
        prependToContext: true,
        menu:
            [{
                text: 'Edit this gallery',
                onclick: function() {
                    //return focus to main editor instance
                    editor.focus();
                    showPopup(editor);
                },
                context: 'insert'
            },
                {
                    text: 'Remove gallery',
                    onclick: function() {
                        deletePlugin('galleryPlugin');
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
            && ($(editor.selection.getNode()).hasClass('galleryPlugin'))) {
            //append edit info to path
            popupObject.file += '&galleryId=' +
                $(editor.selection.getNode()).data('galleryId');
            galleryAction = 'update';
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
        var height = $( window ).height() * 9 / 10; //70% with limit on 700px
        if (height > 900) {
            height = 900;
        }
        return {
            file : GALLERY_URL,
            title : "Insert gallery",
            width : $( window ).width() * 9 / 10, //70%
            height : height,
            close_previous : "no",
            resizable: "yes",
            onInit: function(e) {
                init();
            }
        };
    }
});

/**
 * Inserts selected image back into main editor window, closing the popup
 *
 * @return void
 */
function insertGallery(galleryId) {
    //only insert content if creating, editing does not have impact on plugin container
    if (galleryAction === 'create') {
        detectPlugin('rasgallery');
        var container = '<div class="mceNonEditable pluginContainer galleryPlugin" data-gallery-id="' + galleryId + '"></div>';

        //this "hack" is to make tiny place cursor after plugin placeholder
        container += '<br />';

        editorGlobal.insertContent(container);
    }
    popup.close();
}