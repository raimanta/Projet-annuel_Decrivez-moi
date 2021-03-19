<?php
    class Jeu {
    	public $tablTags;
    	public $tablTagsAlt;
        public $image;

        public $tabImages;
        public $nomImage;

        function __construct($tabImages, $tabTags) {
            $this->tablTags    = [];
    		$this->tablTagsAlt = [];
            //Temporaire, pour avoir une image avec plusieurs tags
    		$this->tabImages = [
    			$tabImages[1]->nom => [$tabTags[1]->nom, $tabTags[2]->nom],
    			$tabImages[2]->nom => [$tabTags[1]->nom]
    			];


    		//Pour récuérer un tableau de noms
    		$tabNoms = [];
    		foreach ($this->tabImages as $key => $value) {
    			$tabNoms[] = $key;
    		}


    		//Une image aléatoire
    		//$this->image = $tabNoms[random_int(0, count($tabNoms)-1)];

    		//récupère une image
            $nomImage = array();

            for( $i = 0; $i < sizeof($tabImages); $i++ ) {
                $this->image = [$tabNoms[$i] => $this->tabImages[$tabNoms[$i]]];
                $nomImage[$i] = key($this->image);
            }
        }


        public function jouerPartie($data = []) {
			// faire le test de savoir si le tag ecrit est dans la bdd de l'image
            $nomImg = $_SESSION['nomImg'];
            $tagTrouve = false;
            if ($data['tag'] != '') {
                for ($i=0; $i < count($this->image[$nomImg]); $i++) {
    				if ($data['tag'] === $this->image[$nomImg][$i] && !in_array($data['tag'], $this->tablTags)) {
    					$this->tablTags[] = $data['tag'];
    					$tagTrouve = true;
    					break;
    				}
    			}
    			if (! $tagTrouve && !in_array($data['tag'], $this->tablTagsAlt) && !in_array($data['tag'], $this->tablTags)) {
    				$this->tablTagsAlt[] = $data['tag'];
    			}
                return array($this->tablTags, $this->tablTagsAlt);
            }
			return;
        }
    }

?>
