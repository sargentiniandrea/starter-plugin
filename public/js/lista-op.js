
//----------------------------
//* LISTA OPERATORI
//----------------------------

// Fuzione generale per lista cartomanti
function scriptListaCarto() {
    toggleShowHide();
    carto_search();
}
//-------------------------------

// Toggle per mostrare/nascondere box della lista operatori
function toggleShowHide() {
    let showToggleBtn = OPT_LISTA_OP.showToggleBtn;
    if(showToggleBtn == 'si'){
        var initShowItem = parseInt(OPT_LISTA_OP.getShowItem);
        let allBox = document.getElementsByClassName('box-op');
        if(allBox.length > initShowItem){
            var showItem = parseInt(OPT_LISTA_OP.addItemOp);
            var counter = 1;
            let container = document.querySelector('.cont-lista-carto');
            let btnShowMore = document.querySelector('.carto-show-more');
            let btnShowAll = document.querySelector('.carto-show-all');
            let btnShowLess = document.querySelector('.carto-show-less');
            for (let i = initShowItem; i < allBox.length; i++) {
                let box = allBox[i];
                box.classList.add('hide-op');
            }
            btnShowAll.addEventListener("click", function(){
                for (let i = 0; i < allBox.length; i++) {
                    let box = allBox[i];
                    box.classList.remove('hide-op');
                    }
                    btnShowAll.classList.add('hide-btn');
                    btnShowMore.classList.add('hide-btn');
                    btnShowLess.classList.remove('hide-btn');
                    container.scrollIntoView({ behavior: 'smooth', block: 'end'});
            });
            btnShowMore.addEventListener("click", function(){
                for (let i = initShowItem; i < initShowItem + (showItem * counter) && i < allBox.length; i++) {
                    let box = allBox[i];
                    box.classList.remove('hide-op');
                    if(i == (allBox.length - 1)){
                        btnShowAll.classList.add('hide-btn');
                        btnShowMore.classList.add('hide-btn');
                        btnShowLess.classList.remove('hide-btn');   
                        }
                    }
                container.scrollIntoView({ behavior: 'smooth', block: 'end'});
                counter++;
            });
            btnShowLess.addEventListener("click", function(){
                for (let i = initShowItem; i < allBox.length; i++) {
                    let box = allBox[i];
                    box.classList.add('hide-op');
                }
                counter = 1;
                btnShowAll.classList.remove('hide-btn');
                btnShowMore.classList.remove('hide-btn');
                btnShowLess.classList.add('hide-btn');
                container.scrollIntoView({ behavior: 'smooth', block: 'end'});
            });
        }
    }
}
//-------------------------------

// Ricerca corrispondenza box di lista cartomanti da input di testo
function carto_search() {
    let showSearchBar = OPT_LISTA_OP.showSearchBar;
    let showToggleBtn = OPT_LISTA_OP.showToggleBtn;
    if(showSearchBar == 'si'){
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search_carto");
        filter = input.value.toUpperCase();
        tr = document.querySelectorAll(".box-op");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("span");
            if (td) {
            txtValue = td[0].textContent || td[0].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].classList.remove('hide-op');
            } else {
                tr[i].classList.add('hide-op');
            }
            }
        }
        if(showToggleBtn == 'si'){
            let btnShowMore = document.querySelector('.carto-show-more');
            let btnShowAll = document.querySelector('.carto-show-all');
            let btnShowLess = document.querySelector('.carto-show-less');
            let initShowItem = OPT_LISTA_OP.getShowItem;
            let allBox = document.getElementsByClassName('box-op');
            if(filter == ''){
                if(btnShowAll && btnShowMore){
                    btnShowAll.classList.remove('hide-btn');
                    btnShowMore.classList.remove('hide-btn');
                }
                for (let i = initShowItem; i < allBox.length; i++) {
                    let box = allBox[i];
                    box.classList.add('hide-op');
                }
            } else {
                if(btnShowAll && btnShowMore){
                btnShowAll.classList.add('hide-btn');
                btnShowMore.classList.add('hide-btn');
                btnShowLess.classList.add('hide-btn');
                } 
            }
        }
    }
}
//-----------------------------------------------------------------

scriptListaCarto();