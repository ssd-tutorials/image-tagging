<?php
class Image {

	public static $_path = '/usr/bin/convert';

	
	
	
	
	
	
	public static function crop($from = null, $to = null, $width = 100, $height = 100) {
		
		if (is_file($from)) {
		
			$to = !empty($to) ? $to : $from;
			
			$imginfo = getimagesize($from);
			$original_w = $imginfo[0];
			$original_h = $imginfo[1];
			
			$longest_new = $width > $height ? $width : $height;
			$longest_original = $original_w > $original_h ? $original_w : $original_h;
			
			if ($longest_original > $longest_new) {
				
				$command = self::$_path." {$from} -resize {$longest_new}x{$longest_new}^ -gravity Center -crop {$width}x{$height}+0+0 {$to}";
				
			} else {
				$command = self::$_path." {$from} -gravity Center -crop {$width}x{$height}+0+0 {$to}";
			}
			
			exec($command);
		
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public static function resize($from = null, $to = null, $width = 600) {
		
		if (is_file($from)) {
		
			$to = !empty($to) ? $to : $from;
			
			$imginfo = getimagesize($from);
			$original_w = $imginfo[0];
			$original_h = $imginfo[1];
			
			$longest_original = $original_w > $original_h ? $original_w : $original_h;
			
			if ($longest_original > $width) {
				
				$command = self::$_path." {$from} -resize {$width}x{$width}\> {$to}";
				exec($command);
				
			} else {
				
				copy($from, $to);
				
			}
			
		
		}
		
	}
	
	
	
	
	
	
	
	
	
	public static function size($file = null, $index = null) {
	
		if (is_file($file)) {
			list($width, $height, $type, $attr) = getimagesize($file);
			switch($index) {
				case 'w':
				return $width;
				break;
				case 'h':
				return $height;
				break;
				case 't':
				return $type;
				break;
				default:
				return $attr;
			}			
		}
	
	}
	
	
	
	
	
	
	
	
	
	
	public static function remove($image = null) {
		if (is_file($image) && unlink($image)) {
			return true;
		}
		return false;
	}
	
	
	
	
	
	


}