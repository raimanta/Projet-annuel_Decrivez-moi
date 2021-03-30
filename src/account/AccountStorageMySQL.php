<?php
require_once("account/AccountStorage.php");
require_once("account/Account.php");

class AccountStorageMySQL implements AccountStorage {
	public $db;

	function __construct($db=null){
		if($db===null){
			$dsn  = Router::DB_ID;
			$user = Router::USER_ID ;
			$pass = Router::PASSWORD ;
			try {
				$this->db = new PDO($dsn, $user, $pass);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//self::reinit();
			}
			catch (PDOExecption $e){
				throw new PDOExecption($e->getMessage(), $e->getCode());
			}
		}
		else {
			$this->db = $db;
		}
	}

	function reinit(){
		try {
			$this->db->exec("DROP TABLE IF EXISTS accounts");
			$this->db->exec("CREATE TABLE accounts
			(
				id INT(255) NOT NULL AUTO_INCREMENT,
				account VARCHAR(5000),
				PRIMARY KEY (id)
			)");
			$account = new Account("Théo"      , "crauffon"      , '$2y$10$YtNzNxFCrHiXYezE31EVpebXl/5CxjaS.M0g.oOb5vnCpLRAcmoZy', 100);
			$str = serialize($account);
			$this->db->exec("INSERT INTO accounts (account) VALUES('$str')");

			$account = new Account("Nicolas", "lacaille", '$2y$10$Aw0QqjsYlZ51pgp1YGDghO0RTjQPbCoNLU8VbF7HJj6qcvicOh9je', 12);
			$str = serialize($account);
			$this->db->exec("INSERT INTO accounts (account) VALUES('$str')");

			$account = new Account("Matéo"       , "ducastel"       , '$2y$10$hEqBLC3bkY3w0LWJJJLW7uMzDKACzkKRQg6P/W9zHH7GQEWxVKnDq', 46, "admin");
			$str = serialize($account);
			$this->db->exec("INSERT INTO accounts (account) VALUES('$str')");

			$account = new Account("David"       , "lin"       , '$2y$10$C2HhEFOUXuJrseiHOtmzU.Jq2/lJ7A0ZIb.7aUcBb0jVY1GxW3e02', 0, "admin");
			$str = serialize($account);
			$this->db->exec("INSERT INTO accounts (account) VALUES('$str')");
		}
		catch (PDOExecption $e) {
			throw new PDOExecption($e->getMessage(), $e->getCode());
		}
	}

	function checkAuth($login, $password){
		$stmt = $this->db->query("SELECT * FROM accounts");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
			$account = unserialize($value['account']);
			if($account->checkAuth($login, $password)){
				return $account;
			}
		}
		return null;
	}



	public function readAllAccount() {
		$array = array();
		$stmt = $this->db->query("SELECT * FROM accounts");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value){
			$array[$value['id']] = unserialize($value['account']);
		}
		return $array;
	}



	function add(Account $account){
		$rq = "INSERT INTO accounts VALUES(:str)";
		$stmt = $this->db->prepare($rq);
		$data = array(':str' => serialize($account));
		$stmt->execute($data);
	}

	function loginAlreadyExists($login){
		$stmt = $this->db->query("SELECT * FROM accounts");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
			$account = unserialize($value['account']);
			if($account->getLogin()===$login){
				return true;
			}
		}
		return false;
	}

	function update($compte) {
		$stmt = $this->db->query("SELECT * FROM accounts");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
			$val = $value['account'];
			$account = unserialize($val);
			if($account->getLogin()===$compte->getLogin()){
				$str = serialize($compte);
				$this->db->exec("UPDATE accounts SET account = '$str' WHERE account = '$val'");
			}
		}
	}

	function updateScore($compte, $score) {
		$stmt = $this->db->query("SELECT * FROM accounts");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
			$val = $value['account'];
			$account = unserialize($val);
			if($account->getLogin()===$compte->getLogin()){
				$account->addScore($score);
				$str = serialize($account);
				$this->db->exec("UPDATE accounts SET account = '$str' WHERE account = '$val'");
			}
		}
	}
}
