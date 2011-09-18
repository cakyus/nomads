<?php

class Nomads_Config {

	private $properties;
	
	public function __construct() {
		
	    // loading configuration file
		if (is_file(APPLICATION_PATH.'/config.php')) {
			include(APPLICATION_PATH.'/config.php');
			$this->properties = $config;
		} else {
			$this->properties = array();
		}
	}
	
	public function set($keyword, $value) {
		$this->properties[$keyword] = $value;
	}
	
	public function get($keyword) {
		if (isset($this->properties[$keyword])) {
			return $this->properties[$keyword];
		}
		return '';
	}
}

