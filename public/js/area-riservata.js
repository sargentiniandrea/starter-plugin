
//----------------------------
//* AREA RISERVATA
//----------------------------

// Fuzione generale per area utenti
function scriptAreaUtente() {
    rimuoviMinuti();
    containerGiorni();
    bloccaGiorno();
    riposoGiorno();
    moveDescrizioni();
    tabSezioni();
}
//-------------------------------

// Rimuovi tutti i minuti dal timepicker tranne 00 e 30
function rimuoviMinuti(){
    var values = Array.from({length: 59}, (_, i) => i + 1);
    for( var i = 0; i < values.length; i++){ 
        if ( values[i] === 30) { 
            values.splice(i, 1); 
        }
    }
    values.forEach((value, i) => {
        let num = value.toString().padStart(2, '0');
        let fields = document.querySelectorAll('.custom_field_timepicker_minutes option[value="' + num + '"]');
        for (i=0; i < fields.length; i++) {
            fields[i].remove();
        }
    });
}
//-------------------------------

// Crea un container per ogni gruppo di elementi relativo ai singoli giorni
function containerGiorni() {
    let elGiorno = document.getElementsByClassName('li-giorno');
    for (var i = 0; i < elGiorno.length; i++) {
        let giorno = elGiorno[i];
        let nextDiv = getNextUntil(giorno, '.li-giorno, .head-informazioni, .wppb-epaa-admin-actions');
        let container = document.createElement('div');
        container.classList.add('container-giorno', 'step-orari');
        giorno.parentNode.insertBefore(container, giorno);
        container.append(giorno);
        nextDiv.forEach(div => {
            container.append(div); 
        });
    }   
}
function getNextUntil(elem, selector){
    var siblings = [];
	var next = elem.nextElementSibling;
	while (next) {
		if (next.matches(selector)) break;
		siblings.push(next);
		next = next.nextElementSibling
	}
	return siblings;   
}
//-------------------------------

// Aggiunge/rimuove una classe 'orario-bloccato' al contenitore dei campi dei giorni nel momento in cui si seleziona/deseleziona il campo 'Blocca'
function bloccaGiorno() {
    let checkboxes = document.querySelectorAll('.li-blocca input[value="Blocca"]');
    checkboxes.forEach((item) => {
        addClassBlocca(item);
        item.addEventListener("click", function(){
            addClassBlocca(item);  
        });
    });   
}
function addClassBlocca(cb){
    let liBloccaParent = cb.closest(".li-blocca");
    let parentContainer = liBloccaParent.parentElement;
    if(cb.checked){
        parentContainer.classList.add("orario-bloccato");
    } else {
        parentContainer.classList.remove("orario-bloccato");
    }   
}
//-------------------------------

// Aggiunge/rimuove una classe 'riposo' al contenitore dei campi dei giorni nel momento in cui si seleziona/deseleziona il campo 'Riposo'
function riposoGiorno() {
    let checkboxes = document.querySelectorAll('.li-riposo input[value="Si"]');
    checkboxes.forEach((item) => {
        addClassRiposo(item);
        item.addEventListener("click", function(){
            addClassRiposo(item);  
        });
    });   
}
function addClassRiposo(cb){
    let liBloccaParent = cb.closest(".li-riposo");
    let parentContainer = liBloccaParent.parentElement;
    if(cb.checked){
        parentContainer.classList.add("riposo");
    } else {
        parentContainer.classList.remove("riposo");
    }   
}
//-------------------------------

// Sposta descrizione dei campi informazioni come primo elemento
function moveDescrizioni(){
    let arrInfo = ['chi-sono', 'esperienza', 'consulto'];
    arrInfo.forEach(infoClass => {
        let elEs = document.querySelector('.wppb-form-field.wppb-wysiwyg.' + infoClass + ' .wppb-description-delimiter');
        let elTit = document.querySelector('.wppb-form-field.wppb-wysiwyg.' + infoClass + ' > label');
        let txtEs = elEs.innerHTML;
        let txtTit = elTit.innerHTML;
        let container = document.createElement('div');
        container.classList.add('container-ante-info');
        let newHtml = '<div>' + txtTit + '</div><div class="cont-esempio">' + txtEs + '</div>';
        container.innerHTML += newHtml;
        let target = document.querySelector('.wppb-form-field.wppb-wysiwyg.' + infoClass +'');
        target.insertBefore(container, target.children[0]);
    });
}
//-------------------------------

// Pulsanti Orari e Descrizioni su area utenti
function tabSezioni(){
    let btnOrari = document.querySelector('.container-btn-step > .btn-orari');
    let btnInfo = document.querySelector('.container-btn-step > .btn-info');
    let elOrari = document.getElementsByClassName('step-orari'); 
    let elInfo = document.getElementsByClassName('step-info');
    for (let i = 0; i < elInfo.length; i++) {
        let el = elInfo[i];
        el.classList.add('hidden');  
    }
    btnOrari.addEventListener("click", function(){
        btnOrari.classList.add('btn-active');
        btnInfo.classList.remove('btn-active');
        for (let i = 0; i < elOrari.length; i++) {
            let el = elOrari[i];
            el.classList.remove('hidden');  
        }
        for (let i = 0; i < elInfo.length; i++) {
            let el = elInfo[i];
            el.classList.add('hidden');  
        }
    });
    btnInfo.addEventListener("click", function(){
        btnOrari.classList.remove('btn-active');
        btnInfo.classList.add('btn-active');
        for (let i = 0; i < elOrari.length; i++) {
            let el = elOrari[i];
            el.classList.add('hidden');  
        }
        for (let i = 0; i < elInfo.length; i++) {
            let el = elInfo[i];
            el.classList.remove('hidden');  
        }
    });
}
//-----------------------------------------------------------------

scriptAreaUtente();