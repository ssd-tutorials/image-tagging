<?php
require_once('../inc/autoload.php');

if (!empty($_GET['id'])) {
	
	$objDb = new Dbase();
	
	$sql = "SELECT * 
			FROM `images`
			WHERE `id` = ?";
	
	$image = $objDb->getOne($sql, $_GET['id']);
	
	if (!empty($image)) {
	
		Image::remove(IMAGES_PATH.DS.$image['image']);
		Image::remove(IMAGES_THUMBNAIL_PATH.DS.$image['image']);
		Image::remove(IMAGES_LARGE_PATH.DS.$image['image']);
		
		$sql = "DELETE FROM `images`
				WHERE `id` = ?";
				
		if ($objDb->execute($sql, $_GET['id'])) {
			echo json_encode(array('error' => false));
		} else {
			echo json_encode(array('error' => true));
		}
	
	} else {
		echo json_encode(array('error' => true));
	}
	
} else {
	echo json_encode(array('error' => true));
}



