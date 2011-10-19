<?php

class Nomads_Request_Path extends Nomads_Collection {
	
	public function __construct() {
		parent::__construct();
		
		$path = substr($_SERVER['REQUEST_URI']
			,strlen(dirname($_SERVER['SCRIPT_NAME'])) + 1
			);
		
		if ($path == false) {
			return false;
		}

		$path = explode('/',$path);
		
		$this->items = $path;
	}
	
	public function getPath() {
		return implode('/', $this->items);
	}
	
	public function getItems() {
		return $this->items;
	}
}

