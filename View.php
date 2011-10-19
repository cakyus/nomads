<?php

/**
 * Nomads_View
 **/

class Nomads_View {

	private $properties;
	
	public function __construct() {
	    $this->properties = array();
		// special properties
		$this->set('rootURL', dirname($_SERVER['SCRIPT_NAME']));
	}
	
	public function set($keyword, $value=null) {
		
		if (is_string($keyword)) {
			$this->properties[$keyword] = $value;
		} else {
			$this->properties = array_merge($this->properties, (array)$keyword);
		}
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

