<?php
// directory separator
defined("DS")
	|| define("DS", DIRECTORY_SEPARATOR);
	
// root path
defined("ROOT_PATH")
	|| define("ROOT_PATH", realpath(dirname(__FILE__) . DS."..".DS));	
	
// classes path
defined("CLASSES_PATH")
	|| define("CLASSES_PATH", ROOT_PATH.DS.'classes');
	
// template path
defined("TEMPLATE_PATH")
	|| define("TEMPLATE_PATH", ROOT_PATH.DS.'template');
	
// images directory
defined("IMAGES_DIR")
	|| define("IMAGES_DIR", 'media');
		
// images thumbnail directory
defined("IMAGES_THUMBNAIL_DIR")
	|| define("IMAGES_THUMBNAIL_DIR", IMAGES_DIR.DS.'thumbnail');	
	
// images large directory
defined("IMAGES_LARGE_DIR")
	|| define("IMAGES_LARGE_DIR", IMAGES_DIR.DS.'large');	
	
// images path
defined("IMAGES_PATH")
	|| define("IMAGES_PATH", ROOT_PATH.DS.IMAGES_DIR);	
	
// images thumbnail path
defined("IMAGES_THUMBNAIL_PATH")
	|| define("IMAGES_THUMBNAIL_PATH", ROOT_PATH.DS.IMAGES_THUMBNAIL_DIR);	
	
// images large path
defined("IMAGES_LARGE_PATH")
	|| define("IMAGES_LARGE_PATH", ROOT_PATH.DS.IMAGES_LARGE_DIR);	
	
// thumbnail width
defined("IMAGES_THUMBNAIL_WIDTH")
	|| define("IMAGES_THUMBNAIL_WIDTH", 108);

// thumbnail height
defined("IMAGES_THUMBNAIL_HEIGHT")
	|| define("IMAGES_THUMBNAIL_HEIGHT", 75);

// large image longest edge
defined("IMAGES_LARGE_LENGTH")
	|| define("IMAGES_LARGE_LENGTH", 600);

// number of images per page
defined("IMAGES_PER_PAGE")
	|| define("IMAGES_PER_PAGE", 10);

	
set_include_path(implode(PATH_SEPARATOR, array(
	realpath(ROOT_PATH),
	realpath(CLASSES_PATH),
	realpath(TEMPLATE_PATH),
	get_include_path()
)));
	
	
	
	
	
	
	
	
	
	