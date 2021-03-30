<?php

class Account {
	public $name;
	private $login;
	private $password;
	public $scoreSemaine;
	public $statut;

	function __construct($name, $login, $password, $scoreSemaine, $statut='default'){
		$this->name = $name;
		$this->login = $login;
		$this->password = $password;
		$this->scoreSemaine = $scoreSemaine;
		$this->statut = $statut;
	}

	public function checkAuth($login, $password){
		if($login===$this->login&&password_verify($password, $this->password)){
			return true;
		}
		return false;
	}

	public function getName(){
		return $this->name;
	}

	public function getStatut(){
		return $this->statut;
	}

	public function getLogin(){
		return $this->login;
	}


	public function addScore($score){
		$this->scoreSemaine += $score;
	}

	public function resetScore(){
		$this->scoreSemaine = 0;
	}

}