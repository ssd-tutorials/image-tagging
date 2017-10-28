<?php
if (isset($_GET['id'])) {

	$id = $_GET['id'];
	$objDb = new Dbase();
	$sql = "SELECT *
			FROM `images`
			WHERE `id` = ?";
	$record = $objDb->getOne($sql, $id);
	
	if (!empty($record)) {
	
		$image_dir = DS.IMAGES_LARGE_DIR.DS.$record['image'];
		$image_path = IMAGES_LARGE_PATH.DS.$record['image'];
		
		$width = Image::size($image_path, 'w');
		$height = Image::size($image_path, 'h');
		
		$sql = "SELECT *
				FROM `tags`
				WHERE `image` = ?";
		$tags = $objDb->getAll($sql, $record['id']);

?>

<?php require_once('header.php'); ?>

<h1>Apply tags to the image <?php echo $record['caption']; ?></h1>

<div id="image_container">
	
	<div id="image" style="width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;">
		<img src="<?php echo $image_dir; ?>" width="<?php echo $width; ?>"
			height="<?php echo $height; ?>" alt="<?php echo $record['caption']; ?>" />
		<?php if (!empty($tags)) { ?>
			
			<?php foreach($tags as $row) { ?>
				
				<div id="view_<?php echo $row['id']; ?>" 
					class="tag-outline"
					style="top:<?php echo $row['view_top']; ?>px; 
					left:<?php echo $row['view_left']; ?>px;"> </div>
				<div id="tooltip_view_<?php echo $row['id']; ?>" 
					class="tag-tooltip"
					style="top:<?php echo $row['tooltip_top']; ?>px; 
					left:<?php echo $row['tooltip_left']; ?>px;"> 
				<?php echo $row['label']; ?>
				</div>
				
			<?php } ?>
			
		<?php } ?>
	</div>	
	
	<div class="dn" id="image_id"><?php echo $id; ?></div>
	
</div>

<div id="tags">

	<?php if (!empty($tags)) { ?>
		
		<?php foreach($tags as $row) { ?>
			<span class="view_<?php echo $row['id']; ?>">
				 @ <?php echo $row['label']; ?> 
				(<a href="#" class="remove">remove</a>)
			</span>
		<?php } ?>
		
	<?php } ?>

</div>


<?php require_once('footer.php'); ?>

<?php } } ?>







