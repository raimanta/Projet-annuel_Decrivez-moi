<?php
    class Jeu {
        public $nomImage;
		public $urlImage;
		public $idImage; 

        function __construct($imageStorage) {

			$tabImages = $imageStorage->readAllImages();


    		//Une image aléatoire
    		//$this->image = $tabNoms[random_int(1, count($tabNoms))];
			$random = random_int(1, count($tabImages)); 
			$this->nomImage = $tabImages[$random]->nom;
			$this->urlImage = $tabImages[$random]->url;
			$this->idImage  = $tabImages[$random]->id;

    		//récupère une image
			
    		/*$this->nomImage = $tabImages[2]->nom;
			$this->urlImage = $tabImages[2]->url;*/
			

            $_SESSION['idImg']  = $this->idImage;
			$_SESSION['nomImg'] = $this->nomImage;
			$_SESSION['urlImg'] = $this->urlImage;
        }
	}
?>
