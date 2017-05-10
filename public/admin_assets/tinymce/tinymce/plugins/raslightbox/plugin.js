/**
 *
 * var editor - global editor instance
 *
 */
var size = 'fullWidth';
const LIGHTBOX_URL = tinymce.baseURL + '/../../../media/browse?context=3&t=' + Math.random();
const SELECTED_LIGHTBOX_CLASS = 'selectedImage';

tinymce.PluginManager.add('raslightbox', function(editor, url) {
    editor.addButton('raslightbox', {
        text: 'Insert lightbox',
        icon: 'none',
        image: url + '../../../../../css/images/ikonica.png',
        tooltip: 'Insert lightbox',
        shortcut: 'Ctrl+e',
        stateSelector: 'div[data-lightboxId]',
        onclick: function() {
            showPopup(editor);
        }
    });

    editor.addMenuItem('raslightbox', {
        image: url + '../../../../../css/images/ikonica.png',
        text: 'Insert lightbox',
        shortcut: 'Ctrl+e',
        onclick: function() {
            //return focus to main editor instance
            editor.focus();
            showPopup(editor);
        },
        context: 'insert',
        //false for main menu, true for context
        prependToContext: false
    });

    editorGlobal = editor;

    /**
     * Populates popupObject with necessary data, and passes it to open method of windowManager
     * effectively opening the popup. If image was clicked over in order to edit it,
     * it will be replaced with new container
     *
     * @param editor
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

        popup = editor.windowManager.open(popupObject, propertiesToSend);
        editor.windowManager.setParams(popupObject);
    }

    /**
     * Creates popupObject required for popup creation, and sets all handlers
     * all handlers must be passed through to parent from iframe
     *
     * @returns obj popupObject
     */
    function preparePopupObject() {
        var height = $( window ).height() * 9 / 10; //70% with limit on 700px
        if (height > 700) {
            height = 700;
        }
        return {
            file : LIGHTBOX_URL,
            title : "Insert lightbox",
            width : $( window ).width() * 9 / 10, //70%
            height : height,
            close_previous : "no",
            resizable: "yes"
        };
    }
});

/**
 * Inserts selected image back into main editor window, closing the popup
 *
 * @return void
 */
function insertLightbox() {
    var data, container;
    detectPlugin('raslightbox');
    data = $(getIframe()).contents().find('input[name="' + SELECTED_LIGHTBOX_CLASS + '"]').data();
    if (data.size === 0) {
        size = 'halfWidth';
    }
    container = '<div class="mceNonEditable pluginContainer lightboxPlugin ' + size + '" data-lightboxId="'
        + data.imageid + '">';
    container += '<a title="'+ data.alt +'" class="image-link" href="' + data.pathname
        +'" data-lightbox="image" data-title="'+ data.alt +'"';
    container += '<div class="gallery-layover"><i class="fa fa-search"></i></div>';
    container += '<img class="editorPlugin" src="' + data.pathname +'" alt="'+ data.alt +'" /></a>';
    container += '<span class="mceEditable imagePluginDescription">'
        + data.alt + ', Foto: ' + data.photographer + '</span>';
    container += '</div>';

    //this "hack" is to make tiny place cursor after plugin placeholder
    container += '<br />';

    editorGlobal.insertContent(container);
    popup.close();
}