const apiKey = '634ab2492333bed00e15d902d7f621f5';



function game(id){
    window.onload = function(){ setInterval("Countdown()", 1000); };

    //let nbRound = 1;

    let arrayTag = Array();

    let txt = document.getElementById("txtGame");
    

    document.getElementById("myBtn").addEventListener("click", function() {
        if (!inArray(txt.value, arrayTag)) {
            arrayTag.push(txt.value)
            calculTagsPhoto(id, txt.value);
        }
        
        //console.log(arrayTag);
        imgChange(txt.value);
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

    let tags = Promise.resolve(jsonGetter('https://www.flickr.com/services/rest/?method=flickr.tags.getListPhoto&api_key='+apiKey+'&photo_id='+id+'&format=json&nojsoncallback=1'));
    tags.then(function(value) {
        value.photo.tags.tag.forEach(element => {
            if(element.raw === strTag){


                let pts = document.getElementById('tps_restant').innerHTML;
                document.getElementById("scoreJoueur").value = parseInt(pts)+parseInt(document.getElementById("scoreJoueur").value);



                let ulTag = document.getElementById("tagRight");
                var li = document.createElement("li");
                li.appendChild(document.createTextNode(strTag));
                ulTag.appendChild(li);
                //console.log(element.raw)
                isWrong = false;
            }
           
            console.log("tags : "+element.raw)
        });
        
        if(isWrong){
            let ulTag = document.getElementById("tagWrong");
            var li = document.createElement("li");
            li.appendChild(document.createTextNode(strTag));
            ulTag.appendChild(li);
        }
        
    });
}


function imgChange(tag){

    let img = Promise.resolve(jsonGetter('https://www.flickr.com/services/rest/?method=flickr.tags.getClusterPhotos&api_key='+apiKey+'&tag='+tag+'&format=json&nojsoncallback=1'));

    img.then(function(value) {
        value.photos.photo.forEach(element => {
            console.log(element);
            let id = element.id;
            let server = element.server ; 
            let secret = element.secret ; 
            let author = element.username ; 
            let title  = element.title;
            
            /* Ajouter des Images à la BD en fonction du tags donnée*/
            // A completer...
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                }
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