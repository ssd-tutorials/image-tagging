<?php
require_once('../inc/autoload.php');

if (!empty($_GET['id'])) {
	
	$objDb = new Dbase();
	
	$sql = "DELETE FROM `tags`
			WHERE `id` = ?";
	
	if ($objDb->execute($sql, $_GET['id'])) {
		echo json_encode(array('error' => false));
	} else {
		echo json_encode(array('error' => true));
	}
	
} else {
	echo json_encode(array('error' => true));
}