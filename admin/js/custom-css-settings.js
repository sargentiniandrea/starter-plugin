
/*
 * Javscript per pagina impostazioni Editor lista operatori.
 */

jQuery(document).ready( function($){

    // Impostazioni per editor Code Mirror

    var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
                editorSettings.codemirror = _.extend(
                    {},
                    editorSettings.codemirror,
                    {
                        indentUnit: 2,
                        tabSize: 2,
                        mode: 'css',
                    }
                );
    let editorCss = wp.codeEditor.initialize($('#editor-css-ar'), editorSettings);

});

