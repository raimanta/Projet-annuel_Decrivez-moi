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


	function showClassementJoueurs($tabAccount) {
		$this->title = "Classement des joueurs";
		$tabTrie = $this->triClassement($tabAccount);

		$this->content = "
			<p>Il est exactement : <div id=\"heure_exacte\"></div><br>
			</p>";

		$this->content .= "
		<p>Date du prochain dimanche : <div id=\"date_dimanche\"></div><br>
		</p>";

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


	function jouer($tabImages, $data = []) {
		$this->title = "Jouer une partie";
		var_dump($this->tags);
		if (!empty($data)) {
			array_push($this->tags, $data['tag']);
		}
		var_dump($this->tags);
		//echo "<script> started(40); </script>"; // jsp comment ca fonctionne le js, sinon ça c'est un code qui fait un compte à rebours
		$nom = $tabImages[random_int(1, count($tabImages))]->nom;

		$val = "<img class = \"imgJouer\" src = " . Router::DEB_URL. "/src/view/images/$nom alt=\"erreur:/images/$nom\" style=\"display: block;margin-left: auto;margin-right: auto; width: 35%;\">";

		$val .= "<form action=\"".$this->routeur->getTagsURL()."\" method=\"post\">
				 	<div>Tags : <input type=\"text\" name=\"tag\"/></div>
				 	<button type=\"submit\">Envoyer !</button>
				 </form>";

		$val .= "tags : <ul>";
		foreach ($this->tags as $key => $value) {
			$val .= "<li>$value</li>";
		}

		$val .= "</ul> <ul>";

		foreach ($tabImages as $key => $value) {
			$val .= "<li><img src= " . Router::DEB_URL . "/src/view/images/".  $value->getName()."></li>";
		}
		$val.= "</ul>";


		$this->content = $val;
		$this->render();
	}

	function makeProfilPage() {
		$this->title = "Profil";

		$this->content = "page de profil";
		$this->render();
	}


	function makeLogoutPage(){
		$this->title = "Page de deconnexion";
		$this->content = "<form action=\"".$this->routeur->getLogoutURL()."\" method=\"post\">
		<button type=\"submit\">Se deconnecter</button>
		</form>";
		$this->render();
	}

}
