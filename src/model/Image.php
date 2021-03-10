<?php

class Image {
	public $nom;
	public $tags;
	public $tagsAlt; //tags alternatifs

	function __construct($nom, $tags) {
		$this->nom  = $nom;
		$this->tags = $tags;
	}

	public function getName()   { return $this->nom;       }

	public function getTag($id) { return $this->tags[$id]; }

	public function getTags()   { return $this->tags;      }


	public function setName($name)   { $this->nom    = $name;  }

	public function addTag($tag)   { array_push($this->tags, $tag);  }
}
