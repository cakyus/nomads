<?php

class Nomads_Application {
	
	public $mode;
	public $path;
	
	public function __construct() {
		$this->mode = APPLICATION_MODE;
		$this->path = APPLICATION_PATH;
	}
	
	public function start() {
		
		// set autoloader
		include('Loader.php');
		Nomads_Loader::setAutoload();

		$controller = new Index_Controller;
		$controller->index();
	}
}
