function affichBien(nombre) {
    return nombre < 10 ? '0' + nombre : nombre;
}

function dateEtHeure() {

    const date = new Date();

    let divHeure = document.getElementById('heure_exacte');
    if(divHeure != null)
        divHeure.innerHTML = 'Nous sommes le ' + date.getDate() + ' et il est : ' + affichBien(date.getHours()) + ':' + affichBien(date.getMinutes()) + ':' + affichBien(date.getSeconds());

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

    let divDateDimanche = document.getElementById('date_dimanche');
    if(divDateDimanche != null)
        divDateDimanche.innerHTML = '<br/>Le classement se réinitialise dans : ' + nbrHeuresAvDimanche   + "h "      +
                                                                                                        nbrMinutesAvDimanche  + "min et " +
                                                                                                        nbrSecondesAvDimanche + "s";

    /*if(nbrHeuresAvDimanche === 0 && nbrMinutesAvDimanche === 0 && nbrSecondesAvDimanche === 1) {
        //utiliser une méthode qui remet tous les scores à 0
    }*/
}

let   i = 1;

function Countdown() {

    let divTpsRestant = document.getElementById('tps_restant');
    if(divTpsRestant != null){
        divTpsRestant.innerHTML = 60 - i;
        i = i + 1;

        if(i == 61) {
            //update le score
            
            //alert("fin du temps");
            console.log("fin du minuteur");
            document.getElementById('affichage_tps').style.display = "none";
            document.getElementById('tags').style.display = "none";
        }
    } 
}
