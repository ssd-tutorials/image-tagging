<?php
class Core {

	public function run() {
		
		if (empty($_GET['page'])) {
			$_GET['page'] = 'index';
		}
		
		$page = 'pages'.DS.$_GET['page'].'.php';
		
		ob_start();
		
		if (is_file($page)) {
			require_once($page);
		} else {
			require_once('pages'.DS.'error.php');
		}
		
		echo ob_get_clean();
		
	}






}