<?php
require_once("view/View.php");
class PrivateView extends View {
	public $title;
	public $content;
	public $routeur;
	public $menu;
	public $account;
	public $feedback;


	public $image;

	function __construct($routeur, $account, $feedback=""){
		$this->title    = "";
		$this->content  = "";
		$this->routeur  = $routeur;
		$this->menu     = $this->getMenu();
		$this->feedback = $feedback;
		$this->account  = $account;
	}

	function getMenu(){
		return array($this->routeur->getPartieJouer()          => "Jouer une partie"   ,
					 $this->routeur->getClassementJoueurs()    => "Classement des joueurs",
					 $this->routeur->getLogoutURL()            => "Se deconnecter"       ,
					 $this->routeur->getProfilURL()            => "Profil"       ,
				     $this->routeur->getAProposURL()           => "A propos"               );
	}

	function jouer($tabImages, $tabTags, $data = []) {
		$this->title = "Jouer une partie";



		//Lien vers la fonction jouerPartie(...) ci dessous
		$val = "<form action=\"".$this->routeur->getJouerPartieURL()."\" method=\"post\">
		 		 	<button input type=\"submit\"> Lancer une partie </button>
		 		 </form>";

		$this->content = $val;
		$this->render();
	}

	function jouerPartieView($nomImg, $tab=[]) {
		$this->title = "Jouer une partieee";


		$val = "<center> <div id=\"tps_restant\"></div></center><br>";

		//$val = "<h2>$this->image</h2>";//Temporaire
		$val .= "<img class = \"imgJouer\" src = " . Router::DEB_URL. "/src/view/images/$nomImg alt=\"erreur:/images/$nomImg\" style=\"display: block;margin-left: auto;margin-right: auto; width: 35%;\">";

		$val .= "<div id=\"tags\"> <form action=\"".$this->routeur->getTagsURL()."\" method=\"post\">
				 	<div>Tags : <input type=\"text\" name=\"tag\"/></div>
				 	<button type=\"submit\">Envoyer !</button>
				 </form></div>";

		$val .= "<ul>";
		for ($i=0; $i < count($tab); $i++) {
			if ($i === 0) {
				$val .= "Tags correspondant à l'image : ";
				foreach ($tab[0] as $key => $value) {
					$val .= "<li>$value</li>";
				}
			}
			else {
				$val .= "<br/><br/>Tags ne correspondant pas à l'image : ";
				foreach ($tab[1] as $key => $value) {
					$val .= "<li>$value</li>";
				}
			}

		}
		$val .= "</ul>";

		$this->content = $val;
		$this->render();
	}

	function makeProfilPage() {
		$this->title = "Profil";

		$this->content = "page de profil";
		$this->render();
	}


	function makeAccueilPage(){
		$this->title = "Page D'accueil";
		$this->content = "<p>Bonjour ".$this->account->getName()." :)</p>";
		$this->render();
	}


	function showClassementJoueurs($tabAccount) {
		$this->title = "Classement des joueurs";
		$tabTrie = $this->triClassement($tabAccount);

		$this->content = "
			<div id=\"heure_exacte\"></div><br>";

		$this->content .= "
		<br/><div id=\"date_dimanche\"></div><br>";

		$this->content .= "<ul>";
		$i = 1;
		foreach ($tabTrie as $key => $value) {
			$this->content .= "<li> $i : $value->name avec un score de : $value->scoreSemaine </li>";
			$i++;
		}

		$this->content .= "</ul>";
		$this->render();
	}


	private function triClassement($tabAccount) {
		$tabScore = [];
		foreach ($tabAccount as $key => $value) {
			$tabScore[] = $value->scoreSemaine;
		}
		rsort($tabScore);
		$tabAccountTri = [];
		foreach ($tabScore as $key => $value) {
			for ($i=1; $i <= count($tabAccount); $i++) {
				if ($tabAccount[$i]->scoreSemaine === $value) {
					$tabAccountTri[] = $tabAccount[$i];
				}
			}
		}
		return $tabAccountTri;
	}
	function makeLogoutPage(){
		$this->title = "Page de deconnexion";
		$this->content = "<form action=\"".$this->routeur->getLogoutURL()."\" method=\"post\">
		<button type=\"submit\">Se deconnecter</button>
		</form>";
		$this->render();
	}

}
