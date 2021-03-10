<?php
require_once("view/View.php");
class PrivateView extends View {
	public $title;
	public $content;
	public $routeur;
	public $menu;
	public $account;
	public $feedback;
	function __construct($routeur, $account, $feedback=""){
		$this->title = "";
		$this->content = "";
		$this->routeur = $routeur;
		$this->menu = $this->getMenu();
		$this->feedback = $feedback;
		$this->account = $account;
	}

	function getMenu(){
		return array($this->routeur->getPartieJouer()          => "Jouer une partie"   ,
					 $this->routeur->getClassementJoueurs()    => "Classement des joueurs",
					 $this->routeur->getLogoutURL()            => "Se deconnecter"       ,
					 $this->routeur->getProfilURL()            => "Profil"       ,
				     $this->routeur->getAProposURL()           => "A propos"               );
	}

	function makeAccueilPage(){
		$this->title = "Page D'accueil";
		$this->content = "<p>Bonjour ".$this->account->getName()." :)</p>";
		$this->render();
	}

	// pour le moment affiche une image aléatoire (jsp pk l'image ne veut pas s'afficher) et une liste de toutes les images (à enlever par la suite)
	function jouer($tabImages) {
		$this->title = "Jouer une partie";

		//echo "<script> started(40); </script>"; // jsp comment ca fonctionne le js, sinon ça c'est un code qui fait un compte à rebours
		$nom = $tabImages[random_int(1, count($tabImages))]->nom;
		$val = "<img src = \"$nom\" alt=\"erreur:$nom\">";
		foreach ($tabImages as $key => $value) {
			$val .= "<li><img src=/images/".$value->getName()."></li>";
		}
		$this->content = $val;

		$this->render();
	}

	function makeProfilPage() {
		$this->title = "Profil";

		$this->content = "page de profil";
		$this->render();
	}
}
