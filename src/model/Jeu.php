<?php
    class Jeu {
        public $nomImage;
		public $urlImage;

        function __construct($tabImages, $tabTags) {

    		//Une image aléatoire
    		//$this->image = $tabNoms[random_int(0, count($tabNoms)-1)];

    		//récupère une image

    		$this->nomImage = $tabImages[1]->nom;
			$this->urlImage = $tabImages[1]->url;

            $_SESSION['nomImg'] = $this->nomImage;
			$_SESSION['urlImg'] = $this->urlImage;
        }
	}
?>
