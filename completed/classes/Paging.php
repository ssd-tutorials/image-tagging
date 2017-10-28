<?php
class Paging {

	public $_max_pages;
	public $_current_page = 0;
	public $_first_page;
	public $_last_page;
	public $_next_page;
	public $_previous_page;
	public $_url;
	public static $_key = 'pg';
	
	
	
	
	public function __construct() {
		$this->fetchParams();
	}
	
	
	
	
	
	
	
	
	
	public function fetchParams() {
	
		if (isset($_GET)) {
			$out = array();
			foreach($_GET as $key => $value) {
				if ($key == self::$_key) {
					$this->_current_page = $value;
				} else {
					if (!empty($value)) {
						$out[] = $key.'='.$value;
					}
				}
			}
			$this->_url = !empty($out) ? '?'.implode('&amp;', $out) : null;
		}
	
	}
	
	
	
	
	
	
	
	
	
	
	public function renderLinks() {
	
		if ($this->_max_pages > 1) {
			
			// first page / previous page
			if ($this->_current_page > 0) {
				$this->_first_page = $this->_url;
				if ($this->_current_page > 1) {
					$this->_previous_page = $this->generateUrl(array(
						self::$_key => ($this->_current_page - 1)
					));
				} else {
					$this->_previous_page = $this->_url;
				}
			}
			
			// last page / next page
			if (($this->_current_page + 1) < $this->_max_pages) {
				$this->_last_page = $this->generateUrl(array(
					self::$_key => ($this->_max_pages - 1)
				));
				$this->_next_page = $this->generateUrl(array(
					self::$_key => ($this->_current_page + 1)
				));
			}
		
			
			
		}
	
	}
	
	
	
	
	
	
	
	public function generateUrl($params = null) {
		if (!empty($params) && is_array($params)) {
			$out = array();
			foreach($params as $key => $value) {
				$out[] = $key.'='.$value;
			}
			if (!empty($out)) {
				return !empty($this->_url) ? 
					$this->_url.'&amp;'.implode('&amp;', $out) :
					'?'.implode('&amp;', $out);
			} else {
				return !empty($this->_url) ?
					$this->_url :
					null;
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function getLinks($max_pages = null) {
		
		$this->_max_pages = $max_pages;
		
		$this->renderLinks();
		
		$out = array();
		
		// first link
		if (!empty($this->_first_page)) {
			$out[] = $this->setLink($this->_first_page, 'First');
		} else {
			$out[] = $this->setSpan('First');
		}
		
		// previous link
		if (!empty($this->_previous_page)) {
			$out[] = $this->setLink($this->_previous_page, 'Previous');
		} else {
			$out[] = $this->setSpan('Previous');
		}
		
		// next link
		if (!empty($this->_next_page)) {
			$out[] = $this->setLink($this->_next_page, 'Next');
		} else {
			$out[] = $this->setSpan('Next');
		}
		
		// last link
		if (!empty($this->_last_page)) {
			$out[] = $this->setLink($this->_last_page, 'Last');
		} else {
			$out[] = $this->setSpan('Last');
		}
		
		$return  = '<ul id="paging">';
		$return .= '<li>'.implode('</li><li>', $out).'</li>';
		$return .= '</ul>';
		
		return $return;
		
	}
	
	
	
	
	
	
	
	
	
	
	public function setLink($url = null, $label = null) {
		if (!empty($url)) {
			return '<a href="'.$url.'">'.$label.'</a>';
		}
	}
	
	
	
	
	
	
	
	
	
	
	public function setSpan($label = null) {
		if (!empty($label)) {
			return '<span>'.$label.'</span>';
		}
	}
	
	
	
	



}





