<?php
require_once('../inc/autoload.php');

if (
	!empty($_GET['id']) && !empty($_GET['label']) &&
	!empty($_GET['view_top']) && !empty($_GET['view_left']) &&
	!empty($_GET['tooltip_top']) && !empty($_GET['tooltip_left'])
) {
	
	$objDb = new Dbase();
	
	$sql = "INSERT INTO `tags`
			(`image`, `label`, `view_top`, `view_left`, `tooltip_top`, `tooltip_left`)
			VALUES (?, ?, ?, ?, ?, ?)";
			
	if ($objDb->insert($sql, array(
		$_GET['id'],
		$_GET['label'],
		$_GET['view_top'],
		$_GET['view_left'],
		$_GET['tooltip_top'],
		$_GET['tooltip_left']
	))) {
		
		$id = $objDb->_id;
		
		$div_view  = '<div class="tag-outline" id="view_'.$id.'"';
		$div_view .= ' style="top:'.$_GET['view_top'].'px;';
		$div_view .= 'left:'.$_GET['view_left'].'px;"> </div>';
		
		$div_tooltip  = '<div class="tag-tooltip" id="tooltip_view_'.$id.'"';
		$div_tooltip .= ' style="top:'.$_GET['tooltip_top'].'px;';
		$div_tooltip .= 'left:'.$_GET['tooltip_left'].'px;">';
		$div_tooltip .= stripslashes($_GET['label']).'</div>';
		
		$span_link  = '<span class="view_'.$id.'">@ ';
		$span_link .= stripslashes($_GET['label']);
		$span_link .= ' (<a href="#" class="remove">remove</a>) </span>';
		
		echo json_encode(array(
			'error' => false,
			'div_view' => $div_view,
			'div_tooltip' => $div_tooltip,
			'span_link' => $span_link
		));
		
	} else {
		echo json_encode(array('error' => true));
	}
	
	
} else {
	echo json_encode(array('error' => true));
}








