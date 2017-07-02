/**
 *
 * var editor - global editor instance
 *
 */
const SELECTED_IMAGE_CLASS = 'selectedImage';
const IMAGES_URL = tinymce.baseURL + '/../../../media/browse?context=2&t=' + Math.random();
var size = 'fullWidth';

tinymce.PluginManager.add('rasimage', function(editor, url) {
    editor.addButton('rasimage', {
        text: 'Insert image',
        icon: 'none',
        image: url + '../../../../../css/images/ikonica.png',
        tooltip: 'Insert image',
        shortcut: 'Ctrl+e',
        stateSelector: 'div[data-image-id]',
        onclick: function() {
            showPopup(editor);
        }
    });

    editor.addMenuItem('rasimage', {
        text: 'Edit plugin',
        icon: 'edit',
        onPostRender: function() {
            handleDisabledState(this, 'div.imagePlugin')
        },
        context: 'delete',
        prependToContext: true,
        menu:
        [{
            text: 'Insert new image',
            onclick: function() {
                //return focus to main editor instance
                editor.focus();
                showPopup(editor);
            },
            context: 'insert'
        },
        {
            text: 'Remove image',
                onclick: function() {
                    deletePlugin('.imagePlugin');
                },
            context: 'delete'
        }]
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
        var height = $( window ).height() * 9 / 10; //90% with limit on 700px
        if (height > 700) {
            height = 700;
        }
        return {
            file : IMAGES_URL,
            title : "Insert image",
            width : $( window ).width() * 9 / 10, //90%
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
 * @TODO when inserting image between plugins it is placed over one of them
 *
 * @return void
 */
function insertImage() {
    var data, container, images;
    detectPlugin('rasimage');
    data = $(getIframe()).contents().find('input[name="' + SELECTED_IMAGE_CLASS + '"]').data();

    var content = renderPluginContent($(getIframe()).contents().find('#lightbox').prop('checked'), data);

    container = '<div class="mceNonEditable pluginContainer imagePlugin ' + size + '" data-image-id="'
        + data.imageid + '">';

    container += content;
    container += '<span class="mceEditable image-plugin-description">'
        + data.alt + ', Foto: ' + data.photographer + '</span>';
    container += '</div>';

    //this "hack" is to make tiny place cursor after plugin placeholder
    container += '<br />';

    // Load external script
    var scriptLoader = new tinymce.dom.ScriptLoader();
    scriptLoader.add('/resources/js/adaptive/jquery-picture.js?v=2');
    scriptLoader.loadQueue(function() {
        editorGlobal.insertContent(container);
        popup.close();

        $('figure.editorPlugin').ready(function() {
            var figure = $(images).find('figure');
            $("iframe").contents().find("figure").picture();
        });
    });
}

function renderPluginContent(lightbox, data) {
    var content;
    if (lightbox) {
        content = '<a class="image-link" data-title="' + data.alt + '" title="' + data.alt + '" data-lightbox="singleImage-set"'
            + ' href="' + data.pathname3 +'"> '
            + '<img class="editorPlugin" src="' + data.pathname2 + '" alt="' + data.alt + '" />'
            + '</a>';
    } else {
        content = '<figure class="editorPlugin" title="' + data.alt + '"';
        content += 'data-media="' + data.pathname1 + '"';
        content += 'data-media440="' + data.pathname2 + '"';

        if (data.size === 1) {
            size = 'halfWidth';
            content += 'data-media900="' + data.pathname1 + '">';
        } else {
            content += 'data-media900="' + data.pathname3 + '">';
        }

        content += '</figure>'
            + '<noscript>'
            + '<img class="editorPlugin" src="' + data.pathname1 + '" alt="' + data.alt + '" />'
            + '</noscript>';
    }

    return content;
}