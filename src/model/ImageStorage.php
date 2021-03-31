<?php
require_once("Image.php");
interface ImageStorage {
	public function addImage(Image $image);
	public function readImage($id);
	public function readAllImages();
}
