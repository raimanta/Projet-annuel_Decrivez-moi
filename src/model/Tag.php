<?php

class Tag {
	public $nom;

	function __construct($nom){
		$this->nom  = $nom;
	}

	public function getNameTag()   { return $this->nom; }


	public function setNameTag($name)   { $this->nom = $name;  }
}
