<?php

class View{
	public $title;
	public $content;
	public $routeur;
	public $menu;
	public $feedback;

	public $tags;

	function __construct($routeur, $feedback=""){
		$this->title = "";
		$this->content = "";
		$this->routeur = $routeur;
		$this->menu = $this->getMenu();
		$this->feedback=$feedback;
		$this->tags = [];
		//echo "<script> src=\"/barre.js\"></script>";
	}
	function render(){
		include("Squelette.php");
	}

	function getMenu(){
		return array($this->routeur->getPartieJouer()       => "Jouer une partie"      ,
					 $this->routeur->getClassementJoueurs() => "Classement des joueurs",
					 $this->routeur->getLoginURL()             => "Se connecter"          ,
					 $this->routeur->getAccountCreationURL()   => "Créer un compte"       ,
					 $this->routeur->getAProposURL()           => "A propos"
				          );
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


	function makeAccueilPage(){
		$this->title = "Page D'accueil";
		$this->content = "<p>bienvenue sur la page d'accueil</p>";
		$this->render();
	}

	public function makeDebugPage($variable) {
		$this->title = 'Debug';
		$this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
		$this->render();
	}

	function makeLoginFormPage(){
		$this->title = "Page de connexion";
		//changer l'url, le renvoyer vers la page de connexion si c'est pas bon
		$this->content = "<form action=\"".$this->routeur->getLoginURL()."\" method=\"post\">
		<div>Login : <input type=\"text\" placeholder=\"Login\" name=\"login\"/></div>
		<div>Mot de passe : <input type=\"password\" placeholder=\"Password\" name=\"password\"/></div>
		<button type=\"submit\">Se connecter !</button>
		</form>";
		$this->render();
	}

	function makeLogoutPage(){
		$this->title = "Page de deconnexion";
		$this->content = "<form action=\"".$this->routeur->getLogoutURL()."\" method=\"post\">
		<button type=\"submit\">Se deconnecter</button>
		</form>";
		$this->render();
	}

	function makeAccountCreationPage($accountBuilder){
		$this->title = "Creation de compte";
		$data = $accountBuilder->getData();
		if($data==null){
			$data=array(
				$accountBuilder::NAME_REF => "",
				$accountBuilder::LOGIN_REF => "",
				$accountBuilder::PASSWORD_REF => ""
			);
		}
		$this->content = "<form action=\"".$this->routeur->getAccountCreationURL()."\" method=\"post\">
		<div>Nom : <input type=\"text\" placeholder=\"".$accountBuilder::NAME_REF."\" value=\"".$data[$accountBuilder::NAME_REF]."\" name=\"".$accountBuilder::NAME_REF."\"/>
			<p>".$accountBuilder->getErrorName()."</p></div>

			<div>Login : <input type=\"text\" placeholder=\"".$accountBuilder::LOGIN_REF."\" value=\"".$data[$accountBuilder::LOGIN_REF]."\" name=\"".$accountBuilder::LOGIN_REF."\"/>
			<p>".$accountBuilder->getErrorLogin()."</p></div>

			<div>Mot de passe : <input type=\"password\" placeholder=\"".$accountBuilder::PASSWORD_REF."\" value=\"".$data[$accountBuilder::PASSWORD_REF]."\" name=\"".$accountBuilder::PASSWORD_REF."\"/>
			<p>".$accountBuilder->getErrorPassword()."</p></div>

			<button type=\"submit\">Creer !</button>
			</form>";
		$this->render();
	}


	function makeAProposPage(){
		include("APropos.php");
	}

	function displayLoginSuccess(){
		$this->routeur->POSTredirect($this->routeur->getAccueilURL(), "Vous vous etes connecte avec success !");
	}

	function displayLoginFailure(){
		$this->routeur->POSTredirect($this->routeur->getLoginURL(), "Le login/mot de passe n'est pas bon !");
	}

	function displayLogoutSuccess(){
		$this->routeur->POSTredirect($this->routeur->getLoginURL(), "Vous vous etes deconnecte avec succes");
	}

	function displayAccountCreationSuccess(){
		$this->routeur->POSTredirect($this->routeur->getAccueilURL(), "Le compte a ete creer avec succes !");
	}

	function displayAccountCreationFailure(){
		$this->routeur->POSTredirect($this->routeur->getAccountCreationURL(), "Le compte n'a pas ete cree !");
	}
}
?>
