/*
* Script da utilizzare per il pannello di controllo Admin
*/

// Profile Builder
let inputLicenza = document.getElementById('wppb_license_key');
if(inputLicenza){
    inputLicenza.setAttribute("type", "text");
}


/*
 * Logica condizionale per i campi della pagina di impostazioni
 */

// Pagina lista operatori
let selectToggle = document.getElementById('lista_operatori[toggle_btn_lista_op]');
let subSelectToggle = document.querySelectorAll('.show_item_operatori, .add_item_operatori');

if(selectToggle && subSelectToggle){
showSubFieldsSettings(selectToggle, subSelectToggle);

selectToggle.addEventListener("change", (e)=>{
    showSubFieldsSettings(selectToggle, subSelectToggle);
});

function showSubFieldsSettings(select, subSelect){
    if(select.value == 'si'){
        subSelect.forEach(element => {
            element.style.display = "table-row";
        });
    } else {
        subSelect.forEach(element => {
            element.style.display = "none";
        });
    }  
}
}

/*
 * funzioni generali
 */

// Sostituisce in tempo reale i doppi apici con il singolo apice nell'input dello shortcode per il template del singolo operatore
let inputShortcode = document.getElementById('impostazioni_generali[shortcode_single_op]');

if(inputShortcode){
inputShortcode.addEventListener("keyup", (e)=>{
    replaceQuotes(inputShortcode);
});
inputShortcode.addEventListener("change", (e)=>{
    replaceQuotes(inputShortcode);
});
inputShortcode.addEventListener("click", (e)=>{
    replaceQuotes(inputShortcode);
});
function replaceQuotes(inputShortcode){
    let str = inputShortcode.value; 
    let res = str.replace(/"/g, "'")
    inputShortcode.value = res;
}
}
