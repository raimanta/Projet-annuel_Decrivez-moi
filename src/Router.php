<?php
require_once("view/View.php");
require_once("view/PrivateView.php");
require_once("control/Controller.php");
require_once("Log.php");
class Router {
	const DB_ID    = 'mysql:host=mysql.info.unicaen.fr;dbname='.DATABASE.';charset=utf8mb4'; //NO COMMIT
	const USER_ID  = NUMETU; //NO COMMIT
	const PASSWORD = PASSWORD; //NO COMMIT
	const DEB_URL = "https://dev-".Router::USER_ID.".users.info.unicaen.fr/Projet_annuel/V2";
	public $estco = false;
	function main($imageStorage, $accountStorage){
		session_start();
		//unset($_SESSION['user']);

		//On declare la view en fonction de l'utilisateur
		$view = null;

		if(isset($_SESSION['user']) && !$this->estco){
			$view = new PrivateView($this, $_SESSION['user'], isset($_SESSION['feedback'])?$_SESSION['feedback']:"");
			$this->estco = true;
		}
		else {
			$view = new View($this, isset($_SESSION['feedback'])?$_SESSION['feedback']:"");
		}

		unset($_SESSION['feedback']);
		$controller = new Controller($view, $imageStorage, $accountStorage);


		$verify = false;
		if(!isset($_SERVER['PATH_INFO'])){
			$view->makeLoginFormPage();
		}
		else {
			//Initialisation qui permet de recuperer l'id
			$id = 0;
			$array = array("jouer", "classement", "connexion", "deconnexion", "profil", "compte", "aPropos", "accueil", "tags", "jouerPartie", "score", "resetScore", "");
			foreach (explode("/",$_SERVER['PATH_INFO']) as $value) {
				if(!in_array($value, $array)){
					$id=$value;
					break;
				}
			}

			foreach (explode("/",$_SERVER['PATH_INFO']) as $value) {

				if($value==="jouer"){
                    $verify = true;
                    $controller->jouer();
					break;
                }
				else if($value==="jouerPartie"){
					$verify = true;
					$controller->jouerPartieCtrl();
					break;
				}
				else if($value==="score"){
					$verify = true;
					$controller->updateScore($_GET['score']);
				}
				else if($value==="resetScore"){
					$verify = true;
					$controller->resetScore();
				}
				else if($value==="tag"){
                    $verify = true;
                    $controller->createTag($_GET['tag']);
					break;
                }
				else if($value==="image"){
					$verify = true;
					$controller->createImage($_GET['img']);
					break;
				}
				else if($value==="classement"){
                    $verify = true;
                    $controller->showClassement();
					break;
                }
				else if($value==="accueil"){
					$verify = true;
					$view->makeAccueilPage();
					break;
				}
				else if($value==="profil"){
					$verify = true;
					$controller->showProfil();
					break;
				}
				else if($value=="connexion"){
					$verify = true;
					if($_SERVER['REQUEST_METHOD']==="GET"){
						$controller->login();
					}
					else {
						$controller->confirmLogin($_POST);
					}
					break;
				}
				else if($value=="deconnexion"&&isset($_SESSION['user'])){
					$verify = true;
					if($_SERVER['REQUEST_METHOD']==="GET"){
						$view->makeLogoutPage();
					}
					else {
						$controller->confirmLogout();
					}
				}
				else if($value=="compte"){
					$verify = true;
					if($_SERVER['REQUEST_METHOD']==="GET"){
						$controller->createAccount();
					}
					else {
						$controller->confirmCreateAccount($_POST);
					}
					break;
				}
				else if($value=="aPropos"){
					$verify = true;
					$view->makeAProposPage();
				}
			}
		}
	}


	function POSTredirect($url, $feedback){
		$_SESSION['feedback'] = $feedback;
		header("Location: " . $url, true, 303);
	}

	function getAccueilURL(){
		return Router::DEB_URL."/index.php/accueil";
	}

	function getPartieJouer(){
		return Router::DEB_URL."/index.php/jouer";
	}

	function getJouerPartieURL(){
		return Router::DEB_URL."/index.php/jouerPartie";
	}

	function getTagCreationURL(){
		return Router::DEB_URL."/index.php/tag";
	}

	function getImgCreationURL(){
		return Router::DEB_URL."/index.php/image";
	}

	function getClassementJoueurs(){
		return Router::DEB_URL."/index.php/classement";
	}

	function getProfilURL() {
		return Router::DEB_URL."/index.php/profil";
	}

	function getLoginURL(){
		return Router::DEB_URL."/index.php/connexion";
	}

	function getLogoutURL(){
		return  Router::DEB_URL."/index.php/deconnexion";
	}

	function getAccountCreationURL(){
		return Router::DEB_URL."/index.php/compte";
	}

	function getAProposURL(){
		return Router::DEB_URL."/index.php/aPropos";
	}


}
