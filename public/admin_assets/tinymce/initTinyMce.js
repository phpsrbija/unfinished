/**
 * Used to start TinyMce editor on a page.
 *
 * @Usage include this file and call initMce in order to run editor
 *
 * @var bool trusted is current user trusted ? e.g. display different plugins for fully trusted users.
 *
 * Big kudos to tinymce dev team for wonderful editor they created :)
 */
function initMce(selector, width, height, trusted) {
    var plugins = "autolink link lists anchor noneditable autoresize"
        + " searchreplace wordcount insertdatetime nonbreaking textcolor "
        + " save table contextmenu emoticons paste fullscreen media codesample "

        //custom ras plugins
        + " rasfunctions rasimage rasvideo raspost rasantrfile rasbeforeafter";

    // rasgallery raspoll

    var toolbar = "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify "
        + "| bullist numlist outdent indent | link print preview fullpage "
        + "| forecolor backcolor emoticons fullscreen media codesample "
        + " | rasimage | raspost | rasantrfile | rasbeforeafter";

// just add toolbars or plugins for trusted user here
    if (trusted) {
        plugins += " code ";
    }


    tinyMCE.init({
        selector: selector,
        width: width,
        height: height,
        plugins: [
            plugins
        ],
        toolbar: toolbar,
        contextmenu: "undo ",
        removed_menuitems: 'newdocument, paste', //with special thanx to spocke @ tinymce dev team
        browser_spellcheck: true,
        object_resizing: false,
        forced_root_block : 'p', //false for br
        setup : function(editor) {
            editor.on('change', function () {
                $('#body').val(tinyMCE.activeEditor.getContent());
                $('form').trigger('checkform.areYouSure');
            });
            editor.on('init', function(e) { //fires after tinymce init
            });
            editor.on('keydown', function(e) {
                preventPartialPluginDeleting(e);
            });
            editor.on('mousedown', function(e) {
                //only for left mouse click, we still need context menu to render
                if ((e.which === 1) && (!e.dblclick)) {
                    //prevent drag&drop on images and plugins, but NOT antrfile's
                    if (($(e.target).hasClass('editorPlugin') || $(e.target).hasClass('pluginContainer'))
                        && (!$(e.target).hasClass('antrfilePlugin'))){

                        e.preventDefault();
                    }
                }
            });
        },
        content_css: '/css/editorContent.css?v=1',
        popup_css: '/css/popup.css?v=1',
        custom_shortcuts : true,
        plugin_preview_width: '900px',
        plugin_preview_height: '600px',
        autoresize_min_height: height,
        autoresize_max_height: "700px",
        paste_auto_cleanup_on_paste : true,
        paste_remove_styles: true,
        paste_block_drop: false,
        paste_as_text: true,
        paste_word_valid_elements: "b,strong,i,em,h1,h2,h3",
        //debug:true,
        paste_preprocess : function(pl, o) {
            // o.content: Content string containing the HTML from the clipboard
        },
        paste_postprocess : function(pl, o) {
            // o.node.innerHTML: Content DOM node containing the DOM structure of the clipboard
        }
    });
}