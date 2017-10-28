<?php
$message = null;

if (isset($_POST['caption'])) {

	$objUpload = new Upload();
	$objUpload->_field_name = 'image';
	$objUpload->_path = IMAGES_PATH;
	$objUpload->_new_file_name = $_POST['caption'].'-'.date('Ymd-His');
	
	if ($objUpload->isValid() && !empty($_POST['caption'])) {
	
		if ($objUpload->send()) {
		
			// create thumbnail
			Image::crop(
				IMAGES_PATH.DS.$objUpload->_new_name,
				IMAGES_THUMBNAIL_PATH.DS.$objUpload->_new_name,
				IMAGES_THUMBNAIL_WIDTH,
				IMAGES_THUMBNAIL_HEIGHT	
			);
			
			// create large image
			Image::resize(
				IMAGES_PATH.DS.$objUpload->_new_name,
				IMAGES_LARGE_PATH.DS.$objUpload->_new_name,
				IMAGES_LARGE_LENGTH
			);
			
			$objDb = new Dbase();	
			
			$sql = "INSERT INTO `images`
					(`image`, `caption`)
					VALUES (?, ?)";
		
			if ($objDb->insert($sql, array(
				$objUpload->_new_name, $_POST['caption']
			))) {
				Helper::redirect('?page=tag&id='.$objDb->_id);
			} else {
				$message = '<p class="confirm">Image uploaded successfully, but record could not be added to the database</p>';
			}
			
		}
	
	} else {
		
		$out = array();
		
		if (empty($_POST['caption'])) {
			$out[] = 'Please provide a caption';
		}
		
		$image = $objUpload->getErrorMessage();
		
		if (!empty($image)) {
			$out[] = $image;
		}
		
		$message  = '<p class="warning">';
		$message .= implode('<br />', $out);
		$message .= '</p>';
		
	}

}

?>


<?php require_once('header.php'); ?>

<h1>Upload new image</h1>
<?php echo $message; ?>
<form action="" method="post" id="form_upload" enctype="multipart/form-data">

	<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
		<tr>
			<th><label for="caption">Caption: *</label></th>
			<td>
				<input type="text" name="caption" id="caption" class="fld"
					value="<?php echo !empty($_POST['caption']) ? 
						stripslashes($_POST['caption']) : null; ?>" size="30" />
			</td>
		</tr>
		<tr>
			<th><label for="image">Image: *</label></th>
			<td>
				<input type="file" name="image" id="image" size="20" />
				<img src="/images/loading.gif" alt="Loading"
					class="loader" width="133" height="20" />
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<input type="submit" class="button button_green" value="Submit" />
			</td>
		</tr>
	</table>

</form>

<?php require_once('footer.php'); ?>





