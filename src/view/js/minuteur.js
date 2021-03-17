let   i = 1;
function dateEtHeureMin() {

    document.getElementById('tps_restant').innerHTML = 'Il vous reste : ' + (60 - i) + 's';
    i = i + 1;

    if(i == 61) {
        //alert("fin du temps");
        console.log("fin du minuteur");
        document.getElementById('tps_restant').style.display = "none";
        document.getElementById('tags').style.display = "none";

    }
}

window.onload = function() {
    //setInterval("dateEtHeureMin()", 1000);
};
