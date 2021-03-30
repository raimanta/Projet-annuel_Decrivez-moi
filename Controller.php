<?php
require_once("model/Image.php");
require_once("model/Jeu.php");
require_once("account/Account.php");
require_once("account/AccountBuilder.php");
class Controller {
	public $view;
	public $imageStorage;
	public $accountStorage;
	public $jeu;
	public $nomImg;

	function __construct($view, $imageStorage, $accountStorage){
		$this->view = $view;
		$this->imageStorage = $imageStorage;
		$this->accountStorage = $accountStorage;
	}

	public function showInformation($id) {
		$poke = $this->pokemonStorage->read($id);
		if($poke===null){
			$this->view->makeUnknownPokemonPage();
		}
		else {
			$this->view->makePokemonPage($poke, $id);
		}
	}

	public function showClassement() {
		$this->view->showClassementJoueurs($this->accountStorage->readAllAccount());
	}


	public function jouer() {
		$this->view->jouer();
	}

	public function jouerPartieCtrl() {
		$_SESSION['jeu'] = new Jeu($this->imageStorage);
		$this->view->jouerPartieView($_SESSION['nomImg'],$_SESSION['idImg'], $_SESSION['urlImg'], $this->imageStorage->readAllImages());
	}

	public function updateScore($score){
		$account = $_SESSION['user'];
		$this->accountStorage->updateScore($account, $score);
	}

	public function createTag($tag) {
		$boolTag = false;
		$tmpTag = new Tag($tag);
		foreach( $this->imageStorage->readAllTags() as $value ){
			if($value->equals($tmpTag)) $boolTag = true;
		}

		if(!$boolTag) $this->imageStorage->addTag($tmpTag); 
	}

	public function createImage($image) {
		var_dump($image);
		$boolImg = false;
		list($id, $secret, $server, $author, $title) = explode("_", $image);
		
	    $imgUrl = "https://live.staticflickr.com/$server/$id"."_$secret.jpg";
		var_dump($imgUrl);
		$tmpImg = new Image($title, $id, $imgUrl, $author);
		var_dump($tmpImg);
		
		foreach($this->imageStorage->readAllImages() as $value ){

			if($value->equals($tmpImg)) $boolImg = true;
		}
	
		if(!$boolImg){
			var_dump("last bool");
			$this->imageStorage->addImage($tmpImg); 
		}

	}


	public function login(){
		$this->view->makeLoginFormPage();
	}

	public function confirmLogin($data){
		$account = $this->accountStorage->checkAuth($data['login'], $data['password']);
		if($account===null){
			$this->view->displayLoginFailure();
		}
		else {
			$_SESSION['user'] = $account;
			$this->view->displayLoginSuccess();
		}
	}

	public function confirmLogout(){
		unset($_SESSION['user']);
		$this->view->displayLogoutSuccess();
	}

	public function createAccount(){
		$accountBuilder = new AccountBuilder(null);
		if(key_exists('currentAccount', $_SESSION)){
			$accountBuilder = $_SESSION['currentAccount'];
		}
		$this->view->makeAccountCreationPage($accountBuilder);
	}

	public function confirmCreateAccount($data){
		$accountBuilder = new AccountBuilder($data);
		if(!$accountBuilder->isValid($this->accountStorage)){
			$_SESSION['currentAccount'] = $accountBuilder;
			$this->view->displayAccountCreationFailure();
		}
		else {
			unset($_SESSION['currentAccount']);
			$account = $accountBuilder->createAccount();
			$_SESSION['user']=$account;
			$this->accountStorage->add($account);
			$this->view->displayAccountCreationSuccess();
		}
	}
}
