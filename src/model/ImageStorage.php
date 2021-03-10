<?php
require_once("model/Image.php");
interface ImageStorage {
	public function readImage($id);
	public function readAllImages();

	public function readTag($id);
	public function readAllTags();
}
