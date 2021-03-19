function affichBien(nombre) {
    return nombre < 10 ? '0' + nombre : nombre;
}

function dateEtHeure() {
    console.log("je suis laaaaaaa");
    const date = new Date();
    document.getElementById('heure_exacte').innerHTML = 'Nous sommes le ' + date.getDate() + ' et il est : ' + affichBien(date.getHours()) + ':' + affichBien(date.getMinutes()) + ':' + affichBien(date.getSeconds());

    let dateDimanche = new Date();
    if (date.getDay() != 0) {
        dateDimanche.setDate(date.getDate()-date.getDay()+7); // permet de récuperer la date du prochain dimanche
    }
    else {
        dateDimanche.setDate(date.getDate()); // permet de récuperer la date du prochain dimanche
    }

    dateDimanche.setHours(23);
    dateDimanche.setMinutes(59);
    dateDimanche.setSeconds(59);

    let nbrHeuresAvDimanche, nbrMinutesAvDimanche, nbrSecondesAvDimanche;

    if (date.getDay() != 0) {
        nbrHeuresAvDimanche   = (  (7 - date.getDay()) * 24) + (24 - date.getHours()        );
        nbrMinutesAvDimanche  = (( (7 - date.getDay()) * 60) + (60 - date.getMinutes())) % 60;
        nbrSecondesAvDimanche = (( (7 - date.getDay()) * 60) + (60 - date.getSeconds())) % 60;
    }
    else {
        nbrHeuresAvDimanche   =  24 - date.getHours();
        nbrMinutesAvDimanche  = (60 - date.getMinutes());
        nbrSecondesAvDimanche = (60 - date.getSeconds());
    }


    document.getElementById('date_dimanche').innerHTML = '<br/>Le classement se réinitialise dans : ' + nbrHeuresAvDimanche   + "h "      +
                                                                                                        nbrMinutesAvDimanche  + "min et " +
                                                                                                        nbrSecondesAvDimanche + "s";

    /*if(nbrHeuresAvDimanche === 0 && nbrMinutesAvDimanche === 0 && nbrSecondesAvDimanche === 1) {
        //utiliser une méthode qui remet tous les scores à 0
    }*/
}


/*function insert(tab) {
    var tag = document.getElementById("tag");
    tab.push(tag.value);
    alert(tab);
    return tab;
}*/

let i = 1;

function dateEtHeureMin() {
    document.getElementById('tps_restant').innerHTML = 'Il vous reste : ' + (60 - i) + 's';
    i++;
    if( i > 10 ) {
        i = 1;
    }
}

var FuncOL = new Array();

function StkFunc(Obj) {
    FuncOL[FuncOL.length] = Obj;
}

StkFunc(setInterval("dateEtHeure()", 100));
StkFunc(setInterval("dateEtHeureMin()", 1000));

window.onload = function() {
    for ( i = 0; i < FuncOL.length; i++ ) {
        FuncOL[i]();
    }
};
