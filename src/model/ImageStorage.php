<?php
require_once("Image.php");
interface ImageStorage {
	public function addImage(Image $image);
	public function readImage($id);
	public function readAllImages();

	public function addTag(Tag $tag);
	public function readTag($id);
	public function readAllTags();
}
