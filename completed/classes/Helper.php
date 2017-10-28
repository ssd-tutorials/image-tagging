<?php
class Helper {



	public static function sanitise($string = null) {
		if (!empty($string)) {
			$string = strtolower(trim($string));
			$string = preg_replace("/[^A-Za-z0-9.\s]/", "", $string);
			return preg_replace("/[\s]/", "-", $string);
		}
	}
	
	
	
	
	
	
	
	public static function makeArray($array = null) {
		return is_array($array) ? $array : array($array);
	}
	
	
	
	
	
	
	
	
	
	
	public static function redirect($location = null) {
		if (!empty($location)) {
			header("Location: {$location}");
			exit;
		}
	}
	
	
	
	
	




}