/**
 *
 * var editor - global editor instance
 *
 */
var URL = tinymce.baseURL + '/../../../article/beforeAfter?context=1&t=' + Math.random();

tinymce.PluginManager.add('rasbeforeafter', function(editor, url) {
    editor.addButton('rasbeforeafter', {
        text: 'Before/after',
        icon: 'none',
        image: url + '../../../../../css/images/ikonica.png',
        tooltip: 'Insert image',
        stateSelector: 'div[data-before-after-id]',
        onclick: function() {
            showPopup(editor);
        }
    });

    editor.addMenuItem('rasbeforeafter', {
        text: 'Edit plugin',
        image: url + '../../../../../css/images/ikonica.png',
        onPostRender: function() {
            handleDisabledState(this, 'div.beforeAfterPlugin')
        },
        context: 'delete',
        prependToContext: true,
        menu:
        [{
            text: 'Create new before/after',
            onclick: function() {
                //return focus to main editor instance
                editor.focus();
                showPopup(editor);
            },
            context: 'insert'
        },
        {
            text: 'Remove before/after',
            onclick: function() {
                deletePlugin('beforeAfterPlugin');
            },
            context: 'delete'
        }]
    });

    /**
     * Populates popupObject with necessary data, and passes it to open method of windowManager
     * effectively opening the popup. If image was clicked over in order to edit it,
     * it will be replaced with new container
     *
     * @TODO editing this plugin does not work
     *
     * @param editor
     * @return void
     */
    function showPopup (editor) {
        var popupObject, propertiesToSend;
        popupObject = preparePopupObject();

        // are we updating ?
        if (($(editor.selection.getNode()).hasClass('mceNonEditable'))
            && ($(editor.selection.getNode()).hasClass('beforeAfterPlugin'))) {

            var orientation = 1;
            if ($(editor.selection.getNode()).hasClass('vertical')) {
                orientation = 0;
            }

            //append edit info to path
//            popupObject.file += '&beforeAfterId=' + $(editor.selection.getNode()).data('before-after-id')
//                + '&orientation=' + orientation;
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
     * @returns obj popupObject
     */
    function preparePopupObject() {
        var height = $( window ).height() * 9 / 10; //90% with limit on 700px
        if (height > 700) {
            height = 700;
        }
        return {
            file : URL,
            title : "Insert before/after widget",
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
 * Inserts content into main editor window, closing the popup
 *
 * @return void
 */
function insertBeforeAfterWidget() {
    detectPlugin('rasbeforeafter');

    var before = $(getIframe()).contents().find('input[name="before"]').data();
    var after = $(getIframe()).contents().find('input[name="after"]').data();
    var orientation = $(getIframe()).contents().find('input:checked').attr('id');

    var beforeImage = '<figure class="editorPlugin" title="' + before.alt + '"';
    beforeImage += 'data-media="' + before.pathname1 + '"';
    beforeImage += 'data-media440="' + before.pathname2 + '"';
    beforeImage += 'data-media900="' + before.pathname3 + '">';
    beforeImage += '</figure>'
        + '<noscript>' + '<img class="editorPlugin" src="' + before.pathname2
        + '" alt="' + before.alt + '" />' + '</noscript>';

    var afterImage = '<figure class="editorPlugin" title="' + after.alt + '"';
    afterImage += 'data-media="' + after.pathname1 + '"';
    afterImage += 'data-media440="' + after.pathname2 + '"';
    afterImage += 'data-media900="' + after.pathname3 + '">';
    afterImage += '</figure>'
        + '<noscript>' + '<img class="editorPlugin" src="' + after.pathname2
        + '" alt="' + after.alt + '" />' + '</noscript>';

    var container = '<div class="mceNonEditable pluginContainer beforeAfterPlugin ' + orientation + '"'
        + 'data-before-after-id="' + before.beforeAfterId + '">' + beforeImage + afterImage
    + '</div>';

    //this "hack" is to make tiny place cursor after plugin placeholder
    container += '<br />';

    // Load external script
    var scriptLoader = new tinymce.dom.ScriptLoader();
    scriptLoader.add('/resources/js/adaptive/jquery-picture.js?v=2');
    scriptLoader.loadQueue(function() {
        editorGlobal.insertContent(container);
        popup.close();

        $('figure.editorPlugin').ready(function() {
            $("iframe").contents().find("figure").picture();
        });
    });
}