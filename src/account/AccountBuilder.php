<?php
require_once("account/Account.php");
class AccountBuilder {
	public $data;
	public $errorName;
	public $errorLogin;
	public $errorPassword;

	const NAME_REF = "Nom";
	const LOGIN_REF = "Login";
	const PASSWORD_REF = "MDP";

	function __construct($data, $errorName="", $errorLogin="", $errorPassword=""){
		$this->data = $data;
		$this->errorName = $errorName;
		$this->errorLogin = $errorLogin;
		$this->errorPassword = $errorPassword;
	}

	public function getData(){
		return $this->data;
	}

	public function getErrorName(){
		return $this->errorName;
	}

	public function getErrorLogin(){
		return $this->errorLogin;
	}

	public function getErrorPassword(){
		return $this->errorPassword;
	}

	public function createAccount(){
		$account = new Account($this->data[self::NAME_REF], $this->data[self::LOGIN_REF], password_hash($this->data[self::PASSWORD_REF], PASSWORD_BCRYPT), 0, 'default');
		return $account;
	}

	public function isValid($accountDB){
		$res = true;
		if($this->data[self::NAME_REF]===""){
			$this->errorName = "Le nom ne peut pas etre vide";
			$res = false;
		}
		else if(strpos($this->data[self::NAME_REF], "<script>")!==false){
			$this->errorName = "Le nom ne peut pas contenir de script";
			$res = false;
		}
		if($this->data[self::LOGIN_REF]===""){
			$this->errorLogin = "Le login ne peut pas etre vide";
			$res = false;
		}
		else if($accountDB->loginAlreadyExists($this->data[self::LOGIN_REF])){
			$this->errorLogin = "Le login existe deja, veuillez en choisir un different";
			$res = false;
		}
		else if(strpos($this->data[self::LOGIN_REF], "<script>")!==false){
			$this->errorLogin = "Le Login ne peut pas contenir de script";
			$res = false;
		}
		if(strlen($this->data[self::PASSWORD_REF])<6){
			$this->errorPassword = "Le mot de passe doit etre au moins de taille 6";
			$res = false;
		}
		else if(strpos($this->data[self::LOGIN_REF], "<script>")!==false){
			$this->errorPassword = "le mot de passe ne peut pas contenir de script";
			$res = false;
		}
		return $res;
	}
}
