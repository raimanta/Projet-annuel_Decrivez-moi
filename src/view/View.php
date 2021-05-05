<?php

class View{
	public $title;
	public $scriptJS;

	public $content;
	public $routeur;
	public $menu;
	public $feedback;


	function __construct($routeur, $feedback=""){
		$this->title     = "";
		$this->scriptJS = "";
		$this->content   = "";
		$this->routeur   = $routeur;
		$this->menu      = $this->getMenu();
		$this->feedback  = $feedback;

		//echo "<script> src=\"/barre.js\"></script>";
	}
	
	function render(){
		include("Squelette.php");
	}

	function getMenu(){
		return array();
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

	function makeLoginFormPage() {
		$this->title = "Page de connexion";
		//changer l'url, le renvoyer vers la page de connexion si c'est pas bon
		$this->content = "
		<h1> Connexion </h1>
		<form action=\"".$this->routeur->getLoginURL()."\" method=\"post\">
		<div>Login : <input type=\"text\" placeholder=\"Login\" name=\"login\"/></div> <br/>
		<div>Mot de passe : <input type=\"password\" placeholder=\"Password\" name=\"password\"/></div> <br/>
		<button type=\"submit\">Se connecter !</button>
		</form>
		<a href=\"".Router::DEB_URL."/index.php/compte\"> S'inscrire </a>
		";
		$this->render();
	}



	function makeAccountCreationPage($accountBuilder) {
		$this->title = "Creation de compte";
		$data = $accountBuilder->getData();
		if($data==null){
			$data=array(
				$accountBuilder::NAME_REF => "",
				$accountBuilder::LOGIN_REF => "",
				$accountBuilder::PASSWORD_REF => ""
			);
		}
		$this->content = "
		<h1> Création de compte </h1>
		<form action=\"".$this->routeur->getAccountCreationURL()."\" method=\"post\">
		<div>Nom : <input type=\"text\" placeholder=\"".$accountBuilder::NAME_REF."\" value=\"".$data[$accountBuilder::NAME_REF]."\" name=\"".$accountBuilder::NAME_REF."\"/>
			<p>".$accountBuilder->getErrorName()."</p></div>

			<div>Login : <input type=\"text\" placeholder=\"".$accountBuilder::LOGIN_REF."\" value=\"".$data[$accountBuilder::LOGIN_REF]."\" name=\"".$accountBuilder::LOGIN_REF."\"/>
			<p>".$accountBuilder->getErrorLogin()."</p></div>

			<div>Mot de passe : <input type=\"password\" placeholder=\"".$accountBuilder::PASSWORD_REF."\" value=\"".$data[$accountBuilder::PASSWORD_REF]."\" name=\"".$accountBuilder::PASSWORD_REF."\"/>
			<p>".$accountBuilder->getErrorPassword()."</p></div>

			<button type=\"submit\">Creer !</button>
			</form>
			<a href=\"".Router::DEB_URL."/index.php/connexion\"> Se connecter </a>";
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
