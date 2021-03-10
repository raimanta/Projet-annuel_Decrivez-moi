<?php
require_once("model/ImageStorage.php");
require_once("model/Image.php");
require_once("model/Tag.php");
class ImageStorageMySQL implements ImageStorage {
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
			$this->db->exec("DROP TABLE IF EXISTS images");
			$this->db->exec("CREATE TABLE images
			(
			    id INT(255) NOT NULL AUTO_INCREMENT,
			    image VARCHAR(255),
			    PRIMARY KEY (id)
			)");
			$img1 = serialize(new Image("Linx.jpg", "chein"));
			$img2 = serialize(new Image("Grotadmorv.png", "boule"));
			$this->db->exec("INSERT INTO images (image) VALUES('$img1')");
			$this->db->exec("INSERT INTO images (image) VALUES('$img2')");


			$this->db->exec("DROP TABLE IF EXISTS tags");
			$this->db->exec("CREATE TABLE tags
			(
			    id INT(255) NOT NULL AUTO_INCREMENT,
			    tag VARCHAR(20),
			    PRIMARY KEY (id)
			)");
			$tag1 = serialize(new Tag("cat"));
			$tag2 = serialize(new Tag("animal"));
			$this->db->exec("INSERT INTO tags (tag) VALUES('$tag1')");
			$this->db->exec("INSERT INTO tags (tag) VALUES('$tag2')");

		}
		catch (PDOExecption $e){
			throw new PDOExecption($e->getMessage(), $e->getCode());
		}
	}

	function readImage($id){
		$rq = "SELECT nom FROM images WHERE id = :id";
		$stmt = $this->db->prepare($rq);
		$stmt->execute(array(':id' =>$id));
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$image = unserialize($res['image']);
		return $image;
	}

	function readAllImages(){
		$array = array();
		$stmt = $this->db->query("SELECT * FROM images");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value){
			$array[$value['id']] = unserialize($value['image']);
		}
		return $array;
	}

	function readTag($id){
		$rq = "SELECT nom FROM tags WHERE id = :id";
		$stmt = $this->db->prepare($rq);
		$stmt->execute(array(':id' =>$id));
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$tag = unserialize($res['tag']);
		return $tag;
	}

	function readAllTags(){
		$array = array();
		$stmt = $this->db->query("SELECT * FROM tags");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value){
			$array[$value['id']] = unserialize($value['tag']);
		}
		return $array;
	}
}
