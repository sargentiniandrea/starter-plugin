//----------------------------
//* TABELLA ORARI
//----------------------------

// Ordina orari tabella in ordine numerico, mettendo alla fine gli orari che iniziano dalle 00 alle 03  
(function () {
    var tabOrario = document.querySelectorAll('.tabella-op > tbody > tr > td > .tab-orario');
    tabOrario.forEach(function(node) {
    let div = node.children;
        var orariArr = [].slice.call(div).sort(function (a, b) {
                return a.textContent > b.textContent ? 1 : -1;
        });
        orariArr.forEach((element, i) => {
            let html = element.outerHTML;
            if(html.includes('<div>00') ||html.includes('<div>01') || html.includes('<div>02') || html.includes('<div>03')){
                let index = orariArr.indexOf(element);
                orariArr.push(orariArr.splice(index, 1)[0]);
            };
        });
        orariArr.forEach(function (div) {
            node.appendChild(div);
        });
    });
})();
//-------------------------------