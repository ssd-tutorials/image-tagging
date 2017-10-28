<?php
class Upload {

	// name of the field
	public $_field_name = 'image';
	
	// new file name
	public $_new_file_name;
	
	// new file name ready to upload
	public $_new_name;
	
	// max file size (default 1MB)
	public $_file_size = 1048576;
	
	// allowed extensions
	public $_extensions = array('jpg', 'jpeg', 'png', 'gif');
	
	// extension of the file
	public $_extension;
	
	// path with directory name to upload to
	public $_path;
	
	// whether validation has been performed
	private $_valid = false;
	
	// error index
	public $_error;
	
	// array of error messages
	public $_validation = array(
		'file_size' => 'The uploaded file exceeds the maximum file size of 1MB',
		'extension' => 'Wrong file format',
		'name'		=> 'File with this name already exists',
		1			=> 'The uploaded file exceeds the maximum file size',
		2			=> 'The uploaded file exceeds the maximum file size',
		3			=> 'The uploaded file was only partially uploaded',
		4			=> 'No file was selected',
		6			=> 'Missing a temporary folder',
		7			=> 'Failed to write file to disk',
		8			=> 'Problem with the extension'
	);
	
	
	
	
	
	
	
	
	
	
	
	public function isValid() {
		if (!empty($_FILES)) {
			$this->_error = $_FILES[$this->_field_name]['error'];
			$this->_valid = true;
			if ($this->_error === 0) {
				if (!$this->checkExtension()) {
					return false;
				}
				if (!$this->checkSize()) {
					return false;
				}
				if (!$this->checkName()) {
					return false;
				}
				return true;
			}
			return false;
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	private function checkExtension() {
		$this->_extension = self::getExtension($_FILES[$this->_field_name]['name']);
		if (!in_array($this->_extension, $this->_extensions)) {
			$this->_error = 'extension';
			return false;
		}
		return true;
	}
	
	
	
	
	
	
	
	
	
	
	public static function getExtension($file_name = null) {
		if (!empty($file_name)) {
			$file = explode('.', $file_name);
			if (!empty($file)) {
				return array_pop($file);
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	private function checkSize() {
		if ($_FILES[$this->_field_name]['size'] > $this->_file_size) {
			$this->_error = 'file_size';
			return false;
		}
		return true;
	}
	
	
	
	
	
	
	
	
	
	
	
	private function checkName() {
		if (!empty($this->_new_file_name)) {
			$this->_new_name = Helper::sanitise($this->_new_file_name).'.'.$this->_extension;
		} else {
			$this->_new_name = Helper::sanitise($_FILES[$this->_field_name]['name']);
		}
		
		if (is_file($this->_path.DS.$this->_new_name)) {
			$this->_error = 'name';
			return false;
		}
		return true;
	}
	
	
	
	
	
	
	
	
	
	
	public function send() {
		if ($this->_valid && is_dir($this->_path)) {
			if (move_uploaded_file($_FILES[$this->_field_name]['tmp_name'], $this->_path.DS.$this->_new_name)) {
				return true;
			}
			return false;
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	public function getErrorMessage() {
		if (!empty($this->_error)) {
			return $this->_validation[$this->_error];
		}
	}
	
	
	
	
	







}