<?php

class Image {
	public $nom;
	public $id;
	public $url;
	public $author;

	function __construct($nom, $id, $url, $author) {

		$this->nom  = $nom;
		$this->id   = $id; 
		$this->url  = $url;
		$this->author = $author;
	}

	public function equals($image) {
		return $this->nom    === $nom    &&
			   $this->id     === $id     &&
		       $this->url    === $url    &&
		       $this->author === $author;
	}

	public function getName()  { return $this->nom;          }
	public function getID()    { return $this->id;           }
	public function getUrl()   { return $this->url;          }
	public function getAuthor(){ return $this->author;       }

	public function setName($name)    { $this->nom    = $name;  }
	public function setID($id)        { $this->id     = $id;    }
	public function setUrl($url)      { $this->url    = $url;   }
	public function setAuthor($author){ $this->author = $author;}

}
