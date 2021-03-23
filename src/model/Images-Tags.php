<?php
require_once("control/Controlleur.php");

$tag = isset($_GET['tag']) ? $_GET['tag'] : "" ;
$img = isset($_GET['img']) ? $_GET['img'] : "" ;


$str = "test";

// lookup all hints from array if $q is different from ""
if ($tag !== ""){
    $boolTag = false;
    $tmpTag = new Tag($tag[0]);
    /*foreach( $imageStorage.readAllTags() as $value ){
        if($value.equals($tmpTag)) $boolTag = true;
    }*/

    if(!$boolTag) $str.=" tag +1"; 
        
    
}

if($img !== ""){
    $boolImg = false;
    list($id, $secret, $server, $author, $title) = explode("_", $img);

    $imgUrl = "https://live.staticflickr.com/"+$server+"/"+$id+"_"+$secret+".jpg";

    $tmpImg = new Image($title, $id, $imgUrl, $author);

    /*foreach( $imageStorage.readAllImages() as $value ){
        if($value.equals($tmpImg)) $boolImg = true;
    }*/

    if(!$boolImg) $str.=" Img +1"; 
}

// Output "no suggestion" if no hint was found or output correct values
echo $str;

?>