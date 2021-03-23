<?php
require_once("view/View.php");
class PrivateView extends View {
	public $title;
	public $scriptJS;

	public $content;
	public $routeur;
	public $menu;
	public $account;
	public $feedback;


	public $image;

	function __construct($routeur, $account, $feedback=""){
		$this->title     = "";
		$this->scriptJS  = "";
		$this->content   = "";
		$this->routeur   = $routeur;
		$this->menu      = $this->getMenu();
		$this->feedback  = $feedback;
		$this->account   = $account;
	}

	function getMenu(){
		return array($this->routeur->getPartieJouer()          => "Jouer une partie"   ,
					 $this->routeur->getClassementJoueurs()    => "Classement des joueurs",
					 $this->routeur->getLogoutURL()            => "Se deconnecter"       ,
					 $this->routeur->getProfilURL()            => "Profil"       ,
				     $this->routeur->getAProposURL()           => "A propos"               );
	}

	function jouer() {
		$this->title = "Jouer une partie";

		
		//Lien vers la fonction jouerPartie(...) ci dessous
		$this->content = "<form action=\"".$this->routeur->getJouerPartieURL()."\" method=\"post\">
		 		 	<button input type=\"submit\"> Lancer une partie </button>
		 		 </form>";

		$this->render();
	}

	function jouerPartieView($nomImg, $idImg, $urlImg,  $tab=[]) {
		$this->title = "Jouer une partieee";
		$this->scriptJS = "<script language=\"javascript\" type=\"text/javascript\" src=\"".Router::DEB_URL."/src/js/jeu.js\"> </script>\n
		                   <script language=\"javascript\" type=\"text/javascript\" src=\"".Router::DEB_URL."/src/js/date.js\"></script>";

		

		$val = "<center> <div id=\"affichage_tps\">Il vous reste : <span id=\"tps_restant\"></span> s</div></center><br>";

		//$val = "<h2>$this->image</h2>";//Temporaire
		$val .= "<img id = \"imgGame\" class = \"imgJouer\" src =\"$urlImg \" alt=\"erreur:$nomImg\" >";

		$val .= "<div id=\"tags\">
				 	<div>Tags : <input id=\"txtGame\"type=\"text\" name=\"tag\"/></div>
				 	<button id=\"myBtn\">Try it</button>
				</div>";

		$val .= "<ul id='tagWrong'> Tag(s) Incorrect(s) : ";
		$val .= "</ul>";

		$val .= "<ul id='tagRight'> Tag(s) Correct(s) : ";
		$val .= "</ul>";
		
		$val .= "<div id=\"form\"> <form action=\"".$this->routeur->getJouerPartieURL()."\" method=\"post\">
								<button  type=\"submit\" id=\"btnRejouer\">Try Again</button>
								score : <input type=\"number\" id=\"scoreJoueur\" name=\"scoreJoueur\" value=\"0\" min=\"0\" disabled=\"disabled\">
				</form></div>";
		$val .= "<script> game(".$idImg."); </script>";
		//var_dump($tab);
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
		$this->title  = "Classement des joueurs";
		$this->scriptJS = "<script language=\"javascript\" type=\"text/javascript\" src=\"".Router::DEB_URL."/src/js/date.js\"></script>";
		$tabTrie = $this->triClassement($tabAccount);

		$this->content  ="<script> window.onload = function() { setInterval(\"dateEtHeure()\", 100) };</script>";
		$this->content .="<div id=\"heure_exacte\"></div><br>";

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
