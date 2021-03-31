const apiKey = 'fdea195738d5a88c851a880e2b1b46c2';


function game(id){
    //load sur la page le compteur de temps restant
    window.onload = function(){ setInterval("Countdown()", 1000); };

    let arrayTag = Array();

    let txt = document.getElementById("txtGame");

    //ajout d'un event sur le bouton
    document.getElementById("myBtn").addEventListener("click", function() {
        if (!inArray(txt.value, arrayTag)) {
            arrayTag.push(txt.value)
            calculTagsPhoto(id, txt.value);
        }

        //console.log(arrayTag);
        imgChange(txt.value);
        //Appel de la page index.php pour ajouter le tag donnée a la base de donnée
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
            }
        };
        xmlhttp.open("GET", "index.php/tag?tag="+txt.value , true);
        xmlhttp.send();
    });

}


function calculTagsPhoto(id, strTag){
    let isWrong = true;

    //Appel API pour obtenir les tags d'une photo en fonction de son id
    let tags = Promise.resolve(jsonGetter('https://www.flickr.com/services/rest/?method=flickr.tags.getListPhoto&api_key='+apiKey+'&photo_id='+id+'&format=json&nojsoncallback=1'));
    tags.then(function(value) {

        //Parcours des tags de la photo de l'id donnée
        value.photo.tags.tag.forEach(element => {

            //si le tags donnée correspond à l'un des tags de la photo
            if(element.raw === strTag){

                //récupération des points par rapport au temps restant
                let pts = document.getElementById('tps_restant').innerHTML;
                document.getElementById("scoreJoueur").value = parseInt(pts)+parseInt(document.getElementById("scoreJoueur").value);

                //Appel de la de la page index.php pour passer le nombre de point gagner
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) { console.log(this.responseText); }
                };
                xmlhttp.open("GET", "index.php/score?score=" + pts , true);
                xmlhttp.send();

                //Ajout du tag a la liste des tags correspondant
                let ulTag = document.getElementById("tagRight");
                var li = document.createElement("li");
                li.appendChild(document.createTextNode(strTag));
                ulTag.appendChild(li);
                console.log(element.raw)
                //boolean qui permets de ne pas ajouter le tag dans les tags correspondant et non correspondant
                isWrong = false;
            }

            console.log("tags : "+element.raw)
        });

        //Ajout du tag a la liste des tags non correspondant
        if(isWrong){
            let ulTag = document.getElementById("tagWrong");
            var li = document.createElement("li");
            li.appendChild(document.createTextNode(strTag));
            ulTag.appendChild(li);
        }

    });
}


function imgChange(tag){

    //Appel API pour récuperer des photos en fonction d'un tag donné
    let img = Promise.resolve(jsonGetter('https://www.flickr.com/services/rest/?method=flickr.tags.getClusterPhotos&api_key='+apiKey+'&tag='+tag+'&format=json&nojsoncallback=1'));
    img.then(function(value) {

        value.photos.photo.forEach(element => {
            console.log(element);
            //Recuperation des informations utiles pour l'ajout d'une photo a la base de donnée
            let id = element.id;
            let server = element.server ;
            let secret = element.secret ;
            let author = element.username ;
            let title  = element.title;

            //Appel de la de la page index.php pour ajouter des Images à la Base de donnée
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) { console.log(this.responseText); }
            };
            xmlhttp.open("GET", "index.php/image?img="+id+"_"+secret+"_"+server+"_"+author+"_"+title , true);
            xmlhttp.send();

            //change l'image du jeu par une image en fonction du tag donnée (debug)
            //document.getElementById('imgGame').setAttribute("src", "https://live.staticflickr.com/"+server+"/"+id+"_"+secret+".jpg")
        });
    });
}


function jsonGetter(url) {
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.open("GET", url);
      xhr.responseType = "json";
      xhr.onload = () => resolve(xhr.response);
      xhr.onerror = () => reject(xhr.statusText);
      xhr.send();
    });
}

function inArray(str, array) {
    for(let i = 0; i < array.length; i++) {
        if(array[i] == str) return true;
    }
    return false;
}
