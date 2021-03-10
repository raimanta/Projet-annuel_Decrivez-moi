function affichBien(nombre) {
    return nombre < 10 ? '0' + nombre : nombre;
}

function dateEtHeure() {    
    const date = new Date();
    document.getElementById('heure_exacte').innerHTML = 'Nous sommes le ' + date.getDate() + ' et il est : ' + affichBien(date.getHours()) + ':' + affichBien(date.getMinutes()) + ':' + affichBien(date.getSeconds());
    
    let dateDimanche = new Date();
    dateDimanche.setDate(date.getDate()-date.getDay()+7); // permet de récuperer la date du prochain dimanche
    dateDimanche.setHours(23);
    dateDimanche.setMinutes(59);
    dateDimanche.setSeconds(59);

    let nbrHeuresAvDimanche   = ( (date.getDay() + 1) * 24) + (24 - date.getHours());
    let nbrMinutesAvDimanche  = (( (date.getDay() + 1) * 24) + (24 - date.getMinutes())) % 60;
    let nbrSecondesAvDimanche = (( (date.getDay() + 1) * 24) + (24 - date.getSeconds())) % 60;

    document.getElementById('date_dimanche').innerHTML = 'Le classement se réinitialise dans : ' + nbrHeuresAvDimanche   + "h "      + 
                                                                                                   nbrMinutesAvDimanche  + "min et " +
                                                                                                   nbrSecondesAvDimanche + "s";
}

window.onload = function() {
    setInterval("dateEtHeure()", 100);
};