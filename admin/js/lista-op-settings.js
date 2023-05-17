
/*
 * Javscript per pagina impostazioni Editor lista operatori.
 */

jQuery(document).ready( function($){

    // Impostazioni per editor Code Mirror
    let editorHtml = wp.codeEditor.initialize($('#editor-template-lista-op-html'), cm_settings);

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
    let editorCss = wp.codeEditor.initialize($('#editor-template-lista-op-css'), editorSettings);

    // Creazione preview con aggiornamento in tempo reale
    var delay;
    var previewContainer = document.querySelector('.container-lista-op');
    for (let index = 0; index < 8; index++) {
        let newDivPrev = document.createElement('div');
        newDivPrev.classList.add('box-op');
        previewContainer.appendChild(newDivPrev);
    }

    $(document).on('keyup', '.CodeMirror-code', function(){
        clearTimeout(delay);
        delay = setTimeout(updatePreview, 500);
    });

    function updatePreview() {
        var previewContainerStyle = document.querySelector('.container-style-preview');
        previewContainerStyle.innerHTML = '<style>' + editorCss.codemirror.getValue() + '</style>';
        var previewContainerDiv = document.querySelectorAll('.container-lista-op > div');
        previewContainerDiv.forEach(div => {
            div.innerHTML = editorHtml.codemirror.getValue();    
        });
    }
    setTimeout(updatePreview, 500);

});

//---------------------------------------------------------------------


// Aggiunta classe colonne a container anteprima
let selectCol = document.getElementById('editor-template-lista-op-col');
let valSelectCol = selectCol.value;
let containerLista = document.querySelector('.container-lista-op');
if(selectCol && containerLista){
    containerLista.classList.add('preview-col-' + valSelectCol);
    selectCol.addEventListener("change", (e)=>{
        containerLista.classList.remove('preview-col-' + valSelectCol);
        valSelectCol = selectCol.value;
        containerLista.classList.add('preview-col-' + valSelectCol);
    });
}

// Aggiunta classe gap a container anteprima
let selectGap = document.getElementById('editor-template-lista-op-gap');
let valSelectGap = selectGap.value;
valSelectGap = valSelectGap.replace(".", "_");
if(selectGap && containerLista){
    containerLista.classList.add('preview-gap-' + valSelectGap);
    selectGap.addEventListener("change", (e)=>{
        containerLista.classList.remove('preview-gap-' + valSelectGap);
        valSelectGap = selectGap.value;
        valSelectGap = valSelectGap.replace(".", "_");
        containerLista.classList.add('preview-gap-' + valSelectGap);
    });
}
