<?php
require_once("model/Image.php");
require_once("account/Account.php");
require_once("account/AccountBuilder.php");
class Controller {
	public $view;
	public $imageStorage;
	public $accountStorage;
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

	public function showList() {
		$this->view->makeListPage($this->imageStorage->readAll());
	}

	public function jouer() {
		$this->view->jouer($this->imageStorage->readAllImages());
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
