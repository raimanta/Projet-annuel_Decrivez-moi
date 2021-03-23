const apiKey = '24f74b3e22ed47d061b235c986ad1b0d';



function game(){
    window.onload = function(){ setInterval("Countdown()", 1000); };
    //let nbRound = 1;

    let arrayTag = Array();

    let txt = document.getElementById("txtGame");
    document.getElementById("myBtn").addEventListener("click", function() {
        arrayTag.push(txt.value)
        console.log(arrayTag);
        //alert(txt.value);
        imgChange(txt.value);
    });


    /*
    getTagsPhoto();
    */
}


function getTagsPhoto(id){
    let retPoint = 0;
    let tags = Promise.resolve(jsonGetter('https://www.flickr.com/services/rest/?method=flickr.tags.getListPhoto&api_key='+apiKey+'&photo_id='+id+'&format=json&nojsoncallback=1'));
    tags.then(function(value) {
        value.photo.tags.tag.forEach(element => {
            console.log(element.raw)
        });
    });

}


function imgChange(tag){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };
    xmlhttp.open("GET", "../src/model/Images-Tags.php?tag="+tag , true);
    xmlhttp.send();

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
            var xmlhttp2 = new XMLHttpRequest();
            xmlhttp2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                }
            };
            xmlhttp2.open("GET", "../src/model/Images-Tags.php?img="+id+"_"+secret+"_"+server+"_"+author+"_"+title , true);
            xmlhttp2.send();

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