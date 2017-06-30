/**
 * returns iframe popup container, has to be set each time
 *
 * @return jquery iframe object containing body of the popup window
 */
function getIframe() {
    return $(popup.getContainerElm()).find('iframe')[1];
}

/**
 * Will display menu item only if selector has focus
 * @param ctrl
 * @param selector
 *
 * @return void
 */
function handleDisabledState(ctrl, selector) {
    function bindStateListener() {
        ctrl.visible(editorGlobal.dom.getParent(editorGlobal.selection.getStart(), selector));
        editorGlobal.selection.selectorChanged(selector, function(state) {
            ctrl.visible(state);
        });
    }

    if (editorGlobal.initialized)
        bindStateListener();
    else
        editorGlobal.on('init', bindStateListener);
}

/**
 * Detects placement of selection node, and removes it if required, preventing nesting
 * Special case: adding an image to antrfile is allowed
 *
 * @param originPlugin string plugin name
 *
 * @return void
 */
function detectPlugin(originPlugin) {
    var node = $(tinyMCE.activeEditor.selection.getNode());

    //remove plugin if required
    if (node.closest('.pluginContainer').hasClass('antrfilePlugin')) {
        //image is allowed to be placed
        if (originPlugin !== 'rasimage') {
            removePlugin(node);
        }
    } else if (node.hasClass('editorPlugin') || node.hasClass('pluginContainer') || node.hasClass('mceEditable')) {
        removePlugin(node);
    } else if (node.attr('class') === 'mce-content-body ') {
        //console.log('empty doc');
    } else {
        //console.log('blank space');
    }
}

function removePlugin(node) {
    //if this plugin have a parent we need to remove it
    if (node.closest('.pluginContainer').parents('.pluginContainer').hasClass('mceNonEditable')) {
        //return false;
        node = node.closest('.pluginContainer').parents('.pluginContainer');
    }

    node.closest('.pluginContainer').next('p').remove();
    node.closest('.pluginContainer').remove();
}

/**
 * Takes care about deleting plugins containers. We need to capture all possible delete events that could fire
 * targeting elements inside the container, and ignore them. Allowing only full/clean removal of plugin
 *
 * @TODO backspace can trigger browser's back button when plugin is selected. somebody might kill somebody because of this :)
 * added confirmation in order to prevent this. look for better solution.
 *
 * @param e object jquery event
 */
function preventPartialPluginDeleting(e) {
    var deleteKeyCodes, deleteCtrlKeyCodes, node;
    // valid key codes for possible delete actions
    deleteKeyCodes = [46, 8, 110, 13]; // del, backspace, (numeric del or ','), enter
    deleteCtrlKeyCodes = [86, 88]; // ctrl + v, ctrl + x
    node = $(tinymce.activeEditor.selection.getNode());
    //events with potential to delete elements
    if ((e.ctrlKey && (deleteCtrlKeyCodes.indexOf(e.which) !== -1 ))
        || (deleteKeyCodes.indexOf(e.which) !== -1)) {

        //prevent deleting of plugin elements inside of plugin container; eg. image, or image in antrfile
        if (node.hasClass('pluginContainer')) {
            e.preventDefault();
            return;
        }

        //if node has selection active, prevent enter key
        //covers image, but not poll, beforeafter or gallery
        if ((tinyMCE.activeEditor.selection.getContent({format : 'raw'}).length > 0) && (e.which == 13)) {
            e.preventDefault();
            return;
        }

        //handle deletions inside antrfile plugin
        if (node.closest('.pluginContainer').hasClass('antrfilePlugin') || node.hasClass('imagePlugin')) {
            var contentLength = $(node.closest('.antrfilePlugin')[0]).find('div.mceEditable').html().length;
            var selectionLength = tinyMCE.activeEditor.selection.getContent({format : 'raw'}).length;

            //if pasting (ctrl+v), prevent if something is selected
            if (e.ctrlKey && e.which == 86) {
                if (parseInt(selectionLength) > 5) {
                    e.preventDefault();
                    return;
                } else {
                    return;
                }
            }

            // prevent deleting more content than this plugin has, and if nothing is selected and:
            // a) delete is fired with other than delete key; b) ctrl x is pressed
            if ((selectionLength > contentLength) || (!selectionLength && e.which == 46) ||
                (e.ctrlKey && (deleteCtrlKeyCodes.indexOf(e.which) !== -1 ) && !selectionLength)) {

                e.preventDefault();
                return;
            }
        }

        // chrome is bad. we will remove node manually for it.
        if (tinyMCE.isWebKit && (node.hasClass('editorPlugin') || (node.hasClass('pluginContainer')))) {
            removePlugin(node);
        }
    }
}
/**
 * Safely removes this plugin from editor, WITHOUT adding an undo.
 */
function deletePlugin(selector) {
    var node = $(tinyMCE.activeEditor.selection.getNode());
    var targetNode = $(tinyMCE.activeEditor.selection.getContent());

    // this should cover all cases
    if ($(tinyMCE.activeEditor.getBody()).children(selector).length) {
        $(tinyMCE.activeEditor.getBody()).children(selector).remove();
    }

    if (node.hasClass(selector)) {
        targetNode.remove();
    }

    if (node.closest('.pluginContainer').hasClass(selector)) {
        node.closest('.pluginContainer').remove();
    }
}