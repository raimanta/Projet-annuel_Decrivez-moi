<?php
require_once("ImageStorage.php");
require_once("Image.php");
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
			    image VARCHAR(3000),
			    PRIMARY KEY (id)
			)");
			$img = serialize(new Image("Abeille", "3168189778", "https://live.staticflickr.com/1064/3168189778_00e44690fe.jpg", "terpino"));
			$this->db->exec("INSERT INTO images (image) VALUES('$img')");

			$img = serialize(new Image("Heart of a flower", "4000886283", "https://live.staticflickr.com/3486/4000886283_1d124fa4c0.jpg", "**soniatravel**"));
			$this->db->exec("INSERT INTO images (image) VALUES('$img')");

			$img = serialize(new Image("Bohol, Philippines (May 2007)", "509221021", "https://live.staticflickr.com/210/509221021_387e26b226.jpg", "terpino"));
			$this->db->exec("INSERT INTO images (image) VALUES('$img')");

			$img = serialize(new Image("kuroshio sea", "3852077735", "https://live.staticflickr.com/2434/3852077735_ff87893606.jpg", "tharaka"));
			$this->db->exec("INSERT INTO images (image) VALUES('$img')");

			$img = serialize(new Image("Whale Shark", "2598684913", "https://live.staticflickr.com/3143/2598684913_5c6348b391.jpg", "KiksBalayon"));
			$this->db->exec("INSERT INTO images (image) VALUES('$img')");

			$img = serialize(new Image("Hell Sunset", "4089964602", "https://live.staticflickr.com/2567/4089964602_cfdebe8827.jpg", "Antonio Goya"));
			$this->db->exec("INSERT INTO images (image) VALUES('$img')");
		}
		catch (PDOExecption $e){
			throw new PDOExecption($e->getMessage(), $e->getCode());
		}
	}

	public function addImage(Image $image){
		$img = serialize($image);
		$this->db->exec("INSERT INTO images (image) VALUES('$img')");
	}

	public function readImage($id){
		$rq = "SELECT nom FROM images WHERE id = :id";
		$stmt = $this->db->prepare($rq);
		$stmt->execute(array(':id' =>$id));
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$image = unserialize($res['image']);
		return $image;
	}

	public function readAllImages(){
		$array = array();
		$stmt = $this->db->query("SELECT * FROM images");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value){
			$array[$value['id']] = unserialize($value['image']);
		}
		return $array;
	}
}
