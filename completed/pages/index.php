<?php
$objDb = new Dbase();
$search = array();

$objPaging = new Paging();

$offset = $objPaging->_current_page * IMAGES_PER_PAGE;

if (isset($_GET['search']) && !empty($_GET['search'])) {
	
	$search[] = "%{$_GET['search']}%";
	
	$sql = "SELECT DISTINCT `i`.*
			FROM `images` `i`
			LEFT JOIN `tags` `t`
				ON `t`.`image` = `i`.`id`
			WHERE `t`.`label` LIKE ?
			ORDER BY `i`.`caption` ASC";
			
	$sql_limit = $sql." LIMIT {$offset}, ".IMAGES_PER_PAGE;

} else {
	
	$sql = "SELECT *
			FROM `images`
			ORDER BY `caption` ASC";
			
	$sql_limit = $sql." LIMIT {$offset}, ".IMAGES_PER_PAGE;
}

$records_all = $objDb->getAll($sql, $search);
$records = $objDb->getAll($sql_limit, $search);

$max_pages = ceil(count($records_all) / IMAGES_PER_PAGE);

$paging = $objPaging->getLinks($max_pages);

?>
<?php require_once('header.php'); ?>

<h1>List of images</h1>

<form action="" method="get" id="search_form">
	<input type="text" name="search" id="search" class="fld"
		value="<?php echo !empty($_GET['search']) ? stripslashes($_GET['search']) : null; ?>" size="30" />
	<input type="submit" class="button button_green" value="Search" />
</form>

<?php if (!empty($records)) { ?>

	<?php 
		$i = 1; 
		foreach($records as $row) { 
			
			$image_dir = DS.IMAGES_THUMBNAIL_DIR.DS.$row['image'];
			$image_path = IMAGES_THUMBNAIL_PATH.DS.$row['image'];
			
			if (is_file($image_path)) {
	?>
		
		<div class="image_wrapper<?php echo $i%5 === 0 ? ' last' : null; ?>">
			
			<a href="?page=tag&amp;id=<?php echo $row['id']; ?>">
				<img src="<?php echo $image_dir; ?>"
					width="<?php echo IMAGES_THUMBNAIL_WIDTH; ?>"
					height="<?php echo IMAGES_THUMBNAIL_HEIGHT; ?>"
					alt="<?php echo $row['caption']; ?>" />
			</a>
			<a href="#" class="remove_image" rel="<?php echo $row['id']; ?>">
				Remove
			</a>
			
		</div>
		
	<?php $i++; } } ?>
	
	<?php echo $paging; ?>

<?php } else { ?>

	<p>There are no records available.</p>

<?php } ?>


<?php require_once('footer.php'); ?>








