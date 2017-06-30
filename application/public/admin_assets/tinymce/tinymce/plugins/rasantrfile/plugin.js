/**
 *
 * var editor - global editor instance
 *
 */
tinymce.PluginManager.add('rasantrfile', function(editor, url) {
    var align = 'left';

    // toolbar button
    editor.addButton('rasantrfile', {
        icon: '',
        text: 'Antrfile',
        tooltip: 'Insert antrfile',
        stateSelector: 'div[data-antrfile-plugin]',
        cmd: 'rasantrfile_create'
    });

    // context menu button
    editor.addMenuItem('rasantrfile', {
        icon: 'delete',
        text: 'Remove antrfile',
        onPostRender: function() {
            handleDisabledState(this, 'div.antrfilePlugin')
        },
        cmd: 'rasantrfile_remove',
        prependToContext: true
    });

    /**
     * create / edit antrfile command
     * Populates popupObject with necessary data, and passes it to open method of windowManager
     * effectively opening the popup window
     *
     */
    editor.addCommand('rasantrfile_create', function(ui, v) {
        var popupObject, propertiesToAttach;
        popupObject = preparePopupObject();

        propertiesToAttach = {
            window: window,
            editor_id : editor.editor_id,
            popup: popupObject
        };

        popup = editor.windowManager.open(popupObject, propertiesToAttach);
    });

    //remove antrfile command
    editor.addCommand('rasantrfile_remove', function(ui, v) {
        var node = $(tinyMCE.activeEditor.selection.getNode());

        //we need to make sure if user has clicked an image plugin inside of a antrfile
        if (node.closest('.pluginContainer').hasClass('imagePlugin')) {
            console.log('image plugin clicked inside of a antrfile');
            node.closest('.pluginContainer').closest('.antrfilePlugin').remove();
        }

        if (node.closest('.pluginContainer').hasClass('antrfilePlugin')) {
            node.closest('.pluginContainer').remove();
        }
    });

    /**
     * Creates popupObject required for popup creation, and sets all handlers
     * all handlers must be passed through to parent from iframe
     *
     * @return obj popupObject
     */
    function preparePopupObject() {
        var generalFormItems, popupObject, listBox;
        listBox = {type: 'listbox',
            name: 'align',
            id: 'align',
            label: 'Align',
            onclick: function(e) {
                align = this.value();
            },
            'values': [
                {text: 'Left', value: 'left'},
                {text: 'Right', value: 'right'},
                {text: 'Center', value: 'center'}
            ]
        };

        generalFormItems = [
            {name: 'rasantrfile', type: 'textbox', minWidth:500, minHeight:250,
                multiline: true, label: 'Enter text', id: 'rasantrfile'},
            listBox
        ];

        popupObject =
        {
            title : "Create antrfile box",
            width : 700,
            height : 400,
            close_previous : "no",
            resizable: "yes",
            body: [
                {
                    title: 'Embed form',
                    type: 'form',
                    items: generalFormItems
                },
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
        detectPlugin('rasantrfile');
        if ($('#rasantrfile').val() !== '') {
            var container = '<div class="mceNonEditable pluginContainer antrfilePlugin antrfile' + align + '" data-antrfile-plugin="1"><div class="mceEditable">';
            container += '<p>' + $('#rasantrfile').val() + '</p>';
            container += '</div></div>';

            container += '<br />';

            //this "hack" is to make tiny place cursor after plugin placeholder
            //container += '<p class="afterPluginSpace"><span>aaa</span></p>';

            editorGlobal.insertContent(container);
        }
        popup.close();
    }
});