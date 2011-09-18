<?php

/**
 * Nomads_View
 **/
 
class Nomads_View {

	private $properties;
	
	public function __construct() {
	    $this->properties = array();
	}
	
	public function set($keyword, $value) {
		$this->properties[$keyword] = $value;
	}
	
	public function show($file) {
		include(APPLICATION_PATH.'/view/'.$file);
	}
	
	public function get($keyword) {
		if (isset($this->properties[$keyword])) {
			return $this->properties[$keyword];
		}
		return '';
	}
}

