<?php

/**
 * Nomads_View
 **/
 
class Nomads_View {

	private $properties;
	
	public function __construct() {
	    $this->properties = array();
	}
	
	public function assign($keyword, $value) {
		$this->properties[$keyword] = $value;
	}
	
	public function render($file) {
		include(APPLICATION_PATH.'/view/'.$file);
	}
	
	public function __get($keyword) {
		if (isset($this->properties[$keyword])) {
			return $this->properties[$keyword];
		}
		return '';
	}
}

